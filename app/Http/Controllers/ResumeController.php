<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use setasign\Fpdi\Tcpdf\Fpdi;
use Carbon\Carbon;

class ResumeController extends Controller
{
    /**
     * 履歴書作成ページを表示
     */
    public function index(Request $request): View
    {
        $showConfirm = $request->session()->get('show_confirm', false) || $request->query('showConfirm') == '1';
        $request->session()->forget('show_confirm');
        
        // セッションから履歴書データを取得（確認画面表示時）
        $resumeData = session('resume_data');
        
        // デバッグ: セッションの状態をログに記録
        if ($showConfirm) {
            \Log::info('Resume index - showConfirm is true');
            \Log::info('Resume index - Session ID: ' . $request->session()->getId());
            \Log::info('Resume index - Session resume_data exists: ' . ($resumeData ? 'yes' : 'no'));
            \Log::info('Resume index - All session keys: ' . implode(', ', array_keys($request->session()->all())));
        }
        
        // セッションにデータがない場合、ログインしている場合は最新の履歴書データを取得
        if (!$resumeData && Auth::check()) {
            $latestResume = Resume::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestResume) {
                $resumeData = [
                    'first_name_roman' => $latestResume->first_name_roman,
                    'last_name_roman' => $latestResume->last_name_roman,
                    'first_name_kana' => $latestResume->first_name_kana,
                    'last_name_kana' => $latestResume->last_name_kana,
                    'birthday' => $latestResume->birthday ? $latestResume->birthday->format('Y-m-d') : null,
                    'gender' => $latestResume->gender,
                    'phone' => $latestResume->phone,
                    'email' => $latestResume->email,
                    'postal_code' => $latestResume->postal_code,
                    'address' => $latestResume->address,
                    'address_kana' => $latestResume->address_kana,
                    'education' => $latestResume->education ?? [],
                    'work_history' => $latestResume->work_history ?? [],
                    'licenses' => $latestResume->licenses ?? [],
                    'appeal_points' => $latestResume->appeal_points,
                    'self_request' => $latestResume->self_request,
                ];
            }
        }
        
