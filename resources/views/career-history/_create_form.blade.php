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
<style>
    /* 全画面サイズで適用 - 入力フィールドがはみ出さないように */
    .career-row input,
    .career-row textarea,
    .career-row select {
        box-sizing: border-box !important;
        max-width: 100% !important;
    }
    
    /* 職務要約と自己PRのテキストエリアも含める */
    textarea[name="job_summary"],
    textarea[name="self_pr"] {
        box-sizing: border-box !important;
        max-width: 100% !important;
        width: 100% !important;
    }
    
    .career-row .date-input-wrapper {
        box-sizing: border-box !important;
        max-width: 100% !important;
    }
    
    .career-row .date-input-wrapper input[type="month"] {
        box-sizing: border-box !important;
        max-width: 100% !important;
    }
    
    /* スマホ表示時のみ適用（768px以下） */
    @media screen and (max-width: 768px) {
        /* フォームコンテナとフォームのオーバーフロー設定 */
        .career-history-form-container,
        #career-history-form {
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }
        
        /* テキストエリアの表示確保 */
        textarea[name="job_summary"],
        textarea[name="self_pr"],
        textarea[name="job_description[]"] {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        
        /* 期間フィールドの日付入力を全幅に */
        .career-row .date-input-wrapper {
            width: 100% !important;
        }
        
        .career-row .date-input-wrapper input[type="month"] {
            width: 100% !important;
        }
        
        /* iOS Safari/Chromeで日付入力フィールドのテキストを表示 */
        input[type="month"] {
            -webkit-text-fill-color: #111827 !important;
            color: #111827 !important;
            line-height: 24px !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }
        
        /* カレンダーアイコンを確実に表示（全フィールドで統一、右寄せ・縦中央） */
        input[type="month"]::-webkit-calendar-picker-indicator {
            display: block !important;
            opacity: 1 !important;
            cursor: pointer !important;
            visibility: visible !important;
            width: 20px !important;
            height: 20px !important;
        }
    }
    
    /* PC表示時（769px以上） */
    @media screen and (min-width: 769px) {
        .career-row .date-input-wrapper input[type="month"] {
            min-width: 150px;
        }
    }
