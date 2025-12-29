<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeService
{
    /**
     * HTMLテンプレートからPDFを生成（Browsershot使用）
     *
     * @param array $resumeData
     * @return string ダウンロード用のPDFファイルパス
     */
    public function generatePdfFromHtml(array $resumeData): string
    {
        // 実行時間制限を設定
        set_time_limit(120);
        ini_set('memory_limit', '512M');
        
        $templatePath = storage_path('app/templates/01_A4_format.htm');
        
        if (!file_exists($templatePath)) {
            throw new \Exception('テンプレートファイルが見つかりません: ' . $templatePath);
        }
        
        try {
            Log::info('Starting PDF generation from HTML template with Browsershot', ['template_path' => $templatePath]);
            
            // テンプレートを読み込む
            $html = file_get_contents($templatePath);
            
            // データを埋め込む
            $html = $this->populateHtmlTemplate($html, $resumeData);
            
            // tempディレクトリが存在しない場合は作成
            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            // PDFファイル名
            $nameKana = ($resumeData['last_name_kana'] ?? '') . ($resumeData['first_name_kana'] ?? '');
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameKana ?: 'resume');
            $fileName = '履歴書_' . $safeName . '_' . date('YmdHis') . '.pdf';
            $outputPath = storage_path('app/temp/' . $fileName);
            
            // BrowsershotでPDFを生成（利用可能な場合）
            try {
                if (!class_exists(\Spatie\Browsershot\Browsershot::class)) {
                    throw new \Exception('Browsershot class not found. Please install: composer require spatie/browsershot');
                }
                
                $browsershot = \Spatie\Browsershot\Browsershot::html($html)
                    ->format('A3')
                    ->landscape()
                    ->margins(0, 0, 0, 0, 'mm') // 全方向余白0mm
                    ->showBackground() // 背景色と罫線を強制描写
                    ->waitUntilNetworkIdle() // ネットワークアイドルを待機
                    ->noSandbox(); // セキュリティ設定
                
                // Chrome/Chromiumのパスを環境変数から取得（設定されている場合）
                $chromePath = config('browsershot.chrome_path') ?? env('BROWSERSHOT_CHROME_PATH');
                if ($chromePath) {
                    $browsershot->setChromePath($chromePath);
                }
                
                // 日本語フォント対応のための設定
                $browsershot->setOption('args', [
                    '--disable-web-security',
                    '--disable-features=IsolateOrigins,site-per-process',
                    '--font-render-hinting=none',
                ]);
                
                // PDFを生成
                $browsershot->save($outputPath);
                
                Log::info('PDF generated successfully with Browsershot');
            } catch (\Throwable $browsershotError) {
                Log::warning('Browsershot failed, falling back to dompdf: ' . $browsershotError->getMessage());
                
                // Browsershotが失敗した場合はdompdfにフォールバック
                $pdf = Pdf::loadHTML($html);
                $pdf->setPaper('a3', 'landscape');
                $pdf->setOption('margin-top', 0);
                $pdf->setOption('margin-right', 0);
                $pdf->setOption('margin-bottom', 0);
                $pdf->setOption('margin-left', 0);
                $pdf->setOption('enable-remote', true);
                $pdf->save($outputPath);
                
                Log::info('PDF generated successfully with dompdf (fallback)');
            }
            
            Log::info('PDF generated successfully from HTML template with Browsershot', ['path' => $outputPath]);
            
            return $outputPath;
            
        } catch (\Throwable $e) {
            Log::error('PDF generation error from HTML: ' . $e->getMessage());
            Log::error('Error class: ' . get_class($e));
            Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            throw $e;
        }
    }
    
    /**
     * HTMLテンプレートからPDFを直接生成してバイナリを返す（Browsershot使用）
     *
     * @param array $resumeData
     * @return string PDFバイナリデータ
     */
    public function generatePdfBinaryFromHtml(array $resumeData): string
    {
        // 実行時間制限を設定
        set_time_limit(120);
        ini_set('memory_limit', '512M');
        
        $templatePath = storage_path('app/templates/01_A4_format.htm');
        
        if (!file_exists($templatePath)) {
            throw new \Exception('テンプレートファイルが見つかりません: ' . $templatePath);
        }
        
        try {
            Log::info('Starting PDF binary generation from HTML template with Browsershot', ['template_path' => $templatePath]);
            
            // テンプレートを読み込む
            $html = file_get_contents($templatePath);
            
            // データを埋め込む
            $html = $this->populateHtmlTemplate($html, $resumeData);
            
            // BrowsershotでPDFを生成（利用可能な場合）
            try {
                if (!class_exists(\Spatie\Browsershot\Browsershot::class)) {
                    throw new \Exception('Browsershot class not found');
                }
                
                $browsershot = \Spatie\Browsershot\Browsershot::html($html)
                    ->format('A3')
                    ->landscape()
                    ->margins(0, 0, 0, 0, 'mm') // 全方向余白0mm
                    ->showBackground() // 背景色と罫線を強制描写
                    ->waitUntilNetworkIdle() // ネットワークアイドルを待機
                    ->noSandbox(); // セキュリティ設定
                
                // Chrome/Chromiumのパスを環境変数から取得（設定されている場合）
                $chromePath = config('browsershot.chrome_path') ?? env('BROWSERSHOT_CHROME_PATH');
                if ($chromePath) {
                    $browsershot->setChromePath($chromePath);
                }
                
                // 日本語フォント対応のための設定
                $browsershot->setOption('args', [
                    '--disable-web-security',
                    '--disable-features=IsolateOrigins,site-per-process',
                    '--font-render-hinting=none',
                ]);
                
                // PDFバイナリを取得
                $pdfBinary = $browsershot->pdf();
                
                Log::info('PDF binary generated successfully with Browsershot');
            } catch (\Throwable $browsershotError) {
                Log::warning('Browsershot failed, falling back to dompdf: ' . $browsershotError->getMessage());
                
                // Browsershotが失敗した場合はdompdfにフォールバック
                $pdf = Pdf::loadHTML($html);
                $pdf->setPaper('a3', 'landscape');
                $pdf->setOption('margin-top', 0);
                $pdf->setOption('margin-right', 0);
                $pdf->setOption('margin-bottom', 0);
                $pdf->setOption('margin-left', 0);
                $pdf->setOption('enable-remote', true);
                
                // 一時ファイルに保存してから読み込む
                $tempPath = storage_path('app/temp/temp_' . uniqid() . '.pdf');
                $pdf->save($tempPath);
                $pdfBinary = file_get_contents($tempPath);
                @unlink($tempPath);
                
                Log::info('PDF binary generated successfully with dompdf (fallback)');
            }
            
            Log::info('PDF binary generated successfully from HTML template with Browsershot');
            
            return $pdfBinary;
            
        } catch (\Throwable $e) {
            Log::error('PDF binary generation error from HTML: ' . $e->getMessage());
            Log::error('Error class: ' . get_class($e));
            Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            throw $e;
        }
    }
    
    /**
     * HTMLテンプレートにデータを埋め込む
     */
    private function populateHtmlTemplate(string $html, array $data): string
    {
        // JavaScriptで生成される要素を事前に生成（dompdfはJavaScriptを実行しないため）
        $html = $this->replaceScriptGeneratedElements($html);
        // 現在の日付
        $html = str_replace('<span id="current_date"></span>', '<span id="current_date">' . date('Y') . '年' . date('n') . '月' . date('j') . '日現在</span>', $html);
        
        // 氏名フリガナ
        $lastNameKana = trim($data['last_name_kana'] ?? '');
        $firstNameKana = trim($data['first_name_kana'] ?? '');
        $nameKana = trim($lastNameKana . ' ' . $firstNameKana);
        $html = str_replace('<span id="name_kana"></span>', '<span id="name_kana">' . htmlspecialchars($nameKana, ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 氏名（漢字/ローマ字）
        $lastNameRoman = trim($data['last_name_roman'] ?? '');
        $firstNameRoman = trim($data['first_name_roman'] ?? '');
        $nameKanji = trim($lastNameRoman . ' ' . $firstNameRoman);
        $html = str_replace('<span id="name_kanji"></span>', '<span id="name_kanji">' . htmlspecialchars($nameKanji, ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 生年月日と年齢
        $birthDate = '';
        $age = '';
        if (!empty($data['birthday'])) {
            try {
                $date = Carbon::parse($data['birthday']);
                $birthDate = $date->format('Y') . '年' . $date->format('n') . '月' . $date->format('j') . '日生';
                $age = '（満' . $date->age . '歳）';
            } catch (\Exception $e) {
                Log::warning('Birthday parsing error: ' . $e->getMessage());
            }
        }
        $html = str_replace('<span id="birth_date"></span>', '<span id="birth_date">' . htmlspecialchars($birthDate, ENT_QUOTES, 'UTF-8') . '</span>', $html);
        $html = str_replace('<span id="age"></span>', '<span id="age">' . htmlspecialchars($age, ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 性別
        $html = str_replace('<span id="gender"></span>', '<span id="gender">' . htmlspecialchars($data['gender'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 現住所フリガナ
        $html = str_replace('<span id="addr_kana_1"></span>', '<span id="addr_kana_1">' . htmlspecialchars($data['address_kana'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 現住所郵便番号
        $html = str_replace('<span id="addr_zip_1"></span>', '<span id="addr_zip_1">' . htmlspecialchars($data['postal_code'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 現住所
        $address = htmlspecialchars($data['address'] ?? '', ENT_QUOTES, 'UTF-8');
        $html = str_replace('<span id="addr_full_1" style="display:block; margin-top:2mm;"></span>', '<span id="addr_full_1" style="display:block; margin-top:2mm;">' . $address . '</span>', $html);
        
        // 電話番号
        $html = str_replace('<span id="tel_1"></span>', '<span id="tel_1">' . htmlspecialchars($data['phone'] ?? '', ENT_QUOTES, 'UTF-8') . '</span>', $html);
        
        // 学歴・職歴
        $educationAndWorkHistory = [];
        
        // 学歴を追加
        if (!empty($data['education'])) {
            foreach ($data['education'] as $edu) {
                if (!empty($edu['date']) && !empty($edu['school_name']) && !empty($edu['event_type'])) {
                    try {
                        $date = Carbon::parse($edu['date']);
                        $educationAndWorkHistory[] = [
                            'year' => $date->year,
                            'month' => $date->month,
                            'content' => ($edu['school_name'] ?? '') . '　' . ($edu['event_type'] ?? ''),
                        ];
                    } catch (\Exception $e) {
                        Log::warning('Education date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // 職歴を追加
        if (!empty($data['work_history'])) {
            foreach ($data['work_history'] as $work) {
                if (!empty($work['date']) && !empty($work['company_name']) && !empty($work['event_type'])) {
                    try {
                        $date = Carbon::parse($work['date']);
                        $educationAndWorkHistory[] = [
                            'year' => $date->year,
                            'month' => $date->month,
                            'content' => ($work['company_name'] ?? '') . '　' . ($work['event_type'] ?? ''),
                        ];
                        
                        // 職務内容がある場合
                        if (!empty($work['job_detail'])) {
                            $educationAndWorkHistory[] = [
                                'year' => '',
                                'month' => '',
                                'content' => $work['job_detail'],
                            ];
                        }
                    } catch (\Exception $e) {
                        Log::warning('Work history date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // 学歴・職歴を埋め込む（01-21）
        for ($i = 1; $i <= 21; $i++) {
            $id = str_pad($i, 2, '0', STR_PAD_LEFT);
            $index = $i - 1;
            
            if (isset($educationAndWorkHistory[$index])) {
                $item = $educationAndWorkHistory[$index];
                // tdタグの中身だけを置換
                $html = str_replace('<td id="edu_year_' . $id . '" class="center"></td>', '<td id="edu_year_' . $id . '" class="center">' . htmlspecialchars((string)$item['year'], ENT_QUOTES, 'UTF-8') . '</td>', $html);
                $html = str_replace('<td id="edu_month_' . $id . '" class="center"></td>', '<td id="edu_month_' . $id . '" class="center">' . htmlspecialchars((string)$item['month'], ENT_QUOTES, 'UTF-8') . '</td>', $html);
                $html = str_replace('<td id="edu_content_' . $id . '" class="dotted-col"></td>', '<td id="edu_content_' . $id . '" class="dotted-col">' . htmlspecialchars($item['content'], ENT_QUOTES, 'UTF-8') . '</td>', $html);
            }
        }
        
        // 免許・資格（01-07）
        if (!empty($data['licenses'])) {
            $licenseIndex = 0;
            foreach ($data['licenses'] as $license) {
                if (!empty($license['date']) && !empty($license['name']) && $licenseIndex < 7) {
                    try {
                        $date = Carbon::parse($license['date']);
                        $id = str_pad($licenseIndex + 1, 2, '0', STR_PAD_LEFT);
                        // tdタグの中身だけを置換
                        $html = str_replace('<td id="license_year_' . $id . '" class="center"></td>', '<td id="license_year_' . $id . '" class="center">' . htmlspecialchars((string)$date->year, ENT_QUOTES, 'UTF-8') . '</td>', $html);
                        $html = str_replace('<td id="license_month_' . $id . '" class="center"></td>', '<td id="license_month_' . $id . '" class="center">' . htmlspecialchars((string)$date->month, ENT_QUOTES, 'UTF-8') . '</td>', $html);
                        $html = str_replace('<td id="license_content_' . $id . '" class="dotted-col"></td>', '<td id="license_content_' . $id . '" class="dotted-col">' . htmlspecialchars(($license['name'] ?? '') . '　取得', ENT_QUOTES, 'UTF-8') . '</td>', $html);
                        $licenseIndex++;
                    } catch (\Exception $e) {
                        Log::warning('License date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
        
        // 志望動機
        $motivation = nl2br(htmlspecialchars($data['appeal_points'] ?? '', ENT_QUOTES, 'UTF-8'));
        $html = str_replace('<td id="motivation" style="vertical-align: top; height: 55mm;"></td>', '<td id="motivation" style="vertical-align: top; height: 55mm;">' . $motivation . '</td>', $html);
        
        // 本人希望
        $expectations = nl2br(htmlspecialchars($data['self_request'] ?? '', ENT_QUOTES, 'UTF-8'));
        $html = str_replace('<td id="expectations" style="vertical-align: top; height: 35mm;"></td>', '<td id="expectations" style="vertical-align: top; height: 35mm;">' . $expectations . '</td>', $html);
        
        return $html;
    }
    
    /**
     * JavaScriptで生成される要素をHTMLに展開（dompdfはJavaScriptを実行しないため）
     */
    private function replaceScriptGeneratedElements(string $html): string
    {
        // 学歴・職歴の行（01-16）を生成
        $eduRows1 = '';
        for ($i = 1; $i <= 16; $i++) {
            $id = str_pad($i, 2, '0', STR_PAD_LEFT);
            $eduRows1 .= '<tr class="row-history"><td id="edu_year_' . $id . '" class="center"></td><td id="edu_month_' . $id . '" class="center"></td><td id="edu_content_' . $id . '" class="dotted-col"></td></tr>';
        }
        $html = preg_replace('/<script>\s*for\(let i=1; i<=16; i\+\+\)[^<]*<\/script>/s', $eduRows1, $html);
        
        // 学歴・職歴の行（17-21）を生成
        $eduRows2 = '';
        for ($i = 17; $i <= 21; $i++) {
            $id = str_pad($i, 2, '0', STR_PAD_LEFT);
            $eduRows2 .= '<tr class="row-history"><td id="edu_year_' . $id . '" class="center"></td><td id="edu_month_' . $id . '" class="center"></td><td id="edu_content_' . $id . '" class="dotted-col"></td></tr>';
        }
        $html = preg_replace('/<script>\s*for\(let i=17; i<=21; i\+\+\)[^<]*<\/script>/s', $eduRows2, $html);
        
        // 免許・資格の行（01-07）を生成
        $licenseRows = '';
        for ($i = 1; $i <= 7; $i++) {
            $id = str_pad($i, 2, '0', STR_PAD_LEFT);
            $licenseRows .= '<tr class="row-history"><td id="license_year_' . $id . '" class="center"></td><td id="license_month_' . $id . '" class="center"></td><td id="license_content_' . $id . '" class="dotted-col"></td></tr>';
        }
        $html = preg_replace('/<script>\s*for\(let i=1; i<=7; i\+\+\)[^<]*<\/script>/s', $licenseRows, $html);
        
        return $html;
    }

    /**
     * Excelテンプレートにデータを書き込んでPDFとしてダウンロード用のファイルパスを返す
     *
     * @param array $resumeData
     * @return string ダウンロード用のPDFファイルパス
     */
    public function generatePdf(array $resumeData): string
    {
        // 実行時間制限を設定
        set_time_limit(60); // 1分
        ini_set('memory_limit', '256M');
        
        $templatePath = storage_path('app/templates/rirekisho_01_A4.xlsx');
        
        if (!file_exists($templatePath)) {
            throw new \Exception('テンプレートファイルが見つかりません: ' . $templatePath);
        }

        try {
            Log::info('Starting PDF generation', ['template_path' => $templatePath]);
            
            // テンプレートを読み込む
            $spreadsheet = IOFactory::load($templatePath);
            Log::info('Template loaded successfully');
            
            $worksheet = $spreadsheet->getActiveSheet();
            Log::info('Active sheet retrieved');

            // データを書き込む
            Log::info('Writing basic info');
            $this->writeBasicInfo($worksheet, $resumeData);
            
            Log::info('Writing education and work history');
            $this->writeEducationAndWorkHistory($worksheet, $resumeData);
            
            Log::info('Writing licenses');
            $this->writeLicenses($worksheet, $resumeData);
            
            Log::info('Writing appeal points');
            $this->writeAppealPoints($worksheet, $resumeData);
            
            Log::info('Writing self request');
            $this->writeSelfRequest($worksheet, $resumeData);

            // tempディレクトリが存在しない場合は作成
            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
                Log::info('Temp directory created', ['path' => $tempDir]);
            }

            // PDFファイル名
            $nameKana = ($resumeData['first_name_kana'] ?? '') . ($resumeData['last_name_kana'] ?? '');
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nameKana ?: 'resume');
            $fileName = '履歴書_' . $safeName . '_' . date('YmdHis') . '.pdf';
            $outputPath = storage_path('app/temp/' . $fileName);
            
            Log::info('Creating PDF writer', ['output_path' => $outputPath]);

            // ページサイズと向きの設定（A4縦）
            $worksheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            $worksheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            
            // 印刷範囲の設定（不要な処理を減らす）
            $worksheet->getPageSetup()->setFitToWidth(1);
            $worksheet->getPageSetup()->setFitToHeight(0);
            
            Log::info('Page setup configured');
            
            // 計算を無効化してパフォーマンスを向上（不要な行を削除）
            
            // 一時Excelファイルとして保存
            $tempExcelPath = storage_path('app/temp/' . $safeName . '_' . date('YmdHis') . '.xlsx');
            Log::info('Saving temporary Excel file', ['path' => $tempExcelPath]);
            
            $excelWriter = new Xlsx($spreadsheet);
            $excelWriter->save($tempExcelPath);
            
            if (!file_exists($tempExcelPath)) {
                throw new \Exception('Excel file was not created: ' . $tempExcelPath);
            }
            
            Log::info('Excel file saved successfully', ['path' => $tempExcelPath, 'size' => filesize($tempExcelPath)]);
            
            // LibreOfficeでPDF化を試みる（利用可能な場合）
            $libreOfficePath = trim(shell_exec('which libreoffice') ?: '');
            if (!empty($libreOfficePath)) {
                Log::info('Using LibreOffice to convert Excel to PDF', ['libreoffice_path' => $libreOfficePath]);
                
                $tempDir = dirname($tempExcelPath);
                $command = escapeshellarg($libreOfficePath) . ' --headless --convert-to pdf --outdir ' . escapeshellarg($tempDir) . ' ' . escapeshellarg($tempExcelPath) . ' 2>&1';
                
                Log::info('Executing LibreOffice command', ['command' => $command]);
                
                exec($command, $output, $returnCode);
                
                if ($returnCode === 0) {
                    $pdfPath = str_replace('.xlsx', '.pdf', $tempExcelPath);
                    if (file_exists($pdfPath)) {
                        // 一時Excelファイルを削除
                        @unlink($tempExcelPath);
                        
                        // 出力ファイル名にリネーム
                        rename($pdfPath, $outputPath);
                        
                        Log::info('PDF generated successfully using LibreOffice', ['path' => $outputPath]);
                        return $outputPath;
                    }
                } else {
                    Log::warning('LibreOffice conversion failed', ['return_code' => $returnCode, 'output' => implode("\n", $output)]);
                }
            }
            
            // TCPDFは無限ループの問題があるため、一旦Excelファイルを返す
            // ユーザーはExcelファイルを開いて、手動でPDFに変換できます
            // TODO: TCPDFの問題を解決するか、別のPDFライブラリを使用する
            Log::info('Excel file saved successfully. TCPDF conversion skipped due to timeout issues.', [
                'excel_path' => $tempExcelPath,
                'excel_size' => filesize($tempExcelPath)
            ]);
            
            // Excelファイルのパスを返す（コントローラー側で適切に処理する）
            return $tempExcelPath;

        } catch (\Throwable $e) {
            Log::error('PDF generation error: ' . $e->getMessage());
            Log::error('Error class: ' . get_class($e));
            Log::error('Error code: ' . $e->getCode());
            Log::error('Error file: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // より詳細なエラー情報
            if ($e->getPrevious()) {
                Log::error('Previous exception: ' . $e->getPrevious()->getMessage());
                Log::error('Previous exception class: ' . get_class($e->getPrevious()));
            }
            
            // メモリ使用状況も記録
            Log::error('Memory at error', ['memory' => memory_get_usage(true), 'peak' => memory_get_peak_usage(true)]);
            
            throw $e;
        }
    }

    /**
     * 基本情報を書き込む
     */
    private function writeBasicInfo($worksheet, array $data): void
    {
        // 日付（年月日現在）
        $worksheet->setCellValue('D1', date('Y') . '年' . date('n') . '月' . date('j') . '日現在');

        // ふりがな（氏名）- 姓名を結合（姓が先）
        $firstNameKana = trim($data['first_name_kana'] ?? '');
        $lastNameKana = trim($data['last_name_kana'] ?? '');
        // 古いデータ構造の場合は分割して処理
        if (empty($firstNameKana) && empty($lastNameKana) && isset($data['name_kana'])) {
            $nameKanaParts = explode(' ', $data['name_kana'], 2);
            $lastNameKana = $nameKanaParts[0] ?? '';
            $firstNameKana = $nameKanaParts[1] ?? '';
        }
        $nameKana = trim($lastNameKana . ' ' . $firstNameKana);
        $worksheet->setCellValue('B3', $nameKana);

        // 氏名 - 姓名を結合（姓が先）
        $firstNameRoman = trim($data['first_name_roman'] ?? '');
        $lastNameRoman = trim($data['last_name_roman'] ?? '');
        // 古いデータ構造の場合は分割して処理
        if (empty($firstNameRoman) && empty($lastNameRoman) && isset($data['name_roman'])) {
            $nameRomanParts = explode(' ', $data['name_roman'], 2);
            $lastNameRoman = $nameRomanParts[0] ?? '';
            $firstNameRoman = $nameRomanParts[1] ?? '';
        }
        $nameRoman = trim($lastNameRoman . ' ' . $firstNameRoman);
        $worksheet->setCellValue('D3', $nameRoman);

        // 生年月日
        if (!empty($data['birthday'])) {
            try {
                $date = Carbon::parse($data['birthday']);
                $birthdayText = $date->format('Y') . '年' . $date->format('n') . '月' . $date->format('j') . '日生（満' . $date->age . '歳）';
                $worksheet->setCellValue('B4', $birthdayText);
            } catch (\Exception $e) {
                Log::warning('Birthday parsing error: ' . $e->getMessage());
            }
        }

        // 性別
        $worksheet->setCellValue('D4', $data['gender'] ?? '');

        // 電話番号
        $worksheet->setCellValue('B5', $data['phone'] ?? '');

        // 現住所
        $address = '〒' . ($data['postal_code'] ?? '') . ' ' . ($data['address'] ?? '');
        $worksheet->setCellValue('B6', $address);

        // 連絡先（現住所以外）
        if (!empty($data['contact_address'])) {
            $contactAddress = '〒' . ($data['contact_postal_code'] ?? '') . ' ' . $data['contact_address'];
            $worksheet->setCellValue('B7', $contactAddress);
        }
    }

    /**
     * 学歴・職歴を書き込む
     */
    private function writeEducationAndWorkHistory($worksheet, array $data): void
    {
        $startRow = 10; // 学歴・職歴の開始行（調整が必要な場合があります）
        $currentRow = $startRow;

        // 学歴
        if (!empty($data['education'])) {
            foreach ($data['education'] as $edu) {
                if (!empty($edu['date']) && !empty($edu['school_name']) && !empty($edu['event_type'])) {
                    try {
                        $date = Carbon::parse($edu['date']);
                        $worksheet->setCellValue('A' . $currentRow, $date->year);
                        $worksheet->setCellValue('B' . $currentRow, $date->month);
                        $content = ($edu['school_name'] ?? '') . '　' . ($edu['event_type'] ?? '');
                        $worksheet->setCellValue('C' . $currentRow, $content);
                        $currentRow++;
                    } catch (\Exception $e) {
                        Log::warning('Education date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }

        // 職歴
        if (!empty($data['work_history'])) {
            foreach ($data['work_history'] as $work) {
                if (!empty($work['date']) && !empty($work['company_name']) && !empty($work['event_type'])) {
                    try {
                        $date = Carbon::parse($work['date']);
                        $worksheet->setCellValue('A' . $currentRow, $date->year);
                        $worksheet->setCellValue('B' . $currentRow, $date->month);
                        $content = ($work['company_name'] ?? '') . '　' . ($work['event_type'] ?? '');
                        $worksheet->setCellValue('C' . $currentRow, $content);
                        $currentRow++;

                        // 職務内容がある場合
                        if (!empty($work['job_detail'])) {
                            $worksheet->setCellValue('C' . $currentRow, $work['job_detail']);
                            $currentRow++;
                        }
                    } catch (\Exception $e) {
                        Log::warning('Work history date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * 資格・免許を書き込む
     */
    private function writeLicenses($worksheet, array $data): void
    {
        $startRow = 30; // 資格・免許の開始行（調整が必要な場合があります）
        $currentRow = $startRow;

        if (!empty($data['licenses'])) {
            foreach ($data['licenses'] as $license) {
                if (!empty($license['date']) && !empty($license['name'])) {
                    try {
                        $date = Carbon::parse($license['date']);
                        $worksheet->setCellValue('A' . $currentRow, $date->year);
                        $worksheet->setCellValue('B' . $currentRow, $date->month);
                        $worksheet->setCellValue('C' . $currentRow, ($license['name'] ?? '') . '　取得');
                        $currentRow++;
                    } catch (\Exception $e) {
                        Log::warning('License date parsing error: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * 志望動機・アピールポイントを書き込む
     */
    private function writeAppealPoints($worksheet, array $data): void
    {
        $row = 38; // 志望動機・アピールポイントの行（調整が必要な場合があります）
        $worksheet->setCellValue('A' . $row, $data['appeal_points'] ?? '');
    }

    /**
     * 本人希望記入欄を書き込む
     */
    private function writeSelfRequest($worksheet, array $data): void
    {
        $row = 45; // 本人希望記入欄の行（調整が必要な場合があります）
        $worksheet->setCellValue('A' . $row, $data['self_request'] ?? '');
    }
}