        return view('resume.index', compact('showConfirm', 'resumeData'));
    }
    
    /**
     * 履歴書作成フォームを表示
     */
    public function create(): View
    {
        return view('resume.create');
    }

    /**
     * 内容確認画面用データ処理
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'first_name_roman' => 'required|string|max:25',
            'last_name_roman' => 'required|string|max:25',
            'first_name_kana' => 'required|string|max:25',
            'last_name_kana' => 'required|string|max:25',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:男,女',
            'phone' => 'required|string|regex:/^\d{10,11}$/',
            'email' => 'required|email|max:255',
            'postal_code' => 'required|string|regex:/^\d{7}$/',
            'address' => 'required|string|max:150',
            'address_kana' => 'required|string|max:200',
            'school_name' => 'required|array',
            'school_event_type' => 'required|array',
            'school_date' => 'required|array',
            'company_name' => 'required|array',
            'job_event_type' => 'required|array',
            'job_date' => 'required|array',
            'license_name' => 'nullable|array',
            'license_date' => 'nullable|array',
            'appeal_points' => 'nullable|string|max:624',
            'self_request' => 'nullable|string|max:260',
        ]);

        // 学歴データを整理
        $education = [];
        foreach ($validated['school_name'] as $index => $schoolName) {
            if (!empty($schoolName) && !empty($validated['school_event_type'][$index]) && !empty($validated['school_date'][$index])) {
                $education[] = [
                    'school_name' => $schoolName,
                    'event_type' => $validated['school_event_type'][$index],
                    'date' => $validated['school_date'][$index],
                ];
            }
        }

        // 職歴データを整理
        $workHistory = [];
        foreach ($validated['company_name'] as $index => $companyName) {
            if (!empty($companyName) && !empty($validated['job_event_type'][$index]) && !empty($validated['job_date'][$index])) {
                $workHistory[] = [
                    'company_name' => $companyName,
                    'event_type' => $validated['job_event_type'][$index],
                    'date' => $validated['job_date'][$index],
                ];
            }
        }

        // 免許・資格データを整理
        $licenses = [];
        if (isset($validated['license_name']) && isset($validated['license_date'])) {
            foreach ($validated['license_name'] as $index => $licenseName) {
                if (!empty($licenseName) && !empty($validated['license_date'][$index] ?? '')) {
                    $licenses[] = [
                        'name' => $licenseName,
                        'date' => $validated['license_date'][$index],
                    ];
                }
            }
        }

        // セッションに保存
        $resumeData = [
            'first_name_roman' => $validated['first_name_roman'],
            'last_name_roman' => $validated['last_name_roman'],
            'first_name_kana' => $validated['first_name_kana'],
            'last_name_kana' => $validated['last_name_kana'],
            'birthday' => $validated['birthday'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
            'address_kana' => $validated['address_kana'],
            'education' => $education,
            'work_history' => $workHistory,
            'licenses' => $licenses,
            'appeal_points' => $validated['appeal_points'] ?? null,
            'self_request' => $validated['self_request'] ?? null,
        ];

        // セッションに保存（PDF生成用に保持）
        $request->session()->put('resume_data', $resumeData);
        $request->session()->put('show_confirm', true);
        $request->session()->save(); // セッションを明示的に保存
        
        // デバッグ: セッション保存後の状態をログに記録
        \Log::info('Resume confirm - Session resume_data saved');
        \Log::info('Resume confirm - Session ID: ' . $request->session()->getId());
        \Log::info('Resume confirm - Session resume_data exists: ' . (session('resume_data') ? 'yes' : 'no'));

        // 内容確認画面のHTMLを返す（AJAXリクエストの場合）
        if ($request->expectsJson() || $request->wantsJson()) {
            $html = view('resume.confirm', compact('resumeData'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        }
        
        // 通常のPOSTリクエストの場合（フォールバック）
        return redirect()->route('resume.index')->with('show_confirm', true);
    }

    /**
     * 履歴書データをセッションに保存し、選択画面へリダイレクト
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name_roman' => 'required|string|max:25',
            'last_name_roman' => 'required|string|max:25',
            'first_name_kana' => 'required|string|max:25',
            'last_name_kana' => 'required|string|max:25',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:男,女',
            'phone' => 'required|string|regex:/^\d{10,11}$/',
            'email' => 'required|email|max:255',
            'postal_code' => 'required|string|regex:/^\d{7}$/',
            'address' => 'required|string|max:150',
            'address_kana' => 'required|string|max:200',
            'school_name' => 'required|array',
            'school_event_type' => 'required|array',
            'school_date' => 'required|array',
            'company_name' => 'required|array',
            'job_event_type' => 'required|array',
            'job_date' => 'required|array',
            'license_name' => 'nullable|array',
            'license_date' => 'nullable|array',
            'appeal_points' => 'nullable|string|max:624',
            'self_request' => 'nullable|string|max:260',
        ]);

        // 学歴データを整理
        $education = [];
        foreach ($validated['school_name'] as $index => $schoolName) {
            if (!empty($schoolName) && !empty($validated['school_event_type'][$index]) && !empty($validated['school_date'][$index])) {
                $education[] = [
                    'school_name' => $schoolName,
                    'event_type' => $validated['school_event_type'][$index],
                    'date' => $validated['school_date'][$index],
                ];
            }
        }

        // 職歴データを整理
        $workHistory = [];
        foreach ($validated['company_name'] as $index => $companyName) {
            if (!empty($companyName) && !empty($validated['job_event_type'][$index]) && !empty($validated['job_date'][$index])) {
                $workHistory[] = [
                    'company_name' => $companyName,
                    'event_type' => $validated['job_event_type'][$index],
                    'date' => $validated['job_date'][$index],
                ];
            }
        }

        // 免許・資格データを整理
        $licenses = [];
        if (isset($validated['license_name']) && isset($validated['license_date'])) {
            foreach ($validated['license_name'] as $index => $licenseName) {
                if (!empty($licenseName) && !empty($validated['license_date'][$index] ?? '')) {
                    $licenses[] = [
                        'name' => $licenseName,
                        'date' => $validated['license_date'][$index],
                    ];
                }
            }
        }

        // セッションに保存
        $resumeData = [
            'first_name_roman' => $validated['first_name_roman'],
            'last_name_roman' => $validated['last_name_roman'],
            'first_name_kana' => $validated['first_name_kana'],
            'last_name_kana' => $validated['last_name_kana'],
            'birthday' => $validated['birthday'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
            'address_kana' => $validated['address_kana'],
            'education' => $education,
            'work_history' => $workHistory,
            'licenses' => $licenses,
            'appeal_points' => $validated['appeal_points'] ?? null,
            'self_request' => $validated['self_request'] ?? null,
        ];

        session(['pending_resume' => $resumeData]);

        return redirect()->route('resume.choose-auth');
    }

    /**
     * 履歴書データを保存（API）
     */
    public function save(Request $request)
    {
        $resumeData = session('resume_data');
        
        if (!$resumeData) {
            return response()->json([
                'success' => false,
                'message' => '履歴書データが見つかりませんでした。'
            ], 400);
        }

        // ログインしている場合は保存
        if (Auth::check()) {
            try {
                // データベースカラムが存在するか確認し、存在しない場合はマイグレーションを実行
                $this->ensureAddressKanaColumnExists();
                
                Resume::create([
                    'user_id' => Auth::id(),
                    'first_name_roman' => $resumeData['first_name_roman'] ?? '',
                    'last_name_roman' => $resumeData['last_name_roman'] ?? '',
                    'first_name_kana' => $resumeData['first_name_kana'] ?? '',
                    'last_name_kana' => $resumeData['last_name_kana'] ?? '',
                    'birthday' => $resumeData['birthday'] ?? null,
                    'gender' => $resumeData['gender'] ?? '',
                    'phone' => $resumeData['phone'] ?? '',
                    'email' => $resumeData['email'] ?? '',
                    'postal_code' => $resumeData['postal_code'] ?? '',
                    'address' => $resumeData['address'] ?? '',
                    'address_kana' => $resumeData['address_kana'] ?? '',
                    'education' => $resumeData['education'] ?? [],
                    'work_history' => $resumeData['work_history'] ?? [],
                    'licenses' => $resumeData['licenses'] ?? [],
                    'appeal_points' => $resumeData['appeal_points'] ?? null,
                    'self_request' => $resumeData['self_request'] ?? null,
                    'status' => 'completed',
                ]);

                // セッションから削除
                session()->forget('resume_data');

                return response()->json([
                    'success' => true,
                    'message' => '履歴書を保存しました。'
                ]);
            } catch (\Exception $e) {
                \Log::error('Resume save error: ' . $e->getMessage());
                \Log::error('Resume save error trace: ' . $e->getTraceAsString());
                \Log::error('Resume data keys: ' . implode(', ', array_keys($resumeData ?? [])));
                
                // データベースカラムが存在しない場合のエラーメッセージ
                $errorMessage = $e->getMessage();
                if (str_contains($errorMessage, "Unknown column 'address_kana'") || 
                    str_contains($errorMessage, "Column 'address_kana' doesn't exist")) {
                    $errorMessage = 'データベースのマイグレーションが必要です。管理者に連絡してください。';
                }
                
                return response()->json([
                    'success' => false,
                    'message' => '保存に失敗しました: ' . $errorMessage
                ], 500);
            }
        } else {
            // 未ログインの場合は会員登録ページに遷移
            // セッションに保存（会員登録後に保存される）
            session(['pending_resume' => $resumeData]);
            // resume_dataも保持しておく（PDF生成のため）
            session(['resume_data' => $resumeData]);
            
            return response()->json([
                'success' => true,
                'redirect' => route('register')
            ]);
        }
    }
    
    /**
     * セッションから履歴書データを保存（会員登録後用）
     */
    public function saveResume(array $resumeData = null)
    {
        if (!$resumeData) {
            $resumeData = session('pending_resume');
        }

        if (!$resumeData || !Auth::check()) {
            return redirect()->route('resume.index')->with('error', '履歴書の保存に失敗しました。');
        }

        try {
            // データベースカラムが存在するか確認し、存在しない場合はマイグレーションを実行
            $this->ensureAddressKanaColumnExists();
            
            Resume::create([
                'user_id' => Auth::id(),
                'first_name_roman' => $resumeData['first_name_roman'] ?? '',
                'last_name_roman' => $resumeData['last_name_roman'] ?? '',
                'first_name_kana' => $resumeData['first_name_kana'] ?? '',
                'last_name_kana' => $resumeData['last_name_kana'] ?? '',
                'birthday' => $resumeData['birthday'] ?? null,
                'gender' => $resumeData['gender'] ?? '',
                'phone' => $resumeData['phone'] ?? '',
                'email' => $resumeData['email'] ?? '',
                'postal_code' => $resumeData['postal_code'] ?? '',
                'address' => $resumeData['address'] ?? '',
                'address_kana' => $resumeData['address_kana'] ?? '',
                'education' => $resumeData['education'] ?? [],
                'work_history' => $resumeData['work_history'] ?? [],
                'licenses' => $resumeData['licenses'] ?? [],
                'appeal_points' => $resumeData['appeal_points'] ?? null,
                'self_request' => $resumeData['self_request'] ?? null,
                'status' => 'completed',
            ]);

            // セッションから削除
            session()->forget('pending_resume');

            return redirect()->route('home')->with('success', '履歴書を保存しました。');
        } catch (\Exception $e) {
            \Log::error('Resume saveResume error: ' . $e->getMessage());
            \Log::error('Resume saveResume error trace: ' . $e->getTraceAsString());
            
            // データベースカラムが存在しない場合のエラーメッセージ
            $errorMessage = '履歴書の保存に失敗しました。';
            if (str_contains($e->getMessage(), "Unknown column 'address_kana'") || 
                str_contains($e->getMessage(), "Column 'address_kana' doesn't exist")) {
                $errorMessage = 'データベースのマイグレーションが必要です。管理者に連絡してください。';
            }
            
            return redirect()->route('resume.index')->with('error', $errorMessage);
        }
    }

    /**
     * 会員登録/ログイン選択画面を表示
     */
    public function chooseAuth(): View
    {
        return view('resume.choose-auth');
    }
    
    /**
     * PDFテンプレートに文字を追記してダウンロード
     */
    public function download(Request $request)
    {
        try {
            $templatePath = storage_path('app/templates/01_A4_format.pdf');
            
            if (!file_exists($templatePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'テンプレートファイルが見つかりません: ' . $templatePath
                ], 404);
            }
            
            // POSTリクエストから直接データを取得（優先）
            $resumeData = null;
            if ($request->has('resume_data')) {
                $resumeData = json_decode($request->input('resume_data'), true);
            }
            
            // POSTリクエストにデータがない場合、セッションから取得
            if (!$resumeData) {
                $resumeData = $request->session()->get('resume_data');
            }
            
            // デバッグ: データ取得の状態をログに記録
            \Log::info('PDF download - Request method: ' . $request->method());
            \Log::info('PDF download - Resume data from POST: ' . ($request->has('resume_data') ? 'yes' : 'no'));
            \Log::info('PDF download - Resume data from session: ' . ($request->session()->get('resume_data') ? 'yes' : 'no'));
            \Log::info('PDF download - Final resume_data exists: ' . ($resumeData ? 'yes' : 'no'));
            
            if (!$resumeData) {
                \Log::warning('PDF download - Resume data not found in POST or session');
                \Log::warning('PDF download - Session all data: ' . json_encode($request->session()->all()));
                return response()->json([
                    'success' => false,
                    'message' => '履歴書データが見つかりませんでした。内容確認画面から再度お試しください。'
                ], 400);
            }
            
            // FPDI-TCPDFを使用してPDFを読み込む
            $pdf = new Fpdi();
            
            // 既存のPDFを読み込む
            $pageCount = $pdf->setSourceFile($templatePath);
            
            // 1ページ目を処理
            if ($pageCount >= 1) {
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false);
                
                // テンプレートをインポートして描画（元のPDFをそのまま使用）
                $templateId = $pdf->importPage(1);
                $pdf->useTemplate($templateId, 0, 0, 210, 297);
                
                // 1ページ目のデータを描画（既存のPDFの上に文字を描画）
                $this->drawPage1Data($pdf, $resumeData);
            }
            
            // 2ページ目を処理
            if ($pageCount >= 2) {
                $pdf->AddPage('P', 'A4');
                $pdf->SetAutoPageBreak(false);
                
                // テンプレートをインポートして描画（元のPDFをそのまま使用）
                $templateId = $pdf->importPage(2);
                $pdf->useTemplate($templateId, 0, 0, 210, 297);
                
                // 2ページ目のデータを描画（既存のPDFの上に文字を描画）
                $this->drawPage2Data($pdf, $resumeData);
            }
            
            // PDFを直接ブラウザに出力
            $pdf->Output('resume.pdf', 'D');
            
        } catch (\Throwable $e) {
            \Log::error('PDF generation error with FPDI: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'PDF生成エラー: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * 1ページ目のデータを描画
     */
    private function drawPage1Data(Fpdi $pdf, array $data): void
    {
        // 日本語フォントを設定（TCPDF内蔵の小塚明朝：kozminproregular）
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        
        // 提出日: 年(88, 31), 月(104, 31), 日(114, 31)
        $pdf->Text(88, 31, date('Y'));
        $pdf->Text(104, 31, date('n'));
        $pdf->Text(114, 31, date('j'));
        
        // 氏名（ふりがな）: (40, 40)
        $nameKana = trim(($data['last_name_kana'] ?? '') . ' ' . ($data['first_name_kana'] ?? ''));
        if (!empty($nameKana)) {
            $pdf->Text(40, 40, $nameKana);
        }
        
        // 氏名（ローマ字）: (40, 49) - フォントサイズを倍に
        $name = trim(($data['last_name_roman'] ?? '') . ' ' . ($data['first_name_roman'] ?? ''));
        if (!empty($name)) {
            $pdf->SetFont('kozminproregular', '', 20); // 10から20に変更（倍のサイズ）
            $pdf->Text(40, 49, $name);
            $pdf->SetFont('kozminproregular', '', 10); // 元のサイズに戻す
        }
        
        // 生年月日: 年(38, 63), 月(54, 63), 日(72, 63), 年齢(95, 63)
        if (!empty($data['birthday'])) {
            try {
                $date = Carbon::parse($data['birthday']);
                $year = $date->format('Y');
                $month = $date->format('n');
                $day = $date->format('j');
                $age = $date->age;
                
                // 年（横軸を左に1ずらし、縦軸を1下げ）
                $pdf->Text(38, 63, $year);
                // 月（横軸を右に6ずらし、縦軸を1下げ）
                $pdf->Text(56, 63, $month);
                // 日（縦軸を1下げ）
                $pdf->Text(72, 63, $day);
                // 年齢（縦軸を1下げ）
                $pdf->Text(95, 63, (string)$age);
            } catch (\Exception $e) {
                \Log::warning('Birthday parsing error: ' . $e->getMessage());
            }
        }
        
        // 性別: (120, 63)（縦軸を1下げ）
        if (!empty($data['gender'])) {
            $pdf->Text(120, 63, $data['gender']);
        }
        
        // 住所（ふりがな）: (40, 71) - 縦軸を1下に
        $addressKana = $data['address_kana'] ?? '';
        if (!empty($addressKana)) {
            $pdf->Text(40, 71, $addressKana);
        }
        
        // 郵便番号: (42, 78) - xxx-xxxxフォーマット、縦軸を1上に
        $postalCode = $data['postal_code'] ?? '';
        if (!empty($postalCode) && strlen($postalCode) === 7) {
            $formattedPostalCode = substr($postalCode, 0, 3) . '-' . substr($postalCode, 3, 4);
            $pdf->Text(42, 78, $formattedPostalCode);
        }
        
        // 住所: (42, 83) - フォントを少し大きく、25文字超で改行、20文字以上でスペースがあればその時点で改行
        $address = $data['address'] ?? '';
        if (!empty($address)) {
            // フォントサイズを少し大きく（10から11に）
            $pdf->SetFont('kozminproregular', '', 11);
            
            $lineHeight = 6; // 行間
            $currentY = 83;
            $maxLength = 25; // 最大文字数
            $spaceCheckLength = 20; // スペースチェック開始位置
            
            $addressLength = mb_strlen($address);
            
            if ($addressLength > $maxLength) {
                // 25文字を超える場合
                // 20文字以上でスペース（半角・全角）があるかチェック
                $firstPart = mb_substr($address, 0, $spaceCheckLength);
                $remainingPart = mb_substr($address, $spaceCheckLength);
                
                // 20文字以降で最初のスペース位置を探す
                $spacePos = false;
                $spaceTypes = [' ', '　']; // 半角スペースと全角スペース
                
                for ($i = $spaceCheckLength; $i < $addressLength; $i++) {
                    $char = mb_substr($address, $i, 1);
                    if (in_array($char, $spaceTypes)) {
                        $spacePos = $i;
                        break;
                    }
                }
                
                if ($spacePos !== false) {
                    // スペースが見つかった場合、その位置で改行
                    $firstLine = mb_substr($address, 0, $spacePos);
                    $secondLine = mb_substr($address, $spacePos + 1);
                    $pdf->Text(42, $currentY, $firstLine);
                    if (!empty($secondLine)) {
                        $pdf->Text(42, $currentY + $lineHeight, $secondLine);
                    }
                } else {
                    // スペースがない場合、25文字で改行
                    $firstLine = mb_substr($address, 0, $maxLength);
                    $secondLine = mb_substr($address, $maxLength);
                    $pdf->Text(42, $currentY, $firstLine);
                    if (!empty($secondLine)) {
                        $pdf->Text(42, $currentY + $lineHeight, $secondLine);
                    }
                }
            } else {
                // 25文字以下の場合はそのまま出力
                $pdf->Text(42, $currentY, $address);
            }
            
            // フォントサイズを元に戻す
            $pdf->SetFont('kozminproregular', '', 10);
        }
        
        // 電話番号: (160, 72) - ハイフンありで出力
        if (!empty($data['phone'])) {
            $phone = $data['phone'];
            // ハイフンを追加（10桁: 090-1234-5678, 11桁: 090-1234-56789）
            if (strlen($phone) === 10) {
                $formattedPhone = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
            } elseif (strlen($phone) === 11) {
                $formattedPhone = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
            } else {
                $formattedPhone = $phone;
            }
            $pdf->Text(160, 72, $formattedPhone);
        }
        
        // メールアドレス: (151, 83) - 22文字で改行
        if (!empty($data['email'])) {
            $email = $data['email'];
            $lineHeight = 6; // 行間
            $currentY = 83;
            $maxLength = 22; // 1行の最大文字数
            
            // 22文字ごとに分割して出力
            $chunks = str_split($email, $maxLength);
            foreach ($chunks as $chunk) {
                $pdf->Text(151, $currentY, $chunk);
                $currentY += $lineHeight;
            }
        }
        
        // 学歴・職歴: (10, 142) を起点にループ描画（縦軸+2）
        $startY = 142;
        $lineHeight = 8.5; // リピート時の縦軸間隔を調整（累積誤差を防ぐため）
        $currentY = $startY;
        
        // 学歴ラベル: (110, 133) に固定で表示（太字、フォントサイズを大きく）
        $pdf->SetFont('kozminproregular', 'B', 12);
        $pdf->Text(110, 133, '学歴');
        $pdf->SetFont('kozminproregular', '', 10); // 元のフォントに戻す
        
        // 学歴
        $educationCount = 0;
        if (!empty($data['education'])) {
            $index = 0;
            foreach ($data['education'] as $edu) {
                if (!empty($edu['date']) && !empty($edu['school_name']) && !empty($edu['event_type'])) {
                    try {
                        // 各行の位置を正確に計算（累積誤差を防ぐ）
                        $currentY = $startY + ($index * $lineHeight);
                        
                        $date = Carbon::parse($edu['date']);
                        $year = $date->year;
                        $month = $date->month;
                        $content = ($edu['school_name'] ?? '') . '　' . ($edu['event_type'] ?? '');
                        
                        // 年（横軸+11: 10→21）
                        $pdf->Text(21, $currentY, (string)$year);
                        
                        // 月（横軸+8: 30→38）
                        $pdf->Text(38, $currentY, (string)$month);
                        
                        // 内容（横軸+3: 45→48）
                        $pdf->Text(48, $currentY, $content);
                        
                        $index++;
                        $educationCount++;
                    } catch (\Exception $e) {
                        \Log::warning('Education date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // 職歴ラベル: 学歴の2行下（1行空白を入れて）に固定で表示（太字、フォントサイズを大きく）
        if ($educationCount > 0 || !empty($data['work_history'])) {
            $workHistoryLabelY = $startY + ($educationCount * $lineHeight) + $lineHeight;
            $pdf->SetFont('kozminproregular', 'B', 12);
            $pdf->Text(110, $workHistoryLabelY, '職歴');
            $pdf->SetFont('kozminproregular', '', 10); // 元のフォントに戻す
        }
        
        // 職歴
        if (!empty($data['work_history'])) {
            // 職歴の開始位置を職歴ラベルの次の行に設定
            $workHistoryStartY = $startY + ($educationCount * $lineHeight) + ($lineHeight * 2);
            $workIndex = 0;
            $lastWorkHistory = null;
            
            foreach ($data['work_history'] as $work) {
                if (!empty($work['date']) && !empty($work['company_name']) && !empty($work['event_type'])) {
                    try {
                        // 各行の位置を正確に計算（累積誤差を防ぐ）
                        $currentY = $workHistoryStartY + ($workIndex * $lineHeight);
                        
                        $date = Carbon::parse($work['date']);
                        $year = $date->year;
                        $month = $date->month;
                        $content = ($work['company_name'] ?? '') . '　' . ($work['event_type'] ?? '');
                        
                        // 年（横軸+11: 10→21）
                        $pdf->Text(21, $currentY, (string)$year);
                        
                        // 月（横軸+8: 30→38）
                        $pdf->Text(38, $currentY, (string)$month);
                        
                        // 内容（横軸+3: 45→48）
                        $pdf->Text(48, $currentY, $content);
                        
                        $lastWorkHistory = $work;
                        $workIndex++;
                    } catch (\Exception $e) {
                        \Log::warning('Work history date parsing error: ' . $e->getMessage());
                    }
                }
            }
            
            // 職歴の最後が「入社」で終わっている場合、「現在に至る」を追加表示
            if ($lastWorkHistory && ($lastWorkHistory['event_type'] ?? '') === '入社') {
                $currentY = $workHistoryStartY + ($workIndex * $lineHeight);
                // 会社名と同じ位置（横軸48）に「現在に至る」を表示（年月は不要、会社名も不要）
                $pdf->Text(48, $currentY, '現在に至る');
            }
        }
    }
    
    /**
     * 2ページ目のデータを描画
     */
    private function drawPage2Data(Fpdi $pdf, array $data): void
    {
        // 日本語フォントを設定（TCPDF内蔵の小塚明朝：kozminproregular）
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        
        // 免許・資格: (10, 40) を起点に描画
        $startY = 40;
        $lineHeight = 8;
        $currentY = $startY;
        
        if (!empty($data['licenses'])) {
            foreach ($data['licenses'] as $license) {
                if (!empty($license['date']) && !empty($license['name'])) {
                    try {
                        $date = Carbon::parse($license['date']);
                        $year = $date->year;
                        $month = $date->month;
                        $content = ($license['name'] ?? '') . '　取得';
                        
                        // 年
                        $pdf->Text(10, $currentY, (string)$year);
                        
                        // 月
                        $pdf->Text(30, $currentY, (string)$month);
                        
                        // 内容
                        $pdf->Text(45, $currentY, $content);
                        
                        $currentY += $lineHeight;
                    } catch (\Exception $e) {
                        \Log::warning('License date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // 志望動機: (23, 160) - 横軸を本人希望欄に合わせる、52文字ごとに改行
        $pdf->SetFont('kozminproregular', '', 9);
        $appealPoints = $data['appeal_points'] ?? '';
        $appealY = 160;
        $appealLineHeight = 4; // 志望動機の縦軸間隔を詰める
        
        if (empty($appealPoints)) {
            $pdf->Text(23, $appealY, '特になし');
        } else {
            // 改行コードで分割し、各行を出力（52文字を超える場合は52文字ごとに分割）
            $inputLines = preg_split("/\r\n|\r|\n/", $appealPoints);
            $lineIndex = 0;
            foreach ($inputLines as $inputLine) {
                $lineLength = mb_strlen($inputLine, 'UTF-8');
                if ($lineLength <= 52) {
                    // 52文字以内ならそのまま出力
                    $currentY = $appealY + ($lineIndex * $appealLineHeight);
                    $pdf->Text(23, $currentY, $inputLine);
                    $lineIndex++;
                } else {
                    // 52文字を超える場合は52文字ごとに分割
                    for ($i = 0; $i < $lineLength; $i += 52) {
                        $subLine = mb_substr($inputLine, $i, 52, 'UTF-8');
                        $currentY = $appealY + ($lineIndex * $appealLineHeight);
                        $pdf->Text(23, $currentY, $subLine);
                        $lineIndex++;
                    }
                }
            }
        }
        
        // 本人希望欄: (23, 228) - 空白の場合は「貴社規定に従います。」を出力、52文字ごとに改行
        $pdf->SetFont('kozminproregular', '', 9);
        $selfRequest = $data['self_request'] ?? '';
        $selfRequestY = 228;
        $selfRequestLineHeight = 8.5; // 学歴の繰り返し出力と同等の縦軸間隔
        
        if (empty($selfRequest)) {
            $pdf->Text(23, $selfRequestY, '貴社規定に従います。');
        } else {
            // 改行コードで分割し、各行を出力（52文字を超える場合は52文字ごとに分割）
            $inputLines = preg_split("/\r\n|\r|\n/", $selfRequest);
            $lineIndex = 0;
            foreach ($inputLines as $inputLine) {
                $lineLength = mb_strlen($inputLine, 'UTF-8');
                if ($lineLength <= 52) {
                    // 52文字以内ならそのまま出力
                    $currentY = $selfRequestY + ($lineIndex * $selfRequestLineHeight);
                    $pdf->Text(23, $currentY, $inputLine);
                    $lineIndex++;
                } else {
                    // 52文字を超える場合は52文字ごとに分割
                    for ($i = 0; $i < $lineLength; $i += 52) {
                        $subLine = mb_substr($inputLine, $i, 52, 'UTF-8');
                        $currentY = $selfRequestY + ($lineIndex * $selfRequestLineHeight);
                        $pdf->Text(23, $currentY, $subLine);
                        $lineIndex++;
                    }
                }
            }
        }
    }
    
    /**
     * address_kanaカラムが存在することを確認し、存在しない場合は追加
     */
    private function ensureAddressKanaColumnExists(): void
    {
        try {
            if (!Schema::hasColumn('resumes', 'address_kana')) {
                Schema::table('resumes', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('address_kana')->nullable()->after('address');
                });
                \Log::info('address_kana column added to resumes table');
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to ensure address_kana column exists: ' . $e->getMessage());
            // エラーが発生しても処理を続行（カラムが既に存在する可能性がある）
        }
    }
}