</style>
<script>
    // 職務経歴追加/削除
    function addCareerField() {
        let container = document.getElementById('careers-container');
        let count = container.children.length;
        if (count >= 10) return;
        let clone = container.children[0].cloneNode(true);
        Array.from(clone.querySelectorAll('input, textarea, select')).forEach(input => {
            if (input.type === 'month' || input.tagName === 'SELECT') {
                input.value = '';
            } else if (input.tagName === 'TEXTAREA') {
                input.value = '';
            } else if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        // チェックボックスをリセット
        let checkbox = clone.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = false;
            toggleEndDate(checkbox);
        }
        container.appendChild(clone);
        toggleCareerAddButton();
        toggleRemoveButtons();
    }
    
    function removeCareerField(btn) {
        let container = document.getElementById('careers-container');
        if (container.children.length > 1) {
            btn.closest('.career-row').remove();
            toggleCareerAddButton();
            toggleRemoveButtons();
        }
    }
    
    function toggleCareerAddButton() {
        let container = document.getElementById('careers-container');
        let btn = document.getElementById('add-career-btn');
        if (btn) btn.disabled = container.children.length >= 10;
    }
    
    // 削除ボタンの表示/非表示を制御（1件のみのときは非表示、2件以上あるときは全て表示）
    function toggleRemoveButtons() {
        let container = document.getElementById('careers-container');
        if (!container) return;
        let rows = container.querySelectorAll('.career-row');
        let removeBtns = container.querySelectorAll('button[onclick="removeCareerField(this)"]');
        // 2件以上ある場合は全て表示、1件のみの場合は全て非表示
        removeBtns.forEach(btn => {
            btn.style.display = (rows.length > 1) ? 'block' : 'none';
        });
    }
    
    // 現在チェックボックスの処理
    function toggleEndDate(checkbox) {
        let row = checkbox.closest('.career-row');
        let endDateInput = row.querySelector('input[name="end_date[]"]');
        if (checkbox.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    }
    
    // フォーム送信前のバリデーション
    function validateCareerHistoryForm(event) {
        let form = document.getElementById('career-history-form');
        let errors = [];
        
        // 名前チェック
        if (!form['last_name_roman'].value.trim() || !form['first_name_roman'].value.trim()) {
            errors.push('氏名（ローマ字）の姓と名は必須です।');
        }
        
        // 職務経歴チェック
        document.querySelectorAll('.career-row').forEach((row, idx) => {
            let companyName = row.querySelector('input[name="company_name[]"]').value.trim();
            let startDate = row.querySelector('input[name="start_date[]"]').value;
            let jobDescription = row.querySelector('textarea[name="job_description[]"]').value.trim();
            
            // 最初の行以外で全て空欄の場合はスキップ
            if (!companyName && !startDate && !jobDescription && idx > 0) return;
            
            if (!companyName) errors.push(`職務経歴${idx+1}：会社名を入力してください।`);
            if (!startDate) errors.push(`職務経歴${idx+1}：開始年月を選択してください।`);
            if (!jobDescription) errors.push(`職務経歴${idx+1}：職務内容を入力してください।`);
        });
        
        if (errors.length > 0) {
            event.preventDefault();
            let errDiv = document.getElementById('form-errors');
            errDiv.innerHTML = errors.map(e => `<div class="text-red-600 mb-2">${e}</div>`).join('');
            window.scrollTo(0, 0);
            return false;
        }
        
        return true;
    }
    
    // フォーム送信処理（確認画面へ）
    function submitCareerHistoryForm() {
        const form = document.getElementById('career-history-form');
        const formData = new FormData(form);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value || 
                         '{{ csrf_token() }}';
        
        // 確認画面に送信
        const formElement = document.createElement('form');
        formElement.method = 'POST';
        formElement.action = '{{ route("career-history.confirm") }}';
        
        // CSRFトークンを追加
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        formElement.appendChild(csrfInput);
        
        // フォームデータを追加
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                continue;
            }
            if (Array.isArray(value)) {
                value.forEach((v) => {
                    const arrayInput = document.createElement('input');
                    arrayInput.type = 'hidden';
                    arrayInput.name = key + '[]';
                    arrayInput.value = v;
                    formElement.appendChild(arrayInput);
                });
            } else {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                formElement.appendChild(input);
            }
        }
        
        document.body.appendChild(formElement);
        formElement.submit();
    }
    
    // PDFダウンロード
    function downloadPDF() {
        const form = document.getElementById('career-history-form');
        const formData = new FormData(form);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value || 
                         '{{ csrf_token() }}';
        
        fetch('{{ route("career-history.download") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('PDF生成に失敗しました');
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'career_history.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('PDF生成エラー: ' + error.message);
        });
    }
    
    // 既存データをフォームにセット
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($careerHistoryData) && $careerHistoryData)
            const careerHistoryData = @json($careerHistoryData);
            
            if (careerHistoryData.last_name_roman) {
                document.querySelector('input[name="last_name_roman"]').value = careerHistoryData.last_name_roman;
            }
            if (careerHistoryData.first_name_roman) {
                document.querySelector('input[name="first_name_roman"]').value = careerHistoryData.first_name_roman;
            }
            
            if (careerHistoryData.job_summary) {
                document.querySelector('textarea[name="job_summary"]').value = careerHistoryData.job_summary;
            }
            
            if (careerHistoryData.self_pr) {
                document.querySelector('textarea[name="self_pr"]').value = careerHistoryData.self_pr;
            }
            
            if (careerHistoryData.career_histories && careerHistoryData.career_histories.length > 0) {
                const careersContainer = document.getElementById('careers-container');
                while (careersContainer.children.length > 1) {
                    careersContainer.lastElementChild.remove();
                }
                
                careerHistoryData.career_histories.forEach((career, index) => {
                    if (index > 0) {
                        addCareerField();
                    }
                    const rows = careersContainer.querySelectorAll('.career-row');
                    const row = rows[index];
                    if (row) {
                        row.querySelector('input[name="company_name[]"]').value = career.company_name || '';
                        if (career.start_date) {
                            const date = new Date(career.start_date + '-01');
                            row.querySelector('input[name="start_date[]"]').value = 
                                date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
                        }
                        if (career.is_current) {
                            row.querySelector('input[type="checkbox"]').checked = true;
                            toggleEndDate(row.querySelector('input[type="checkbox"]'));
                        } else if (career.end_date && career.end_date !== '現在') {
                            const date = new Date(career.end_date + '-01');
                            row.querySelector('input[name="end_date[]"]').value = 
                                date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
                        }
                        row.querySelector('textarea[name="job_description[]"]').value = career.job_description || '';
                        row.querySelector('input[name="business_content[]"]').value = career.business_content || '';
                        row.querySelector('input[name="employee_count[]"]').value = career.employee_count || '';
                        row.querySelector('input[name="capital[]"]').value = career.capital || '';
                    }
                });
            }
        @endif
        
        toggleCareerAddButton();
        toggleRemoveButtons();
        
        // 定期的に削除ボタンの表示状態を更新（履歴書と同じ挙動）
        setInterval(() => {
            toggleRemoveButtons();
        }, 250);
    });
    
    // 連打防止フラグ
    let isGeneratingCareerInfo = false;
    let currentCareerRow = null; // 現在処理中の職務経歴エントリを保持
    
    // モーダルを開く
    function openCareerInfoModal(button) {
        if (isGeneratingCareerInfo) {
            return;
        }
        
        // ボタンが属する職務経歴エントリを取得
        const careerRow = button.closest('.career-row');
        if (!careerRow) {
            alert('エラー: 職務経歴エントリが見つかりません。');
            return;
        }
        
        // 現在の職務経歴エントリを保持
        currentCareerRow = careerRow;
        
        // 会社名を取得してモーダルの初期値にセット
        const companyNameInput = careerRow.querySelector('input[name="company_name[]"]');
        const companyName = companyNameInput ? companyNameInput.value.trim() : '';
        
        document.getElementById('career-modal-company-name').value = companyName;
        document.getElementById('career-modal-job-description').value = '';
        
        // モーダルを表示
        document.getElementById('career-info-modal').classList.remove('hidden');
    }
    
    // モーダルを閉じる
    function closeCareerInfoModal() {
        if (isGeneratingCareerInfo) {
            return;
        }
        document.getElementById('career-info-modal').classList.add('hidden');
        document.getElementById('career-info-generate-form').reset();
        currentCareerRow = null;
    }
    
    // 職務経歴情報をAI生成
    async function generateCareerInfo(event) {
        event.preventDefault();
        
        // 連打防止
        if (isGeneratingCareerInfo || !currentCareerRow) {
            return;
        }
        
        const companyName = document.getElementById('career-modal-company-name').value.trim();
        const jobDescription = document.getElementById('career-modal-job-description').value.trim();
        
        if (!companyName) {
            alert('会社名を入力してください。');
            document.getElementById('career-modal-company-name').focus();
            return;
        }
        
        isGeneratingCareerInfo = true;
        const submitBtn = document.getElementById('career-info-generate-submit-btn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = '生成中... / निर्माण गर्दै...';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value || 
                         '{{ csrf_token() }}';
        
        try {
            const response = await fetch('{{ route("career-history.generate-career-info") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    company_name: companyName,
                    job_description: jobDescription,
                }),
            });
            
            const responseText = await response.text();
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                throw new Error('サーバーからの応答の解析に失敗しました。');
            }
            
            if (!response.ok) {
                throw new Error(data.message || `情報の生成に失敗しました。 (HTTP ${response.status})`);
            }
            
            if (data.success && data.data) {
                // 生成された情報を各フィールドにセット
                if (data.data.company_name) {
                    const companyNameInput = currentCareerRow.querySelector('input[name="company_name[]"]');
                    if (companyNameInput) {
                        companyNameInput.value = data.data.company_name;
                    }
                }
                
                if (data.data.business_content) {
                    const businessContentInput = currentCareerRow.querySelector('input[name="business_content[]"]');
                    if (businessContentInput) {
                        businessContentInput.value = data.data.business_content;
                    }
                }
                
                if (data.data.employee_count) {
                    const employeeCountInput = currentCareerRow.querySelector('input[name="employee_count[]"]');
                    if (employeeCountInput) {
                        employeeCountInput.value = data.data.employee_count;
                    }
                }
                
                if (data.data.capital) {
                    const capitalInput = currentCareerRow.querySelector('input[name="capital[]"]');
                    if (capitalInput) {
                        capitalInput.value = data.data.capital;
                    }
                }
                
                if (data.data.job_description) {
                    const jobDescriptionTextarea = currentCareerRow.querySelector('textarea[name="job_description[]"]');
                    if (jobDescriptionTextarea) {
                        jobDescriptionTextarea.value = data.data.job_description;
                    }
                }
                
                // モーダルを閉じる
                closeCareerInfoModal();
            } else {
                throw new Error(data.message || '情報の生成に失敗しました。');
            }
        } catch (error) {
            console.error('エラー詳細:', error);
            alert('エラー: ' + error.message);
        } finally {
            isGeneratingCareerInfo = false;
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }
    
    // ログインが必要な場合のメッセージ表示
    function showLoginRequiredMessage() {
        alert('この機能は会員限定です。ログインしてください。 / यो सुविधा सदस्यहरूको लागि मात्र छ। कृपया लगइन गर्नुहोस्।');
    }
    
    // モーダル外をクリックで閉じる
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('career-info-modal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this && !isGeneratingCareerInfo) {
                    closeCareerInfoModal();
                }
            });
        }
    });
