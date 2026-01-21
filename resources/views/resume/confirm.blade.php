<script>
    // Tailwind CSSのプリフライト（リセット）を無効化して、ヘッダーに影響しないようにする
    // CDN読み込み前に設定する必要があるため、window.tailwindConfigを使用
    if (typeof window.tailwindConfig === 'undefined') {
        window.tailwindConfig = {
            corePlugins: {
                preflight: false, // プリフライトを無効化
            }
        };
    }
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    // CDN読み込み後に再度設定を適用
    if (typeof tailwind !== 'undefined') {
        tailwind.config = window.tailwindConfig;
    }
</script>
<div class="w-full max-w-2xl mx-auto bg-white rounded-lg shadow-md p-4 sm:p-6" style="box-sizing: border-box; overflow-x: hidden;">
    <h2 class="text-2xl font-bold mb-4 text-center">内容確認 / विवरण जाँच गर्नुहोस्</h2>
    
    @php
        $data = $resumeData ?? session('resume_data');
    @endphp
    
    @if($data)
        
        <div class="space-y-6">
            <!-- 基本情報 -->
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">基本情報 / आधारभूत जानकारी</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">氏名（ローマ字） / नाम (Roman):</span>
                        <p class="font-medium">{{ ($data['last_name_roman'] ?? '') . ' ' . ($data['first_name_roman'] ?? '') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">氏名（ひらがな） / नाम (ひらがな):</span>
                        <p class="font-medium">{{ ($data['last_name_kana'] ?? '') . ' ' . ($data['first_name_kana'] ?? '') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">生年月日 / जन्म मिति:</span>
                        <p class="font-medium">{{ $data['birthday'] ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">性別 / लिङ्ग:</span>
                        <p class="font-medium">{{ $data['gender'] ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">電話番号 / फोन नम्बर:</span>
                        <p class="font-medium">{{ $data['phone'] ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">メールアドレス / इमेल ठेगाना:</span>
                        <p class="font-medium">{{ $data['email'] ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600">郵便番号 / हुलाक नम्बर:</span>
                        <p class="font-medium">{{ $data['postal_code'] ?? '' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-gray-600">住所 / ठेगाना:</span>
                        <p class="font-medium">{{ $data['address'] ?? '' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-gray-600">住所ふりがな / ठेगाना (ひらがな):</span>
                        <p class="font-medium">{{ $data['address_kana'] ?? '' }}</p>
                    </div>
                </div>
            </div>

            <!-- 学歴 -->
            @if(!empty($data['education']))
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">学歴 / शैक्षिक विवरण</h3>
                <div class="space-y-3">
                    @foreach($data['education'] as $edu)
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="font-medium">{{ $edu['school_name'] ?? '' }}</p>
                            @if(!empty($edu['event_type']) && !empty($edu['date']))
                                @php
                                    $date = \Carbon\Carbon::parse($edu['date']);
                                    $year = $date->year;
                                    $month = $date->month;
                                @endphp
                                <p class="text-sm text-gray-600">{{ $year }}年{{ $month }}月 {{ $edu['event_type'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 職歴 -->
            @if(!empty($data['work_history']))
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">職歴 / रोजगार विवरण</h3>
                <div class="space-y-3">
                    @foreach($data['work_history'] as $work)
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="font-medium">{{ $work['company_name'] ?? '' }}</p>
                            @if(!empty($work['event_type']) && !empty($work['date']))
                                @php
                                    $date = \Carbon\Carbon::parse($work['date']);
                                    $year = $date->year;
                                    $month = $date->month;
                                @endphp
                                <p class="text-sm text-gray-600">{{ $year }}年{{ $month }}月 {{ $work['event_type'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 免許・資格 -->
            @if(!empty($data['licenses']))
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">免許・資格 / अन्य योग्यता</h3>
                <div class="space-y-2">
                    @foreach($data['licenses'] as $license)
                        @if(!empty($license['name']) && !empty($license['date']) && !empty($license['event_type']))
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="font-medium">{{ $license['name'] }}</p>
                                @php
                                    $date = \Carbon\Carbon::parse($license['date']);
                                    $year = $date->year;
                                    $month = $date->month;
                                    $eventType = $license['event_type'] ?? '取得';
                                @endphp
                                <p class="text-sm text-gray-600">{{ $year }}年{{ $month }}月 {{ $eventType }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 志望動機・特技・アピールポイント -->
            @if(!empty($data['appeal_points']))
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">志望動機・特技・アピールポイント / आफ्नो तयारी, रुचि, विशेषता</h3>
                <p class="whitespace-pre-wrap">{{ $data['appeal_points'] }}</p>
            </div>
            @endif

            <!-- 本人希望欄 -->
            @if(!empty($data['self_request']))
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg mb-3">本人希望欄 / आफ्नो चाहना</h3>
                <p class="whitespace-pre-wrap">{{ $data['self_request'] }}</p>
            </div>
            @endif
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
            <button type="button" onclick="saveResume()" 
                class="px-6 py-3 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition md:ml-auto">
                保存 / बचत गर्नुहोस्
            </button>
        </div>
        
        <script>
        // 履歴書データをJavaScript変数に埋め込む
        const resumeDataForPdf = @json($data);
        
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
            form.action = '{{ route("resume.download") }}';
            
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
            
            // 履歴書データをJSONで送信
            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'resume_data';
            dataInput.value = JSON.stringify(resumeDataForPdf);
            form.appendChild(dataInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
        
        function saveResume() {
            const button = event.target;
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '処理中... / प्रक्रिया गर्दै...';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value || 
                             '{{ csrf_token() }}';
            
            fetch('{{ route("resume.save") }}', {
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
                        alert('履歴書を保存しました / बायोडाटा बचत गरियो');
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
        </script>
        @if(config('recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
    @else
        <p class="text-center text-gray-500">データが見つかりませんでした। / डाटा फेला परेन।</p>
    @endif
</div>

