<script>
    // Tailwind CSSのプリフライト（リセット）を無効化して、ヘッダーに影響しないようにする
    if (typeof window.tailwindConfig === 'undefined') {
        window.tailwindConfig = {
            corePlugins: {
                preflight: false,
            }
        };
    }
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    if (typeof tailwind !== 'undefined') {
        tailwind.config = window.tailwindConfig;
    }
</script>

<div class="w-full max-w-4xl mx-auto bg-white rounded-lg shadow-md p-4 sm:p-6" style="box-sizing: border-box; overflow-x: hidden;">
    <h2 class="text-2xl font-bold mb-4 text-center">内容確認 / विवरण जाँच गर्नुहोस्</h2>
    
    @php
        $data = $careerHistoryData ?? session('career_history_data');
    @endphp
    
    @if($data)
        <!-- PDFと同じHTMLを表示 -->
        <div class="career-history-preview" style="font-family: 'MS Gothic', 'MS PGothic', sans-serif; font-size: 12pt; margin: 20mm auto; max-width: 210mm; padding: 20px; background: white;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="text-align: center; font-size: 18pt; font-weight: bold; padding-bottom: 20px;">職務経歴書</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-bottom: 10px;">
                        {{ \Carbon\Carbon::now()->format('Y年n月j日') }}現在
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-bottom: 15px;">氏名：{{ trim(($data['last_name_roman'] ?? '').' '.($data['first_name_roman'] ?? '')) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding-top: 20px; padding-bottom: 10px;">■職務要約</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 20px; white-space: pre-wrap;">{{ $data['job_summary'] ?? '' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding-top: 20px; padding-bottom: 10px;">■職務経歴</td>
                </tr>
            </table>
            
            @if(!empty($data['career_histories']))
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 8px; background-color: #f0f0f0; font-weight: bold; width: 25%; text-align: center;">時期</th>
                        <th style="border: 1px solid #000; padding: 8px; background-color: #f0f0f0; font-weight: bold; width: 75%; text-align: center;">内容</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['career_histories'] as $career)
                        @php
                            $startDate = $career['start_date'] ?? '';
                            $endDate = $career['end_date'] ?? '';
                            $formatDate = function($dateStr) {
                                if (empty($dateStr) || $dateStr === '現在') {
                                    return $dateStr;
                                }
                                if (preg_match('/^(\d{4})-(\d{2})$/', $dateStr, $matches)) {
                                    return $matches[1].'年'.(int)$matches[2].'月';
                                }
                                return $dateStr;
                            };
                            $formattedStartDate = $formatDate($startDate);
                            $formattedEndDate = $formatDate($endDate);
                            $period = $formattedStartDate . "\n～\n" . $formattedEndDate;
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px; vertical-align: middle; text-align: center; white-space: pre-line;">{{ $period }}</td>
                            <td style="border: 1px solid #000; padding: 8px; vertical-align: top;">
                                <strong>{{ $career['company_name'] ?? '' }}</strong><br>
                                @if(!empty($career['business_content']))
                                    事業内容: {{ $career['business_content'] }}<br>
                                @endif
                                @if(!empty($career['employee_count']))
                                    従業員数: {{ $career['employee_count'] }}<br>
                                @endif
                                @if(!empty($career['capital']))
                                    資本金: {{ $career['capital'] }}<br>
                                @endif
                                <br>
                                <div style="white-space: pre-wrap;">{{ $career['job_description'] ?? '' }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <tr>
                    <td style="font-weight: bold; padding-top: 20px; padding-bottom: 10px;">■自己PR</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 20px; white-space: pre-wrap;">{{ $data['self_pr'] ?? '' }}</td>
                </tr>
            </table>
        </div>

        <!-- reCAPTCHA -->
        @if(config('recaptcha.site_key'))
        <div class="mt-8 flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
        </div>
        @endif

        <!-- ボタン -->
        <div class="mt-6 flex gap-4 justify-between items-center relative">
            <button onclick="backToForm()" 
                class="px-6 py-3 bg-gray-300 text-gray-700 rounded font-semibold hover:bg-gray-400 transition">
                戻る / फिर्ता जानुहोस्
            </button>
            <button type="button" onclick="downloadPdf()" 
                class="px-6 py-3 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700 transition md:absolute md:left-1/2 md:transform md:-translate-x-1/2">
                PDF生成 / PDF जनरेट गर्नुहोस्
            </button>
            <button type="button" onclick="saveCareerHistory()" 
                class="px-6 py-3 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition md:ml-auto">
                保存 / बचत गर्नुहोस्
            </button>
        </div>
        
        <script>
        // 職務経歴書データをJavaScript変数に埋め込む
        const careerHistoryDataForPdf = @json($data);
        
        function downloadPdf() {
            const recaptchaSiteKey = @json(config('recaptcha.site_key'));
            const recaptchaResponse = document.querySelector('[name="g-recaptcha-response"]')?.value || '';
            
            if (recaptchaSiteKey && !recaptchaResponse) {
                alert('セキュリティチェックを確認してください。 / सुरक्षा जाँच पुष्टि गर्नुहोस्।');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value || 
                             '{{ csrf_token() }}';
            
            // フォームを作成してPOSTで送信
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("career-history.download") }}';
            
            // CSRFトークンを追加
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // reCAPTCHAトークンを追加
            if (recaptchaResponse) {
                const recaptchaInput = document.createElement('input');
                recaptchaInput.type = 'hidden';
                recaptchaInput.name = 'g-recaptcha-response';
                recaptchaInput.value = recaptchaResponse;
                form.appendChild(recaptchaInput);
            }
            
            // 職務経歴書データをJSONで送信
            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'career_history_data';
            dataInput.value = JSON.stringify(careerHistoryDataForPdf);
            form.appendChild(dataInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
        
        function saveCareerHistory() {
            const button = event.target;
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '処理中... / प्रक्रिया गर्दै...';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value || 
                             '{{ csrf_token() }}';
            
            fetch('{{ route("career-history.save") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.redirect) {
                        // 未ログインの場合、会員登録ページに遷移
                        window.location.href = data.redirect;
                    } else {
                        // ログイン済みの場合、保存成功メッセージ
                        alert('職務経歴書を保存しました / कार्य अनुभव बचत गरियो');
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                } else {
                    throw new Error(data.message || '保存に失敗しました');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('保存に失敗しました: ' + error.message);
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }
        
        function backToForm() {
            window.location.href = '{{ route("career-history.index") }}';
        }
        </script>
        @if(config('recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
    @else
        <p class="text-center text-gray-500">データが見つかりませんでした। / डाटा फेला परेन।</p>
    @endif
</div>