</script>

<div class="w-full max-w-2xl mx-auto bg-white rounded-lg shadow-md p-4 sm:p-6 career-history-form-container" style="box-sizing: border-box; overflow-x: hidden; overflow-y: visible;">
    <h2 class="text-2xl font-bold mb-4 text-center">職務経歴書作成フォーム<span class="block text-base text-gray-500 mt-1">कार्य अनुभव फारम</span></h2>
    
    <!-- 説明文 -->
    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <div class="text-sm text-gray-700 leading-relaxed">
            <p class="font-medium">入力いただいた情報で簡単にPDFの職務経歴書が作成できます。</p>
            <p class="font-medium mt-2">会員登録をしていただくと、入力情報の保存と、AI生成機能をご利用いただけます。</p>
            <p class="text-gray-600 mt-2">तपाईंले प्रविष्ट गरेको जानकारीबाट सजिलैसँग PDF को कार्य अनुभव बनाउन सक्नुहुन्छ।</p>
            <p class="text-gray-600 mt-1">तपाईंले खाता खोलेमा, तपाईंको प्रविष्ट गरेको जानकारी सुरक्षित हुनेछ र AI जेनरेट फिचर प्रयोग गर्न सक्नुहुनेछ।</p>
        </div>
    </div>
    
    <div id="form-errors" class="mb-4"></div>
    <form id="career-history-form" class="space-y-4" onsubmit="event.preventDefault(); if (validateCareerHistoryForm(event)) { submitCareerHistoryForm(); }" style="box-sizing: border-box; overflow-x: hidden; width: 100%;">
        @csrf
        
        <!-- 氏名（ローマ字） -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">氏名（ローマ字） / नाम (Roman Alphabet)<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">पासपोर्ट वा रेजिडेन्स कार्डमा लेखिएको रोमन अक्षरमा नाम लेख्नुहोस्। उदाहरण: TANAKA TARO</p>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-sm text-gray-600 mb-1">姓 / थर</label>
                    <input type="text" name="last_name_roman" maxlength="25" inputmode="latin-name" autocomplete="family-name"
                        class="w-3/4 border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $careerHistoryData['last_name_roman'] ?? old('last_name_roman', '') }}" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm text-gray-600 mb-1">名 / नाम</label>
                    <input type="text" name="first_name_roman" maxlength="25" inputmode="latin-name" autocomplete="given-name"
                        class="w-3/4 border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $careerHistoryData['first_name_roman'] ?? old('first_name_roman', '') }}" required>
                </div>
            </div>
        </div>
        
        <!-- 職務経歴 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">職務経歴 / कार्य अनुभव<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">कम्पनीको नाम, कामको अवधि, र कामको विवरण लेख्नुहोस्। धेरै काम भएको खण्डमा "+" बटन थिचेर थप्नुहोस्।</p>
            <div id="careers-container">
                <div class="career-row pb-4 mb-4 border-b border-gray-200">
                    <div class="space-y-3">
                        <!-- 会社名 -->
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">会社名 / कम्पनीको नाम<span class="text-red-500">*</span></label>
                            <div class="flex gap-2 items-start" style="box-sizing: border-box; width: 100%; max-width: 100%;">
                                <input type="text" name="company_name[]" placeholder="कम्पनीको नाम (उदाहरण: 〇〇 कम्पनी)" maxlength="100"
                                    class="border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                                    style="box-sizing: border-box; flex: 1; min-width: 0; max-width: 100%;" required>
                                <button type="button" onclick="removeCareerField(this)" class="text-red-500 px-2 py-2 block flex-shrink: 0" style="display: none;">
                                    &#8722;
                                </button>
                            </div>
                        </div>
                        
                        <!-- 期間と現在チェック -->
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">期間 / अवधि<span class="text-red-500">*</span></label>
                            <div class="flex flex-col sm:flex-row gap-2 items-center flex-wrap" style="box-sizing: border-box; width: 100%; max-width: 100%; min-width: 0;">
                                <div class="date-input-wrapper w-full sm:w-auto" style="position: relative; display: block; box-sizing: border-box; min-width: 0; flex-shrink: 1;">
                                    <input type="month" name="start_date[]" 
                                        class="border rounded px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring-blue-400 focus:ring-2 date-input-field" 
                                        style="min-height: 40px; padding: 8px 12px; font-size: 16px; box-sizing: border-box; background-color: #ffffff; border: 1px solid #d1d5db; color: #111827; cursor: pointer; display: block; visibility: visible; opacity: 1; max-width: 100%;" required>
                                    <span class="date-placeholder" style="display: none; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; font-size: 16px; line-height: 1;">YYYY-MM</span>
                                </div>
                                <span class="text-gray-600 text-lg flex-shrink: 0" style="white-space: nowrap;">〜</span>
                                <div class="date-input-wrapper w-full sm:w-auto" style="position: relative; display: block; box-sizing: border-box; min-width: 0; flex-shrink: 1;">
                                    <input type="month" name="end_date[]" 
                                        class="border rounded px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring-blue-400 focus:ring-2 date-input-field" 
                                        style="min-height: 40px; padding: 8px 12px; font-size: 16px; box-sizing: border-box; background-color: #ffffff; border: 1px solid #d1d5db; color: #111827; cursor: pointer; display: block; visibility: visible; opacity: 1; max-width: 100%;">
                                    <span class="date-placeholder" style="display: none; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; font-size: 16px; line-height: 1;">YYYY-MM</span>
                                </div>
                                <label class="flex items-center flex-shrink: 0;">
                                    <input type="checkbox" name="is_current[]" value="1" onchange="toggleEndDate(this)" class="mr-2">
                                    <span class="text-sm whitespace-nowrap">現在 / हाल</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- 事業内容 -->
                        <div class="mb-2">
                            <!-- スマホ表示時: ボタンをラベルの上に表示 -->
                            <div class="block sm:hidden mb-2">
                                @auth
                                    <button type="button" onclick="openCareerInfoModal(this)" 
                                        class="w-full px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition text-sm">
                                        AI生成 / AI निर्माण
                                    </button>
                                @else
                                    <button type="button" onclick="showLoginRequiredMessage()"
                                        class="w-full px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed transition text-sm" disabled>
                                        AI生成 / AI निर्माण
                                    </button>
                                @endauth
                            </div>
                            <label class="block text-xs text-gray-600 mb-1">事業内容 / व्यवसाय सामग्री</label>
                            <!-- PC表示時: ボタンを右隣に表示 -->
                            <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-end">
                                <div class="flex-1 w-full sm:w-auto" style="min-width: 0; box-sizing: border-box;">
                                    <input type="text" name="business_content[]" placeholder="事業内容 / व्यवसाय सामग्री" maxlength="200"
                                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" style="box-sizing: border-box; max-width: 100%;">
                                </div>
                                <div class="hidden sm:block">
                                    @auth
                                        <button type="button" onclick="openCareerInfoModal(this)" 
                                            class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition whitespace-nowrap flex-shrink-0 text-sm">
                                            AI生成 / AI निर्माण
                                        </button>
                                    @else
                                        <button type="button" onclick="showLoginRequiredMessage()"
                                            class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed transition whitespace-nowrap flex-shrink-0 text-sm" disabled>
                                            AI生成 / AI निर्माण
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        
                        <!-- 従業員数と資本金 -->
                        <div class="flex flex-col sm:flex-row gap-2 items-start mb-2" style="box-sizing: border-box; width: 100%; max-width: 100%; min-width: 0;">
                            <div class="flex-1" style="min-width: 0; box-sizing: border-box;">
                                <label class="block text-xs text-gray-600 mb-1">従業員数 / कर्मचारी संख्या</label>
                                <input type="text" name="employee_count[]" placeholder="例: 1000人" maxlength="50"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" style="box-sizing: border-box; max-width: 100%;">
                            </div>
                            <div class="flex-1" style="min-width: 0; box-sizing: border-box;">
                                <label class="block text-xs text-gray-600 mb-1">資本金 / पूँजी</label>
                                <input type="text" name="capital[]" placeholder="例: 1億円" maxlength="50"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" style="box-sizing: border-box; max-width: 100%;">
                            </div>
                        </div>
                        
                        <!-- 職務内容 -->
                        <div class="mb-2">
                            <label class="block text-xs text-gray-600 mb-1">職務内容 / कामको विवरण<span class="text-red-500">*</span></label>
                            <textarea name="job_description[]" rows="4" placeholder="職務内容 / कामको विवरण" maxlength="1000"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2 resize-none" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-career-btn" onclick="addCareerField()"
                class="mt-1 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                ＋ 職務経歴を追加 / कार्य अनुभव थप्नुहोस्
            </button>
        </div>
        
        <!-- 職務要約 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">職務要約 / कार्य सारांश</label>
            <p class="text-xs text-gray-500 mb-2">आफ्नो कामको सारांश लेख्नुहोस्। वैकल्पिक खण्ड हो।</p>
            <textarea name="job_summary" rows="5"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"
                style="box-sizing: border-box; max-width: 100%; width: 100%;"
                placeholder="例: 3年間のプログラマー経験があり、Webアプリケーション開発を担当していました。">{{ $careerHistoryData['job_summary'] ?? old('job_summary', '') }}</textarea>
        </div>
        
        <!-- 自己PR -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">自己PR / आफ्नो PR</label>
            <p class="text-xs text-gray-500 mb-2">आफ्नो बारेमा लेख्नुहोस्। वैकल्पिक खण्ड हो।</p>
            <textarea name="self_pr" rows="5"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"
                style="box-sizing: border-box; max-width: 100%; width: 100%;"
                placeholder="例: チームワークを大切にし、常に前向きに取り組むことを心がけています。">{{ $careerHistoryData['self_pr'] ?? old('self_pr', '') }}</textarea>
        </div>
        
        <div class="mt-6 flex justify-center gap-4">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700 transition">
                内容確認 / विवरण जाँच गर्नुहोस्
            </button>
        </div>
    </form>
