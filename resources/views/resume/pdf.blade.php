<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A3 landscape;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @font-face {
            font-family: 'ipaexg';
            src: url('{{ storage_path("app/fonts/ipaexg.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'ipaexg', 'IPAexGothic', 'IPAex ゴシック', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.5;
        }
        .resume-page {
            width: 420mm;
            height: 297mm;
            border: 0.2mm solid #000;
            page-break-after: always;
            position: relative;
        }
        .resume-page:last-child {
            page-break-after: auto;
        }
        table {
            width: 420mm;
            height: 297mm;
            border-collapse: collapse;
            table-layout: fixed;
        }
        td {
            border: 0.2mm solid #000;
            padding: 1mm;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }
        .header-label {
            background-color: #f5f5f5;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            width: 20mm;
        }
        .resume-title {
            font-size: 18pt;
            font-weight: bold;
            text-align: center;
            height: 12mm;
        }
        .date-cell {
            text-align: right;
            padding-right: 5mm;
            font-size: 11pt;
        }
        .photo-cell {
            text-align: center;
            vertical-align: middle;
            width: 45mm;
            font-size: 8pt;
            color: #666;
            padding: 3mm;
        }
        .name-kana-cell {
            width: 50mm;
        }
        .name-cell {
            width: 75mm;
        }
        .birthday-cell {
            width: 100mm;
        }
        .gender-cell {
            width: 25mm;
            text-align: center;
        }
        .phone-cell {
            width: 65mm;
        }
        .address-cell {
            width: 170mm;
        }
        .year-cell {
            width: 32mm;
            text-align: center;
        }
        .month-cell {
            width: 28mm;
            text-align: center;
        }
        .content-cell {
            width: 360mm;
            padding: 2mm;
        }
        .history-row {
            height: 10mm;
        }
        .appeal-cell {
            height: 75mm;
            vertical-align: top;
            white-space: pre-wrap;
            padding: 3mm;
        }
        .request-cell {
            height: 95mm;
            vertical-align: top;
            white-space: pre-wrap;
            padding: 3mm;
        }
        .empty-cell {
            height: 10mm;
        }
    </style>
</head>
<body>
    <!-- 1ページ目 -->
    <div class="resume-page">
        <table>
            <!-- タイトル行 -->
            <tr>
                <td colspan="3" class="resume-title">履歴書</td>
                <td colspan="2" class="date-cell">{{ date('Y') }}年{{ date('n') }}月{{ date('j') }}日現在</td>
            </tr>
            
            <!-- ふりがな・氏名・写真行（5列構成） -->
            <tr style="height: 14mm;">
                <td class="header-label">ふりがな</td>
                <td class="name-kana-cell">{{ $resumeData['name_kana'] ?? '' }}</td>
                <td class="header-label">氏名</td>
                <td class="name-cell">{{ $resumeData['name_roman'] ?? '' }}</td>
                <td rowspan="4" class="photo-cell">
                    写真をはる位置<br><br>
                    <small>写真をはる必要がある場合<br>
                    1. 縦 36～40mm<br>
                    横 24～30mm<br>
                    2. 本人単身胸から上<br>
                    3. 裏面のりづけ</small>
                </td>
            </tr>
            
            <!-- 生年月日・性別行 -->
            <tr style="height: 14mm;">
                <td class="header-label">年月日生</td>
                <td colspan="2" class="birthday-cell">
                    @if(!empty($resumeData['birthday']))
                        @php
                            $date = \Carbon\Carbon::parse($resumeData['birthday']);
                        @endphp
                        {{ $date->format('Y') }}年{{ $date->format('n') }}月{{ $date->format('j') }}日生（満{{ $date->age }}歳）
                    @endif
                </td>
                <td class="header-label">※性別</td>
                <td class="gender-cell">{{ $resumeData['gender'] ?? '' }}</td>
            </tr>
            
            <!-- ふりがな・電話行 -->
            <tr style="height: 14mm;">
                <td class="header-label">ふりがな</td>
                <td class="name-kana-cell"></td>
                <td class="header-label">電話</td>
                <td colspan="2" class="phone-cell">{{ $resumeData['phone'] ?? '' }}</td>
            </tr>
            
            <!-- ふりがな・現住所行 -->
            <tr style="height: 14mm;">
                <td class="header-label">ふりがな</td>
                <td class="name-kana-cell">{{ $resumeData['address_kana'] ?? '' }}</td>
                <td class="header-label">現住所</td>
                <td class="address-cell">〒{{ $resumeData['postal_code'] ?? '' }} {{ $resumeData['address'] ?? '' }}</td>
            </tr>
            
            <!-- ふりがな・連絡先行 -->
            <tr style="height: 14mm;">
                <td class="header-label">ふりがな</td>
                <td class="name-kana-cell"></td>
                <td class="header-label">連絡先</td>
                <td colspan="2" style="font-size: 9pt; color: #666;">（現住所以外に連絡を希望する場合のみ記入）</td>
            </tr>
            
            <!-- 学歴・職歴ヘッダー -->
            <tr style="height: 12mm;">
                <td class="header-label">年</td>
                <td class="header-label">月</td>
                <td colspan="3" class="header-label">学歴・職歴（各別にまとめて書く）</td>
            </tr>
            
            @php
                $totalHistory = [];
                if (!empty($resumeData['education'])) {
                    foreach ($resumeData['education'] as $edu) {
                        if (!empty($edu['date']) && !empty($edu['school_name']) && !empty($edu['event_type'])) {
                            $date = \Carbon\Carbon::parse($edu['date']);
                            $totalHistory[] = [
                                'year' => $date->year,
                                'month' => $date->month,
                                'content' => ($edu['school_name'] ?? '') . '　' . ($edu['event_type'] ?? '')
                            ];
                        }
                    }
                }
                if (!empty($resumeData['work_history'])) {
                    foreach ($resumeData['work_history'] as $work) {
                        if (!empty($work['date']) && !empty($work['company_name']) && !empty($work['event_type'])) {
                            $date = \Carbon\Carbon::parse($work['date']);
                            $totalHistory[] = [
                                'year' => $date->year,
                                'month' => $date->month,
                                'content' => ($work['company_name'] ?? '') . '　' . ($work['event_type'] ?? '')
                            ];
                        }
                    }
                }
                // 1ページ目に15行表示
                $firstPageHistory = array_slice($totalHistory, 0, 15);
                $remainingHistory = array_slice($totalHistory, 15);
                // 15行に満たない場合は空行で埋める
                while (count($firstPageHistory) < 15) {
                    $firstPageHistory[] = ['year' => '', 'month' => '', 'content' => ''];
                }
            @endphp
            
            @foreach($firstPageHistory as $history)
            <tr class="history-row">
                <td class="year-cell">{{ $history['year'] }}</td>
                <td class="month-cell">{{ $history['month'] }}</td>
                <td colspan="3" class="content-cell">{{ $history['content'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    
    <!-- 2ページ目 -->
    <div class="resume-page">
        <table>
            <!-- 学歴・職歴の続きヘッダー -->
            <tr style="height: 12mm;">
                <td class="header-label">年</td>
                <td class="header-label">月</td>
                <td colspan="3" class="header-label">学歴・職歴（各別にまとめて書く）</td>
            </tr>
            
            @foreach($remainingHistory as $history)
            <tr class="history-row">
                <td class="year-cell">{{ $history['year'] }}</td>
                <td class="month-cell">{{ $history['month'] }}</td>
                <td colspan="3" class="content-cell">{{ $history['content'] }}</td>
            </tr>
            @endforeach
            
            @php
                $remainingRows = 8 - count($remainingHistory);
            @endphp
            @for($i = 0; $i < $remainingRows; $i++)
            <tr class="empty-cell">
                <td class="year-cell"></td>
                <td class="month-cell"></td>
                <td colspan="3" class="content-cell"></td>
            </tr>
            @endfor
            
            <!-- 資格・免許ヘッダー -->
            <tr style="height: 12mm;">
                <td class="header-label">年</td>
                <td class="header-label">月</td>
                <td colspan="3" class="header-label">資格・免許</td>
            </tr>
            
            @php
                $licenses = $resumeData['licenses'] ?? [];
                $licenseCount = 0;
            @endphp
            
            @foreach($licenses as $license)
                @if(!empty($license['date']) && !empty($license['name']))
                    @php
                        $licenseDate = \Carbon\Carbon::parse($license['date']);
                        $licenseCount++;
                    @endphp
                    <tr class="history-row">
                        <td class="year-cell">{{ $licenseDate->year }}</td>
                        <td class="month-cell">{{ $licenseDate->month }}</td>
                        <td colspan="3" class="content-cell">{{ $license['name'] ?? '' }}　取得</td>
                    </tr>
                @endif
            @endforeach
            
            @for($i = $licenseCount; $i < 7; $i++)
            <tr class="empty-cell">
                <td class="year-cell"></td>
                <td class="month-cell"></td>
                <td colspan="3" class="content-cell"></td>
            </tr>
            @endfor
            
            <!-- 志望動機・アピールポイント -->
            <tr style="height: 12mm;">
                <td colspan="5" class="header-label">志望の動機、特技、好きな学科、アピールポイントなど</td>
            </tr>
            <tr>
                <td colspan="5" class="appeal-cell">{{ $resumeData['appeal_points'] ?? '' }}</td>
            </tr>
            
            <!-- 本人希望記入欄 -->
            <tr style="height: 12mm;">
                <td colspan="5" class="header-label">本人希望記入欄（特に給料・職種・勤務時間・勤務地・その他についての希望などがあれば記入）</td>
            </tr>
            <tr>
                <td colspan="5" class="request-cell">{{ $resumeData['self_request'] ?? '' }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
