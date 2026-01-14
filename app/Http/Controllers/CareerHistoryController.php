<?php

namespace App\Http\Controllers;

use App\Models\CareerHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use setasign\Fpdi\Tcpdf\Fpdi;

class CareerHistoryController extends Controller
{
    /**
     * 職務経歴書作成ページを表示
     */
    public function index(Request $request): View
    {
        $showConfirm = $request->session()->get('show_confirm', false) || $request->query('showConfirm') == '1';
        $request->session()->forget('show_confirm');

        $careerHistoryData = session('career_history_data');

        // セッションにデータがない場合、ログインしている場合は最新の職務経歴書データを取得
        if (! $careerHistoryData && Auth::check()) {
            $latestCareerHistory = CareerHistory::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latestCareerHistory) {
                $careerHistoryData = [
                    'last_name_roman' => $latestCareerHistory->last_name_roman,
                    'first_name_roman' => $latestCareerHistory->first_name_roman,
                    'job_summary' => $latestCareerHistory->job_summary,
                    'self_pr' => $latestCareerHistory->self_pr,
                    'career_histories' => $latestCareerHistory->career_histories ?? [],
                ];
            }
        }

        return view('career-history.index', compact('showConfirm', 'careerHistoryData'));
    }

    /**
     * 職務経歴書作成フォームを表示
     */
    public function create(): View
    {
        return view('career-history.create');
    }

    /**
     * 内容確認画面用データ処理
     */
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'last_name_roman' => 'required|string|max:25',
            'first_name_roman' => 'required|string|max:25',
            'job_summary' => 'nullable|string',
            'self_pr' => 'nullable|string',
            'company_name' => 'required|array',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'is_current' => 'nullable|array',
            'job_description' => 'required|array',
            'business_content' => 'nullable|array',
            'employee_count' => 'nullable|array',
            'capital' => 'nullable|array',
        ]);

        // 職務経歴データを整理
        $careerHistories = [];
        // is_currentの値を数値配列に変換（JavaScriptからインデックスが値として送信される）
        $isCurrentIndexes = [];
        if (isset($validated['is_current']) && is_array($validated['is_current'])) {
            // 配列の値（実際のインデックス）を取得
            $isCurrentIndexes = array_map('intval', array_values($validated['is_current']));
        }

        foreach ($validated['company_name'] as $index => $companyName) {
            if (! empty($companyName) && ! empty($validated['start_date'][$index]) && ! empty($validated['job_description'][$index])) {
                $isCurrent = in_array($index, $isCurrentIndexes, true);
                $careerHistories[] = [
                    'company_name' => $companyName,
                    'start_date' => $validated['start_date'][$index],
                    'end_date' => $isCurrent ? '現在' : ($validated['end_date'][$index] ?? ''),
                    'is_current' => $isCurrent,
                    'job_description' => $validated['job_description'][$index],
                    'business_content' => $validated['business_content'][$index] ?? null,
                    'employee_count' => $validated['employee_count'][$index] ?? null,
                    'capital' => $validated['capital'][$index] ?? null,
                ];
            }
        }

        // セッションに保存
        $careerHistoryData = [
            'last_name_roman' => $validated['last_name_roman'],
            'first_name_roman' => $validated['first_name_roman'],
            'job_summary' => $validated['job_summary'] ?? null,
            'self_pr' => $validated['self_pr'] ?? null,
            'career_histories' => $careerHistories,
        ];

        session(['career_history_data' => $careerHistoryData]);
        session(['show_confirm' => true]);

        return redirect()->route('career-history.index');
    }

    /**
     * 職務経歴書を保存
     */
    public function save(Request $request)
    {
        $careerHistoryData = $request->session()->get('career_history_data');

        if (! $careerHistoryData) {
            return response()->json([
                'success' => false,
                'message' => '職務経歴書データが見つかりませんでした。',
            ], 400);
        }

        if (! Auth::check()) {
            session(['pending_career_history' => true]);

            return response()->json([
                'success' => false,
                'redirect' => route('career-history.choose-auth'),
            ]);
        }

        // データベースに保存
        CareerHistory::create([
            'user_id' => Auth::id(),
            'last_name_roman' => $careerHistoryData['last_name_roman'] ?? '',
            'first_name_roman' => $careerHistoryData['first_name_roman'] ?? '',
            'job_summary' => $careerHistoryData['job_summary'] ?? null,
            'self_pr' => $careerHistoryData['self_pr'] ?? null,
            'career_histories' => $careerHistoryData['career_histories'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => '職務経歴書を保存しました。',
        ]);
    }

    /**
     * 職務経歴書を保存（旧メソッド、confirmに移行）
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name_roman' => 'required|string|max:25',
            'first_name_roman' => 'required|string|max:25',
            'job_summary' => 'nullable|string',
            'self_pr' => 'nullable|string',
            'company_name' => 'required|array',
            'start_date' => 'required|array',
            'end_date' => 'required|array',
            'is_current' => 'nullable|array',
            'job_description' => 'required|array',
            'business_content' => 'nullable|array',
            'employee_count' => 'nullable|array',
            'capital' => 'nullable|array',
        ]);

        // 職務経歴データを整理
        $careerHistories = [];
        foreach ($validated['company_name'] as $index => $companyName) {
            if (! empty($companyName) && ! empty($validated['start_date'][$index]) && ! empty($validated['job_description'][$index])) {
                $careerHistories[] = [
                    'company_name' => $companyName,
                    'start_date' => $validated['start_date'][$index],
                    'end_date' => isset($validated['is_current'][$index]) && $validated['is_current'][$index] ? '現在' : ($validated['end_date'][$index] ?? ''),
                    'is_current' => isset($validated['is_current'][$index]) && $validated['is_current'][$index],
                    'job_description' => $validated['job_description'][$index],
                    'business_content' => $validated['business_content'][$index] ?? null,
                    'employee_count' => $validated['employee_count'][$index] ?? null,
                    'capital' => $validated['capital'][$index] ?? null,
                ];
            }
        }

        // データベースに保存
        if (Auth::check()) {
            CareerHistory::create([
                'user_id' => Auth::id(),
                'last_name_roman' => $validated['last_name_roman'],
                'first_name_roman' => $validated['first_name_roman'],
                'job_summary' => $validated['job_summary'] ?? null,
                'self_pr' => $validated['self_pr'] ?? null,
                'career_histories' => $careerHistories,
            ]);
        }

        // セッションに保存（PDF出力用）
        session([
            'career_history_data' => [
                'last_name_roman' => $validated['last_name_roman'],
                'first_name_roman' => $validated['first_name_roman'],
                'job_summary' => $validated['job_summary'] ?? null,
                'self_pr' => $validated['self_pr'] ?? null,
                'career_histories' => $careerHistories,
            ],
        ]);

        // JSONリクエストの場合はJSONレスポンスを返す
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '職務経歴書を保存しました。',
            ]);
        }

        return redirect()->route('career-history.index')->with('success', '職務経歴書を保存しました。');
    }

    /**
     * PDF出力
     */
    public function download(Request $request)
    {
        try {
            // POSTリクエストから直接データを取得（優先）
            $careerHistoryData = null;
            if ($request->has('last_name_roman')) {
                // フォームから直接データを構築
                $careerHistoryData = [
                    'last_name_roman' => $request->input('last_name_roman'),
                    'first_name_roman' => $request->input('first_name_roman'),
                    'job_summary' => $request->input('job_summary'),
                    'self_pr' => $request->input('self_pr'),
                    'career_histories' => [],
                ];

                // 職務経歴データを整理
                $companyNames = $request->input('company_name', []);
                $startDates = $request->input('start_date', []);
                $endDates = $request->input('end_date', []);
                $isCurrents = $request->input('is_current', []);
                $jobDescriptions = $request->input('job_description', []);
                $businessContents = $request->input('business_content', []);
                $employeeCounts = $request->input('employee_count', []);
                $capitals = $request->input('capital', []);

                foreach ($companyNames as $index => $companyName) {
                    if (! empty($companyName) && ! empty($startDates[$index]) && ! empty($jobDescriptions[$index])) {
                        $careerHistoryData['career_histories'][] = [
                            'company_name' => $companyName,
                            'start_date' => $startDates[$index],
                            'end_date' => (isset($isCurrents[$index]) && $isCurrents[$index]) ? '現在' : ($endDates[$index] ?? ''),
                            'is_current' => isset($isCurrents[$index]) && $isCurrents[$index],
                            'job_description' => $jobDescriptions[$index],
                            'business_content' => $businessContents[$index] ?? null,
                            'employee_count' => $employeeCounts[$index] ?? null,
                            'capital' => $capitals[$index] ?? null,
                        ];
                    }
                }
            }

            // POSTリクエストにデータがない場合、セッションから取得
            if (! $careerHistoryData) {
                $careerHistoryData = $request->session()->get('career_history_data');
            }

            if (! $careerHistoryData) {
                return response()->json([
                    'success' => false,
                    'message' => '職務経歴書データが見つかりませんでした。',
                ], 400);
            }

            // PDF出力前に履歴をデータベースに保存
            try {
                \App\Models\CareerHistorySubmission::create([
                    'user_id' => Auth::id(),
                    'last_name_roman' => $careerHistoryData['last_name_roman'] ?? '',
                    'first_name_roman' => $careerHistoryData['first_name_roman'] ?? '',
                    'job_summary' => $careerHistoryData['job_summary'] ?? null,
                    'self_pr' => $careerHistoryData['self_pr'] ?? null,
                    'career_histories' => $careerHistoryData['career_histories'] ?? [],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to save career history submission: '.$e->getMessage());
                // 保存に失敗してもPDF生成は続行
            }

            // PDF出力前にデータベースに保存（ログインしている場合）
            if (Auth::check()) {
                try {
                    CareerHistory::create([
                        'user_id' => Auth::id(),
                        'last_name_roman' => $careerHistoryData['last_name_roman'] ?? '',
                        'first_name_roman' => $careerHistoryData['first_name_roman'] ?? '',
                        'job_summary' => $careerHistoryData['job_summary'] ?? null,
                        'self_pr' => $careerHistoryData['self_pr'] ?? null,
                        'career_histories' => $careerHistoryData['career_histories'] ?? [],
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to save career history: '.$e->getMessage());
                    // 保存に失敗してもPDF生成は続行
                }
            }

            // TCPDFを使用してPDFを生成
            $pdf = new Fpdi;
            $pdf->SetAutoPageBreak(false); // 手動でページ管理するため無効化
            $pdf->AddPage('P', 'A4');

            // 日本語フォントを設定（TCPDF内蔵の小塚明朝：kozminproregular）
            $pdf->SetFont('kozminproregular', '', 12);
            $pdf->SetTextColor(0, 0, 0);

            // データを描画
            $this->drawCareerHistoryData($pdf, $careerHistoryData);

            // ページ番号を追加
            $this->addPageNumbers($pdf);

            // PDFをダウンロード
            $pdf->Output('career_history.pdf', 'D');
        } catch (\Throwable $e) {
            \Log::error('Career history PDF generation error: '.$e->getMessage());
            \Log::error('Error trace: '.$e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'PDF生成エラー: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * PDFに職務経歴書データを描画
     */
    private function drawCareerHistoryData(Fpdi $pdf, array $data): void
    {
        $now = Carbon::now();
        $currentDate = $now->format('Y年n月j日').'現在';
        // 履歴書と同じように半角スペースで結合
        $name = trim(($data['last_name_roman'] ?? '').' '.($data['first_name_roman'] ?? ''));
        $jobSummary = $data['job_summary'] ?? '';
        $selfPr = $data['self_pr'] ?? '';
        $careerHistories = $data['career_histories'] ?? [];

        $x = 20; // 左マージン
        $y = 20; // 上マージン
        $pageWidth = 210 - ($x * 2); // A4幅210mm - 左右マージン

        // 1行目: 職務経歴書（中央揃え、大きめ、太字）
        $pdf->SetFont('kozminproregular', 'B', 18);
        $title = '職務経歴書';
        $titleWidth = $pdf->GetStringWidth($title);
        $titleX = ($pageWidth / 2) - ($titleWidth / 2) + $x;
        $pdf->Text($titleX, $y, $title);
        $y += 15;

        // 2行目: 年月日+現在（右揃え）
        $pdf->SetFont('kozminproregular', '', 12);
        $dateText = $currentDate;
        $dateWidth = $pdf->GetStringWidth($dateText);
        $dateX = $pageWidth - $dateWidth + $x;
        $pdf->Text($dateX, $y, $dateText);
        $y += 10;

        // 3行目: 氏名（右揃え）
        $nameText = '氏名：'.$name;
        $nameWidth = $pdf->GetStringWidth($nameText);
        $nameX = $pageWidth - $nameWidth + $x;
        $pdf->Text($nameX, $y, $nameText);
        $y += 15;

        // 4行目: 職務要約タイトル（左揃え、太字）
        $pdf->SetFont('kozminproregular', 'B', 12);
        $pdf->Text($x, $y, '■職務要約');
        $y += 8;

        // 5行目以降: 職務要約本文（左揃え）
        if (! empty($jobSummary)) {
            $pdf->SetFont('kozminproregular', '', 12);
            $pdf->SetXY($x, $y);
            $pdf->MultiCell($pageWidth, 6, $jobSummary, 0, 'L', false, 1);
            $y = $pdf->GetY() + 3;
        }
        $y += 5;

        // 職務経歴タイトル（左揃え、太字）
        if ($y > 270) {
            $pdf->AddPage('P', 'A4');
            $y = 20;
        }
        $pdf->SetFont('kozminproregular', 'B', 12);
        $pdf->Text($x, $y, '■職務経歴');
        $y += 10;

        // 年月フォーマット変換 (YYYY-MM -> YYYY年M月)
        $formatDate = function ($dateStr) {
            if (empty($dateStr) || $dateStr === '現在') {
                return $dateStr;
            }
            if (preg_match('/^(\d{4})-(\d{2})$/', $dateStr, $matches)) {
                return $matches[1].'年'.(int) $matches[2].'月';
            }

            return $dateStr;
        };

        // 表の列幅
        $periodColWidth = 45; // 時期列の幅
        $contentColWidth = $pageWidth - $periodColWidth; // 内容列の幅
        $lineHeight = 6; // 行の高さ

        // 表のヘッダー
        if ($y > 270) {
            $pdf->AddPage('P', 'A4');
            $y = 20;
        }
        $pdf->SetFont('kozminproregular', 'B', 12);
        $pdf->SetFillColor(240, 240, 240);
        $headerHeight = $lineHeight * 1.5;
        $pdf->Rect($x, $y, $periodColWidth, $headerHeight, 'DF');
        $pdf->Rect($x + $periodColWidth, $y, $contentColWidth, $headerHeight, 'DF');
        // 縦方向の中央揃え: 矩形の中央Y座標 - テキストの高さの半分
        $headerY = $y + ($headerHeight / 2) - ($lineHeight / 2);
        $pdf->SetXY($x, $headerY);
        $pdf->Cell($periodColWidth, $lineHeight, '時期', 0, 0, 'C');
        $pdf->SetXY($x + $periodColWidth, $headerY);
        $pdf->Cell($contentColWidth, $lineHeight, '内容', 0, 0, 'C');
        $y += $lineHeight * 1.5;

        // 職務経歴の詳細を表形式で出力
        foreach ($careerHistories as $career) {
            $companyName = $career['company_name'] ?? '';
            $startDate = $career['start_date'] ?? '';
            $endDate = $career['end_date'] ?? '';
            $jobDescription = $career['job_description'] ?? '';
            $businessContent = $career['business_content'] ?? null;
            $employeeCount = $career['employee_count'] ?? null;
            $capital = $career['capital'] ?? null;

            $formattedStartDate = $formatDate($startDate);
            $formattedEndDate = $formatDate($endDate);
            $period = $formattedStartDate."\n～\n".$formattedEndDate;

            // 内容を組み立て
            $otherContent = '';
            if (! empty($businessContent)) {
                $otherContent .= '事業内容: '.$businessContent."\n";
            }
            if (! empty($employeeCount)) {
                $otherContent .= '従業員数: '.$employeeCount."\n";
            }
            if (! empty($capital)) {
                $otherContent .= '資本金: '.$capital."\n";
            }
            if (! empty($jobDescription)) {
                $otherContent .= "\n".$jobDescription;
            }

            // ブロックの高さを事前に計算
            $pdf->SetFont('kozminproregular', 'B', 12);
            $companyNameHeight = $pdf->getStringHeight($contentColWidth - 4, $companyName);
            $pdf->SetFont('kozminproregular', '', 12);
            $otherContentHeight = ! empty($otherContent) ? $pdf->getStringHeight($contentColWidth - 4, $otherContent) : 0;
            $blockHeight = max($companyNameHeight + $otherContentHeight + 4, $pdf->getStringHeight($periodColWidth - 4, $period) + 4); // パディング含む

            // ページに収まらない場合は新しいページを追加
            $pageBottom = 297 - 10; // A4高さ297mm - 下マージン10mm
            if ($y + $blockHeight > $pageBottom) {
                $pdf->AddPage('P', 'A4');
                $y = 20;
            }

            $startY = $y; // 行の開始Y座標を記録

            // 内容列を先に描画して高さを取得
            $pdf->SetXY($x + $periodColWidth + 2, $y + 2);
            $pdf->SetFont('kozminproregular', 'B', 12);
            // 会社名のみ太字
            $pdf->MultiCell($contentColWidth - 4, $lineHeight, $companyName, 0, 'L', false, 1);
            $yAfterCompany = $pdf->GetY();

            // その他の内容
            if (! empty($otherContent)) {
                $pdf->SetFont('kozminproregular', '', 12);
                $pdf->SetXY($x + $periodColWidth + 2, $yAfterCompany);
                $pdf->MultiCell($contentColWidth - 4, $lineHeight, $otherContent, 0, 'L', false, 1);
            }

            $endY = $pdf->GetY() + 2; // 行の終了Y座標
            $rowHeight = $endY - $startY;

            // 表の罫線を描画（行全体の高さを使用）
            $pdf->Rect($x, $startY, $periodColWidth, $rowHeight, 'D');
            $pdf->Rect($x + $periodColWidth, $startY, $contentColWidth, $rowHeight, 'D');

            // 時期列（縦方向中央揃え、改行表示）
            $pdf->SetFont('kozminproregular', '', 12);
            // 期間テキストの高さを計算
            $periodHeight = $pdf->getStringHeight($periodColWidth - 4, $period);
            $periodY = $startY + ($rowHeight / 2) - ($periodHeight / 2);
            $pdf->SetXY($x + 2, $periodY);
            $pdf->MultiCell($periodColWidth - 4, $lineHeight, $period, 0, 'C', false, 0);

            $y = $endY;
        }

        // 自己PRタイトル（左揃え、太字）- 職務経歴の後に表示
        if ($y > 270) {
            $pdf->AddPage('P', 'A4');
            $y = 20;
        }
        $y += 10; // 職務経歴テーブルとの間隔
        $pdf->SetFont('kozminproregular', 'B', 12);
        $pdf->Text($x, $y, '■自己PR');
        $y += 8;

        // 自己PR本文（左揃え）- ページ分割に対応
        if (! empty($selfPr)) {
            $pdf->SetFont('kozminproregular', '', 12);
            $pageBottom = 297 - 10; // A4高さ297mm - 下マージン10mm
            $lineHeight = 6; // 行の高さ
            
            // テキストを行に分割（改行文字で分割）
            $lines = explode("\n", $selfPr);
            $currentY = $y;
            
            foreach ($lines as $line) {
                // 空行の処理
                if (empty(trim($line))) {
                    $currentY += $lineHeight;
                    // ページを超える場合は新しいページを追加
                    if ($currentY > $pageBottom) {
                        $pdf->AddPage('P', 'A4');
                        $currentY = 20;
                    }
                    continue;
                }
                
                // 行の幅をチェックして、必要に応じて複数行に分割
                $lineWidth = $pdf->GetStringWidth($line);
                if ($lineWidth <= $pageWidth) {
                    // 1行に収まる場合
                    $pdf->SetXY($x, $currentY);
                    $pdf->Cell($pageWidth, $lineHeight, $line, 0, 0, 'L');
                    $currentY += $lineHeight;
                } else {
                    // 複数行に分割が必要な場合
                    $words = mb_str_split($line, 1, 'UTF-8');
                    $currentLine = '';
                    
                    foreach ($words as $word) {
                        $testLine = $currentLine.$word;
                        $testWidth = $pdf->GetStringWidth($testLine);
                        
                        if ($testWidth > $pageWidth && ! empty($currentLine)) {
                            // 現在の行を出力
                            $pdf->SetXY($x, $currentY);
                            $pdf->Cell($pageWidth, $lineHeight, $currentLine, 0, 0, 'L');
                            $currentY += $lineHeight;
                            
                            // ページを超える場合は新しいページを追加
                            if ($currentY > $pageBottom) {
                                $pdf->AddPage('P', 'A4');
                                $currentY = 20;
                            }
                            
                            $currentLine = $word;
                        } else {
                            $currentLine = $testLine;
                        }
                    }
                    
                    // 残りの行を出力
                    if (! empty($currentLine)) {
                        $pdf->SetXY($x, $currentY);
                        $pdf->Cell($pageWidth, $lineHeight, $currentLine, 0, 0, 'L');
                        $currentY += $lineHeight;
                        
                        // ページを超える場合は新しいページを追加
                        if ($currentY > $pageBottom) {
                            $pdf->AddPage('P', 'A4');
                            $currentY = 20;
                        }
                    }
                }
            }
            
            $y = $currentY + 3;
        }
    }

    /**
     * PDFにページ番号を追加
     */
    private function addPageNumbers(Fpdi $pdf): void
    {
        $totalPages = $pdf->getNumPages();
        if ($totalPages <= 1) {
            return; // 1ページのみの場合はページ番号を表示しない
        }

        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        for ($i = 1; $i <= $totalPages; $i++) {
            $pdf->setPage($i);
            // 右下にページ番号を表示
            $pageText = $i.'/'.$totalPages;
            $pageWidth = $pdf->GetStringWidth($pageText);
            $x = 210 - 20 - $pageWidth; // 右マージン20mm
            $y = 297 - 15; // 下マージン15mm
            $pdf->Text($x, $y, $pageText);
        }
    }

    /**
     * 職務経歴の情報をAI生成
     */
    public function generateCareerInfo(Request $request)
    {
        \Log::info('generateCareerInfo called', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check(),
        ]);

        // 会員限定機能
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'この機能は会員限定です。ログインしてください。',
            ], 403);
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'job_description' => 'nullable|string|max:2000',
        ]);

        $companyName = $request->input('company_name');
        $jobDescription = $request->input('job_description', '');
        \Log::info('Career info generation request', [
            'company_name' => $companyName,
            'job_description' => $jobDescription,
        ]);

        // Gemini APIのプロンプトを作成
        $prompt = "以下の情報をもとに、職務経歴書に記載する情報を生成してください。\n\n";
        $prompt .= "【会社名】\n{$companyName}\n\n";

        if (! empty($jobDescription)) {
            $prompt .= "【職務内容（簡単な入力）】\n{$jobDescription}\n\n";
            $prompt .= "上記の職務内容を基に、正しい日本語で100-200文字程度に清書してください。\n\n";
        }

        $prompt .= "【出力形式】\n";
        $prompt .= "以下のJSON形式で出力してください。\n";
        $prompt .= "{\n";
        $prompt .= '  "company_name": "会社名（正式名称で）",'."\n";
        $prompt .= '  "business_content": "事業内容（50文字以内）",'."\n";
        $prompt .= '  "employee_count": "従業員数（半角数字+人、例: 1000人）",'."\n";
        $prompt .= '  "capital": "資本金（数字+万円または億円、例: 1億円）",'."\n";
        $prompt .= '  "job_description": "職務内容（100-200文字程度で正しい日本語で簡潔に）"'."\n";
        $prompt .= "}\n\n";
        $prompt .= "【重要な指示】\n";
        $prompt .= "1. 会社名は正式名称で記載してください。\n";
        $prompt .= "2. 事業内容は50文字以内で簡潔に記載してください。\n";
        $prompt .= "3. 従業員数は「半角数字+人」の形式で記載してください（例: 1000人）。\n";
        $prompt .= "4. 資本金は「数字+万円」または「数字+億円」の形式で記載してください（例: 1億円、5000万円）。\n";
        if (! empty($jobDescription)) {
            $prompt .= "5. 職務内容は、入力された内容を基に、正しい日本語で100-200文字程度に清書してください。\n";
        } else {
            $prompt .= "5. 職務内容は100-200文字程度で簡潔に記載してください。一般的な職務内容を想定してください。\n";
        }
        $prompt .= "6. 出力は必ずJSON形式のみで、余計な説明やコメントは一切含めないでください。\n";
        $prompt .= "7. JSONの値に改行文字（\\n）は含めないでください。\n";

        try {
            $apiKey = config('services.gemini.api_key');

            if (empty($apiKey)) {
                \Log::error('Gemini API key is not configured');

                return response()->json([
                    'success' => false,
                    'message' => 'AI生成サービスが利用できません。GEMINI_API_KEYが設定されていません。',
                ], 500);
            }

            // Gemini API 2.5 Flash を使用
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
            \Log::info('Gemini API request', [
                'url' => preg_replace('/key=[^&]+/', 'key=***', $url),
                'prompt_length' => mb_strlen($prompt, 'UTF-8'),
            ]);

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

            if (! $response->successful()) {
                $errorBody = $response->body();
                \Log::error('Gemini API HTTP error', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'url' => $url,
                ]);

                $errorMessage = '情報の生成に失敗しました。APIエラー: '.$response->status();
                if ($errorData = $response->json()) {
                    if (isset($errorData['error']['message'])) {
                        $errorMessage .= ' - '.$errorData['error']['message'];
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            $responseData = $response->json();

            if (! isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                \Log::error('Gemini API response structure error', [
                    'response_data' => $responseData,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'APIからの応答形式が正しくありません。',
                ], 500);
            }

            $generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);

            // JSONを抽出（コードブロックがあれば除去）
            $generatedText = preg_replace('/```json\s*/', '', $generatedText);
            $generatedText = preg_replace('/```\s*/', '', $generatedText);
            $generatedText = trim($generatedText);

            // JSONをパース
            $decoded = json_decode($generatedText, true);

            if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
                \Log::error('Failed to parse JSON from Gemini API', [
                    'generated_text' => $generatedText,
                    'json_error' => json_last_error_msg(),
                    'json_error_code' => json_last_error(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => '生成されたデータの解析に失敗しました。JSONエラー: '.json_last_error_msg(),
                ], 500);
            }

            // 文字数制限を適用
            if (isset($decoded['business_content']) && mb_strlen($decoded['business_content'], 'UTF-8') > 50) {
                $targetLength = 50;
                $truncated = mb_substr($decoded['business_content'], 0, $targetLength, 'UTF-8');
                // 最後の完全な文（句点で終わる文）を見つける
                $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                if ($lastPeriod !== false && $lastPeriod > 30) {
                    $decoded['business_content'] = mb_substr($decoded['business_content'], 0, $lastPeriod + 1, 'UTF-8');
                } else {
                    // 句点が見つからない場合は、読点を探す
                    $lastComma = mb_strrpos($truncated, '、', 0, 'UTF-8');
                    if ($lastComma !== false && $lastComma > 30) {
                        $decoded['business_content'] = mb_substr($decoded['business_content'], 0, $lastComma + 1, 'UTF-8');
                    } else {
                        // それでも見つからない場合は、文字数制限を緩和
                        $maxLength = (int) ($targetLength * 1.1);
                        $textLength = mb_strlen($decoded['business_content'], 'UTF-8');
                        if ($textLength <= $maxLength) {
                            // そのまま使用
                        } else {
                            $truncated = mb_substr($decoded['business_content'], 0, $maxLength, 'UTF-8');
                            $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                            if ($lastPeriod !== false && $lastPeriod > 30) {
                                $decoded['business_content'] = mb_substr($decoded['business_content'], 0, $lastPeriod + 1, 'UTF-8');
                            } else {
                                $decoded['business_content'] = $truncated;
                            }
                        }
                    }
                }
            }
            if (isset($decoded['job_description']) && mb_strlen($decoded['job_description'], 'UTF-8') > 200) {
                $targetLength = 200;
                $truncated = mb_substr($decoded['job_description'], 0, $targetLength, 'UTF-8');
                // 最後の完全な文（句点で終わる文）を見つける
                $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                if ($lastPeriod !== false && $lastPeriod > 100) {
                    $decoded['job_description'] = mb_substr($decoded['job_description'], 0, $lastPeriod + 1, 'UTF-8');
                } else {
                    // 句点が見つからない場合は、読点を探す
                    $lastComma = mb_strrpos($truncated, '、', 0, 'UTF-8');
                    if ($lastComma !== false && $lastComma > 100) {
                        $decoded['job_description'] = mb_substr($decoded['job_description'], 0, $lastComma + 1, 'UTF-8');
                    } else {
                        // それでも見つからない場合は、文字数制限を緩和
                        $maxLength = (int) ($targetLength * 1.1);
                        $textLength = mb_strlen($decoded['job_description'], 'UTF-8');
                        if ($textLength <= $maxLength) {
                            // そのまま使用
                        } else {
                            $truncated = mb_substr($decoded['job_description'], 0, $maxLength, 'UTF-8');
                            $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                            if ($lastPeriod !== false && $lastPeriod > 100) {
                                $decoded['job_description'] = mb_substr($decoded['job_description'], 0, $lastPeriod + 1, 'UTF-8');
                            } else {
                                $decoded['job_description'] = $truncated;
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => $decoded,
            ]);
        } catch (\Exception $e) {
            \Log::error('Career info generation error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '情報の生成中にエラーが発生しました。',
            ], 500);
        }
    }

    /**
     * 職務要約をAI生成
     */
    public function generateJobSummary(Request $request)
    {
        \Log::info('generateJobSummary called', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check(),
        ]);

        // 会員限定機能
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'この機能は会員限定です。ログインしてください。',
            ], 403);
        }

        $careerHistories = $request->input('career_histories', []);

        if (empty($careerHistories) || ! is_array($careerHistories)) {
            return response()->json([
                'success' => false,
                'message' => '職務経歴の職務内容が一つも入力されていません。',
            ], 400);
        }

        // 職務内容を抽出
        $jobDescriptions = [];
        foreach ($careerHistories as $career) {
            if (! empty($career['job_description'])) {
                $jobDescriptions[] = $career['job_description'];
            }
        }

        if (empty($jobDescriptions)) {
            return response()->json([
                'success' => false,
                'message' => '職務経歴の職務内容が一つも入力されていません。',
            ], 400);
        }

        // Gemini APIのプロンプトを作成
        $prompt = "以下の職務経歴の職務内容をもとに、職務要約を生成してください。\n\n";
        $prompt .= "【職務経歴の職務内容】\n";
        foreach ($jobDescriptions as $index => $description) {
            $prompt .= ($index + 1).'. '.$description."\n";
        }
        $prompt .= "\n";
        $prompt .= "上記の職務内容をもとに、職務要約を100-200文字で簡潔にまとめてください。\n";
        $prompt .= "文字通り職務の要約として、経験した業務内容を簡潔にまとめてください。\n\n";
        $prompt .= "【出力形式】\n";
        $prompt .= "以下のJSON形式で出力してください。\n";
        $prompt .= "{\n";
        $prompt .= '  "job_summary": "職務要約（100-200文字で簡潔に）"'."\n";
        $prompt .= "}\n\n";
        $prompt .= "【重要な指示】\n";
        $prompt .= "1. 職務要約は100-200文字で簡潔にまとめてください。\n";
        $prompt .= "2. 文字通り職務の要約として、経験した業務内容を簡潔にまとめてください。\n";
        $prompt .= "3. 出力は必ずJSON形式のみで、余計な説明やコメントは一切含めないでください。\n";
        $prompt .= "4. JSONの値に改行文字（\\n）は含めないでください。\n";

        try {
            $apiKey = config('services.gemini.api_key');

            if (empty($apiKey)) {
                \Log::error('Gemini API key is not configured');

                return response()->json([
                    'success' => false,
                    'message' => 'AI生成サービスが利用できません。GEMINI_API_KEYが設定されていません。',
                ], 500);
            }

            // Gemini API 2.5 Flash を使用
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
            \Log::info('Gemini API request for job summary', [
                'url' => preg_replace('/key=[^&]+/', 'key=***', $url),
                'prompt_length' => mb_strlen($prompt, 'UTF-8'),
            ]);

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

            if (! $response->successful()) {
                $errorBody = $response->body();
                \Log::error('Gemini API HTTP error for job summary', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'url' => $url,
                ]);

                $errorMessage = '職務要約の生成に失敗しました。APIエラー: '.$response->status();
                if ($errorData = $response->json()) {
                    if (isset($errorData['error']['message'])) {
                        $errorMessage .= ' - '.$errorData['error']['message'];
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            $responseData = $response->json();

            if (! isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                \Log::error('Gemini API response structure error for job summary', [
                    'response_data' => $responseData,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'APIからの応答形式が正しくありません。',
                ], 500);
            }

            $generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);

            // JSONを抽出（コードブロックがあれば除去）
            $generatedText = preg_replace('/```json\s*/', '', $generatedText);
            $generatedText = preg_replace('/```\s*/', '', $generatedText);
            $generatedText = trim($generatedText);

            // JSONをパース
            $decoded = json_decode($generatedText, true);

            if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
                \Log::error('Failed to parse JSON from Gemini API for job summary', [
                    'generated_text' => $generatedText,
                    'json_error' => json_last_error_msg(),
                    'json_error_code' => json_last_error(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => '生成されたデータの解析に失敗しました。JSONエラー: '.json_last_error_msg(),
                ], 500);
            }

            // 文字数制限を適用（100-200文字）
            if (isset($decoded['job_summary'])) {
                $summary = $decoded['job_summary'];
                $textLength = mb_strlen($summary, 'UTF-8');
                if ($textLength > 200) {
                    $targetLength = 200;
                    $truncated = mb_substr($summary, 0, $targetLength, 'UTF-8');
                    // 最後の完全な文（句点で終わる文）を見つける
                    $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                    if ($lastPeriod !== false && $lastPeriod > 100) {
                        // 句点が見つかり、十分な長さがあれば、その位置まで戻す
                        $summary = mb_substr($summary, 0, $lastPeriod + 1, 'UTF-8');
                    } else {
                        // 句点が見つからない場合や遠すぎる場合、読点を探す
                        $lastComma = mb_strrpos($truncated, '、', 0, 'UTF-8');
                        if ($lastComma !== false && $lastComma > 100) {
                            // 読点が見つかり、十分な長さがあれば、その位置+1文字（読点含む）まで
                            $summary = mb_substr($summary, 0, $lastComma + 1, 'UTF-8');
                        } else {
                            // それでも見つからない場合は、少し余裕を持たせて文字数制限を緩和
                            $maxLength = (int) ($targetLength * 1.1);
                            if ($textLength <= $maxLength) {
                                // そのまま使用
                            } else {
                                // 最大長まで切り詰め、句点を探す
                                $truncated = mb_substr($summary, 0, $maxLength, 'UTF-8');
                                $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                                if ($lastPeriod !== false && $lastPeriod > 100) {
                                    $summary = mb_substr($summary, 0, $lastPeriod + 1, 'UTF-8');
                                } else {
                                    $summary = $truncated;
                                }
                            }
                        }
                    }
                }
                $decoded['job_summary'] = $summary;
            }

            return response()->json([
                'success' => true,
                'data' => $decoded,
            ]);
        } catch (\Exception $e) {
            \Log::error('Job summary generation error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '職務要約の生成中にエラーが発生しました。',
            ], 500);
        }
    }

    /**
     * 自己PRをAI生成
     */
    public function generateSelfPR(Request $request)
    {
        \Log::info('generateSelfPR called', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check(),
        ]);

        // 会員限定機能
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'この機能は会員限定です。ログインしてください。',
            ], 403);
        }

        $careerHistories = $request->input('career_histories', []);

        if (empty($careerHistories) || ! is_array($careerHistories)) {
            return response()->json([
                'success' => false,
                'message' => '職務経歴の職務内容が一つも入力されていません。',
            ], 400);
        }

        // 職務内容を抽出
        $jobDescriptions = [];
        foreach ($careerHistories as $career) {
            if (! empty($career['job_description'])) {
                $jobDescriptions[] = $career['job_description'];
            }
        }

        if (empty($jobDescriptions)) {
            return response()->json([
                'success' => false,
                'message' => '職務経歴の職務内容が一つも入力されていません。',
            ], 400);
        }

        // Gemini APIのプロンプトを作成
        $prompt = "以下の職務経歴の職務内容をもとに、自己PRを生成してください。\n\n";
        $prompt .= "【職務経歴の職務内容】\n";
        foreach ($jobDescriptions as $index => $description) {
            $prompt .= ($index + 1).'. '.$description."\n";
        }
        $prompt .= "\n";
        $prompt .= "上記の職務内容をもとに、自己PRを100-200文字で簡潔にまとめてください。\n";
        $prompt .= "職務内容に基づいた自己PRとして、経験した業務内容から得たスキルや強みを簡潔にまとめてください。\n\n";
        $prompt .= "【出力形式】\n";
        $prompt .= "以下のJSON形式で出力してください。\n";
        $prompt .= "{\n";
        $prompt .= '  "self_pr": "自己PR（100-200文字で簡潔に）"'."\n";
        $prompt .= "}\n\n";
        $prompt .= "【重要な指示】\n";
        $prompt .= "1. 自己PRは100-200文字で簡潔にまとめてください。\n";
        $prompt .= "2. 職務内容に基づいた自己PRとして、経験した業務内容から得たスキルや強みを簡潔にまとめてください。\n";
        $prompt .= "3. 出力は必ずJSON形式のみで、余計な説明やコメントは一切含めないでください。\n";
        $prompt .= "4. JSONの値に改行文字（\\n）は含めないでください。\n";

        try {
            $apiKey = config('services.gemini.api_key');

            if (empty($apiKey)) {
                \Log::error('Gemini API key is not configured');

                return response()->json([
                    'success' => false,
                    'message' => 'AI生成サービスが利用できません。GEMINI_API_KEYが設定されていません。',
                ], 500);
            }

            // Gemini API 2.5 Flash を使用
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
            \Log::info('Gemini API request for self PR', [
                'url' => preg_replace('/key=[^&]+/', 'key=***', $url),
                'prompt_length' => mb_strlen($prompt, 'UTF-8'),
            ]);

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

            if (! $response->successful()) {
                $errorBody = $response->body();
                \Log::error('Gemini API HTTP error for self PR', [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'url' => $url,
                ]);

                $errorMessage = '自己PRの生成に失敗しました。APIエラー: '.$response->status();
                if ($errorData = $response->json()) {
                    if (isset($errorData['error']['message'])) {
                        $errorMessage .= ' - '.$errorData['error']['message'];
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            $responseData = $response->json();

            if (! isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                \Log::error('Gemini API response structure error for self PR', [
                    'response_data' => $responseData,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'APIからの応答形式が正しくありません。',
                ], 500);
            }

            $generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);

            // JSONを抽出（コードブロックがあれば除去）
            $generatedText = preg_replace('/```json\s*/', '', $generatedText);
            $generatedText = preg_replace('/```\s*/', '', $generatedText);
            $generatedText = trim($generatedText);

            // JSONをパース
            $decoded = json_decode($generatedText, true);

            if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
                \Log::error('Failed to parse JSON from Gemini API for self PR', [
                    'generated_text' => $generatedText,
                    'json_error' => json_last_error_msg(),
                    'json_error_code' => json_last_error(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => '生成されたデータの解析に失敗しました。JSONエラー: '.json_last_error_msg(),
                ], 500);
            }

            // 文字数制限を適用（100-200文字）
            if (isset($decoded['self_pr'])) {
                $selfPR = $decoded['self_pr'];
                $textLength = mb_strlen($selfPR, 'UTF-8');
                if ($textLength > 200) {
                    $targetLength = 200;
                    $truncated = mb_substr($selfPR, 0, $targetLength, 'UTF-8');
                    // 最後の完全な文（句点で終わる文）を見つける
                    $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                    if ($lastPeriod !== false && $lastPeriod > 100) {
                        // 句点が見つかり、十分な長さがあれば、その位置まで戻す
                        $selfPR = mb_substr($selfPR, 0, $lastPeriod + 1, 'UTF-8');
                    } else {
                        // 句点が見つからない場合や遠すぎる場合、読点を探す
                        $lastComma = mb_strrpos($truncated, '、', 0, 'UTF-8');
                        if ($lastComma !== false && $lastComma > 100) {
                            // 読点が見つかり、十分な長さがあれば、その位置+1文字（読点含む）まで
                            $selfPR = mb_substr($selfPR, 0, $lastComma + 1, 'UTF-8');
                        } else {
                            // それでも見つからない場合は、少し余裕を持たせて文字数制限を緩和
                            $maxLength = (int) ($targetLength * 1.1);
                            if ($textLength <= $maxLength) {
                                // そのまま使用
                            } else {
                                // 最大長まで切り詰め、句点を探す
                                $truncated = mb_substr($selfPR, 0, $maxLength, 'UTF-8');
                                $lastPeriod = mb_strrpos($truncated, '。', 0, 'UTF-8');
                                if ($lastPeriod !== false && $lastPeriod > 100) {
                                    $selfPR = mb_substr($selfPR, 0, $lastPeriod + 1, 'UTF-8');
                                } else {
                                    $selfPR = $truncated;
                                }
                            }
                        }
                    }
                }
                $decoded['self_pr'] = $selfPR;
            }

            return response()->json([
                'success' => true,
                'data' => $decoded,
            ]);
        } catch (\Exception $e) {
            \Log::error('Self PR generation error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '自己PRの生成中にエラーが発生しました。',
            ], 500);
        }
    }
}