</div>

<!-- AI生成モーダル -->
<div id="career-info-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-start justify-center pt-4 pb-4 sm:pt-6 sm:pb-6 p-3 sm:p-4" style="box-sizing: border-box; overflow-y: auto;">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full overflow-hidden flex flex-col" style="box-sizing: border-box; margin: auto 0; max-height: calc(100vh - 120px);">
        <div class="flex-shrink-0 p-1.5 sm:p-2 border-b border-gray-200" style="box-sizing: border-box;">
            <div class="flex justify-between items-center mb-0.5">
                <h3 class="text-sm sm:text-base font-bold">AI生成 / AI निर्माण</h3>
                <button type="button" onclick="closeCareerInfoModal()" class="text-gray-500 hover:text-gray-700 text-xl flex-shrink-0 w-6 h-6 flex items-center justify-center" style="line-height: 1;">&times;</button>
            </div>
            <div class="mb-0.5 p-1 bg-blue-50 rounded text-xs text-gray-700" style="line-height: 1.2;">
                <p class="mb-0" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; margin-bottom: 2px;"><strong>【प्रयोग विधि】</strong></p>
                <p class="mb-0" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; margin-bottom: 2px;">१. कम्पनीको नाम प्रविष्ट गर्नुहोस् (आवश्यक)</p>
                <p class="mb-0" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; margin-bottom: 2px;">२. कामको विवरण सरल रूपमा लेख्नुहोस् (वैकल्पिक, कुनै भाषा मात्र)</p>
                <p class="mb-0" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">३. "AI निर्माण" बटन थिच्नुहोस् भने, व्यवसाय सामग्री, कर्मचारी संख्या, पूंजी, र कामको विवरण स्वचालित रूपमा निर्माण हुनेछ</p>
            </div>
            <p class="text-xs text-gray-500 mb-0" style="line-height: 1.1;">
                当サービスは記載内容に対し一切の責任を負いません。 / यस सेवाले सामग्रीको लागि कुनै जिम्मेवारी लिँदैन।
            </p>
        </div>
        
        <div class="flex-1 overflow-y-auto p-1.5 sm:p-2" style="box-sizing: border-box;">
            <form id="career-info-generate-form" onsubmit="generateCareerInfo(event)" class="space-y-1.5">
                <div>
                    <label class="block font-medium mb-0.5 text-xs" style="box-sizing: border-box;">
                        会社名 / कम्पनीको नाम
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="career-modal-company-name" name="company_name" required
                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-blue-400 focus:ring-2 text-sm"
                        style="box-sizing: border-box;"
                        placeholder="例: 株式会社〇〇">
                </div>
                
                <div>
                    <label class="block font-medium mb-0.5 text-xs" style="box-sizing: border-box;">
                        職務内容を簡単に書いてください。言語は問いません。 / कामको विवरण सरल रूपमा लेख्नुहोस् (कुनै भाषा मात्र)
                    </label>
                    <textarea id="career-modal-job-description" name="job_description" rows="2"
                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-blue-400 focus:ring-2 resize-none text-sm"
                        style="box-sizing: border-box;"
                        placeholder="例: プログラミング、データ入力、顧客対応など"></textarea>
                </div>
            </form>
        </div>
        
        <div class="flex-shrink-0 p-1.5 sm:p-2 border-t border-gray-200 bg-gray-50" style="box-sizing: border-box;">
            <div class="flex flex-col sm:flex-row justify-end gap-2">
                <button type="button" onclick="closeCareerInfoModal()"
                    class="px-3 py-1 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition w-full sm:w-auto text-sm"
                    style="box-sizing: border-box;">
                    キャンセル
                </button>
                <button type="submit" id="career-info-generate-submit-btn" form="career-info-generate-form"
                    class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 transition w-full sm:w-auto text-sm"
                    style="box-sizing: border-box;">
                    AI生成 / AI निर्माण
                </button>
            </div>
        </div>
    </div>
</div>

