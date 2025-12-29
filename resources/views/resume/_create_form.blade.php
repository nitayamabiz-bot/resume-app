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
<script>
    // 学歴追加/削除
    function addSchoolField() {
        let container = document.getElementById('schools-container');
        let count = container.children.length;
        if (count >= 6) return;
        let clone = container.children[0].cloneNode(true);
        Array.from(clone.querySelectorAll('input, select')).forEach(input => {
            if (input.type === 'month' || input.tagName === 'SELECT') {
                input.value = '';
            } else {
                input.value = '';
            }
        });
        container.appendChild(clone);
        toggleSchoolAddButton();
    }
    function removeSchoolField(btn) {
        let container = document.getElementById('schools-container');
        if (container.children.length > 1) {
            btn.closest('.school-row').remove();
            toggleSchoolAddButton();
        }
    }
    function toggleSchoolAddButton() {
        let container = document.getElementById('schools-container');
        let btn = document.getElementById('add-school-btn');
        if (btn) btn.disabled = container.children.length >= 6;
    }
    // 職歴追加/削除
    function addJobField() {
        let container = document.getElementById('jobs-container');
        let count = container.children.length;
        if (count >= 6) return;
        let clone = container.children[0].cloneNode(true);
        Array.from(clone.querySelectorAll('input,textarea,select')).forEach(input => {
            if (input.type === 'month' || input.tagName === 'SELECT') {
                input.value = '';
            } else {
                input.value = '';
            }
        });
        container.appendChild(clone);
        toggleJobAddButton();
    }
    function removeJobField(btn) {
        let container = document.getElementById('jobs-container');
        if (container.children.length > 1) {
            btn.closest('.job-row').remove();
            toggleJobAddButton();
        }
    }
    function toggleJobAddButton() {
        let container = document.getElementById('jobs-container');
        let btn = document.getElementById('add-job-btn');
        if (btn) btn.disabled = container.children.length >= 6;
    }

    // 入力チェック 
    function validateForm(event) {
        event.preventDefault();
        let form = document.getElementById('resume-form');
        let errors = [];

        // 必須チェック
        if (!form['first_name_roman'].value.trim() || !form['last_name_roman'].value.trim()) errors.push('氏名（ローマ字）の姓と名は必須です।');
        if (!form['first_name_kana'].value.trim() || !form['last_name_kana'].value.trim()) errors.push('氏名（ひらがな）の姓と名は必須です।');
        if (!form['birthday'].value) errors.push('生年月日を選択してください।');
        if (!form['gender'].value) errors.push('性別を選択してください।');
        // 電話番号: 必須, 数値のみ, 10〜11ケタ
        let phone = form['phone'].value.trim();
        if (!phone) {
            errors.push('電話番号は必須です।');
        } else if (!/^\d{10,11}$/.test(phone)) {
            errors.push('電話番号は10〜11桁の数字のみで入力してください（ハイフンなし）。');
        }
        // 住所
        if (!form['address'].value.trim()) {
            errors.push('住所は必須です।');
        }
        // 住所ふりがな
        if (!form['address_kana'].value.trim()) {
            errors.push('住所ふりがな（ひらがな）は必須です।');
        }
        // 郵便番号: 必須, 数値のみ, 7桁
        let postal = form['postal_code'].value.trim();
        if (!postal) {
            errors.push('郵便番号は必須です।');
        } else if (!/^\d{7}$/.test(postal)) {
            errors.push('郵便番号は7桁の数字で入力してください（ハイフンなし）。');
        }
        // 学歴チェック
        document.querySelectorAll('.school-row').forEach((row, idx) => {
            let school = row.querySelector('input[name="school_name[]"]').value.trim();
            let eventType = row.querySelector('select[name="school_event_type[]"]').value;
            let date = row.querySelector('input[name="school_date[]"]').value;
            if (!school && !eventType && !date && idx > 0) return; // 最初以外空欄許可
            if (!school) errors.push(`学歴${idx+1}：学校名を入力してください।`);
            if (!eventType) errors.push(`学歴${idx+1}：入学または卒業を選択してください।`);
            if (!date) errors.push(`学歴${idx+1}：年月を選択してください।`);
        });
        // 職歴チェック
        document.querySelectorAll('.job-row').forEach((row, idx) => {
            let company = row.querySelector('input[name="company_name[]"]').value.trim();
            let eventType = row.querySelector('select[name="job_event_type[]"]').value;
            let date = row.querySelector('input[name="job_date[]"]').value;
            let detail = row.querySelector('textarea[name="job_detail[]"]').value.trim();
            if (!company && !eventType && !date && !detail && idx > 0) return; // 最初以外空欄許可
            if (!company) errors.push(`職歴${idx+1}：会社名を入力してください।`);
            if (!eventType) errors.push(`職歴${idx+1}：入社または退職を選択してください।`);
            if (!date) errors.push(`職歴${idx+1}：年月を選択してください।`);
            if (!detail) errors.push(`職歴${idx+1}：業務内容を入力してください।`);
        });

        // 免許・資格 必須ではないが、取得年月あれば名称も
        document.querySelectorAll('.license-row').forEach((row, idx) => {
            let name = row.querySelector('input[name="license_name[]"]').value.trim();
            let date = row.querySelector('input[name="license_date[]"]').value.trim();
            if (date && !name) errors.push(`免許・資格${idx+1}：名称を入力してください。`);
        });

        if (errors.length > 0) {
            let errDiv = document.getElementById('form-errors');
            errDiv.innerHTML = errors.map(e => `<div class="text-red-600 mb-2">${e}</div>`).join('');
            window.scrollTo(0,0);
        } else {
            // エラーがない場合、データを正規化してセッションに保存
            normalizeFormData(form);
            submitToConfirm();
        }
    }
    
    // 内容確認画面に遷移
    function submitToConfirm() {
        const form = document.getElementById('resume-form');
        const formData = new FormData(form);
        
        // フォームデータをセッションストレージに保存（戻るボタン用）
        const formObject = {};
        formData.forEach((value, key) => {
            if (formObject[key]) {
                if (Array.isArray(formObject[key])) {
                    formObject[key].push(value);
                } else {
                    formObject[key] = [formObject[key], value];
                }
            } else {
                formObject[key] = value;
            }
        });
        sessionStorage.setItem('resumeFormData', JSON.stringify(formObject));
        
        // サーバーに送信してセッションに保存
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value || 
                         '{{ csrf_token() }}';
        
        fetch('{{ route("resume.confirm") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error('Server error: ' + text);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // 内容確認画面を表示
                if (typeof showConfirm === 'function') {
                    showConfirm();
                } else {
                    window.location.href = '{{ route("resume.index") }}?showConfirm=1';
                }
            } else {
                alert('エラーが発生しました: ' + (data.message || '不明なエラー'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('エラーが発生しました。ページをリロードして再度お試しください。');
        });
    }
    
    // 免許欄動的追加
    function addLicenseField() {
        let container = document.getElementById('licenses-container');
        let count = container.children.length;
        if (count >= 6) return;
        let clone = container.children[0].cloneNode(true);
        Array.from(clone.querySelectorAll('input')).forEach(input => input.value = '');
        container.appendChild(clone);
        toggleLicenseAddButton();
    }
    function removeLicenseField(btn) {
        let container = document.getElementById('licenses-container');
        if (container.children.length > 1) {
            btn.closest('.license-row').remove();
            toggleLicenseAddButton();
        }
    }
    function toggleLicenseAddButton() {
        let container = document.getElementById('licenses-container');
        let btn = document.getElementById('add-license-btn');
        if (btn) btn.disabled = container.children.length >= 6;
    }

    // 全角数字を半角に変換
    function toHalfWidth(str) {
        return str.replace(/[０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
        });
    }

    // 電話番号・郵便番号の自動変換（全角→半角、ハイフン削除）
    function normalizeNumeric(input) {
        let value = input.value;
        value = toHalfWidth(value); // 全角→半角
        value = value.replace(/[^\d]/g, ''); // 数字以外を削除
        input.value = value;
        
        // 郵便番号の場合、住所を自動入力
        if (input.name === 'postal_code' && value.length === 7) {
            fetchAddressFromPostalCode(value);
        }
    }
    
    // 半角カタカナを全角カタカナに変換
    function toFullWidthKatakana(str) {
        // 半角カタカナの変換テーブル（主要な文字）
        const halfToFullMap = {
            '\uFF66': '\u30F2', // ヲ
            '\uFF67': '\u30A1', // ァ
            '\uFF68': '\u30A3', // ィ
            '\uFF69': '\u30A5', // ゥ
            '\uFF6A': '\u30A7', // ェ
            '\uFF6B': '\u30A9', // ォ
            '\uFF6C': '\u30E3', // ャ
            '\uFF6D': '\u30E5', // ュ
            '\uFF6E': '\u30E7', // ョ
            '\uFF6F': '\u30C3', // ッ
            '\uFF70': '\u30FC', // ー
            '\uFF71': '\u30A2', // ア
            '\uFF72': '\u30A4', // イ
            '\uFF73': '\u30A6', // ウ
            '\uFF74': '\u30A8', // エ
            '\uFF75': '\u30AA', // オ
            '\uFF76': '\u30AB', // カ
            '\uFF77': '\u30AD', // キ
            '\uFF78': '\u30AF', // ク
            '\uFF79': '\u30B1', // ケ
            '\uFF7A': '\u30B3', // コ
            '\uFF7B': '\u30B5', // サ
            '\uFF7C': '\u30B7', // シ
            '\uFF7D': '\u30B9', // ス
            '\uFF7E': '\u30BB', // セ
            '\uFF7F': '\u30BD', // ソ
            '\uFF80': '\u30BF', // タ
            '\uFF81': '\u30C1', // チ
            '\uFF82': '\u30C4', // ツ
            '\uFF83': '\u30C6', // テ
            '\uFF84': '\u30C8', // ト
            '\uFF85': '\u30CA', // ナ
            '\uFF86': '\u30CB', // ニ
            '\uFF87': '\u30CC', // ヌ
            '\uFF88': '\u30CD', // ネ
            '\uFF89': '\u30CE', // ノ
            '\uFF8A': '\u30CF', // ハ
            '\uFF8B': '\u30D2', // ヒ
            '\uFF8C': '\u30D5', // フ
            '\uFF8D': '\u30D8', // ヘ
            '\uFF8E': '\u30DB', // ホ
            '\uFF8F': '\u30DE', // マ
            '\uFF90': '\u30DF', // ミ
            '\uFF91': '\u30E0', // ム
            '\uFF92': '\u30E1', // メ
            '\uFF93': '\u30E2', // モ
            '\uFF94': '\u30E4', // ヤ
            '\uFF95': '\u30E6', // ユ
            '\uFF96': '\u30E8', // ヨ
            '\uFF97': '\u30E9', // ラ
            '\uFF98': '\u30EA', // リ
            '\uFF99': '\u30EB', // ル
            '\uFF9A': '\u30EC', // レ
            '\uFF9B': '\u30ED', // ロ
            '\uFF9C': '\u30EF', // ワ
            '\uFF9D': '\u30F3', // ン
        };
        
        return str.replace(/[\uFF66-\uFF9F]/g, function(match) {
            return halfToFullMap[match] || match;
        });
    }
    
    // カタカナ（全角・半角両方）をひらがなに変換
    function toHiragana(str) {
        if (!str) return '';
        // まず半角カタカナを全角カタカナに変換
        str = toFullWidthKatakana(str);
        // 全角カタカナをひらがなに変換
        return str.replace(/[\u30A1-\u30F6]/g, function(match) {
            return String.fromCharCode(match.charCodeAt(0) - 0x60);
        });
    }
    
    // 郵便番号から住所を取得
    async function fetchAddressFromPostalCode(postalCode) {
        if (postalCode.length !== 7) return;
        
        try {
            const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postalCode}`);
            const data = await response.json();
            
            if (data.status === 200 && data.results && data.results.length > 0) {
                const result = data.results[0];
                const address = result.address1 + result.address2 + (result.address3 || '');
                const addressKana = (result.kana1 || '') + (result.kana2 || '') + (result.kana3 || '');
                
                const addressInput = document.getElementById('address');
                const addressKanaInput = document.getElementById('address_kana');
                
                if (addressInput) {
                    // 既存の値がある場合は、市区町村部分だけを更新
                    const currentValue = addressInput.value.trim();
                    if (currentValue && !currentValue.startsWith(address)) {
                        // 既存の値がある場合は、市区町村部分を置き換え
                        const parts = currentValue.split(/\s+/);
                        if (parts.length > 0) {
                            addressInput.value = address + ' ' + parts.slice(1).join(' ');
                        } else {
                            addressInput.value = address;
                        }
                    } else {
                        addressInput.value = address;
                    }
                }
                
                if (addressKanaInput && addressKana) {
                    // ひらがなに変換（全角カタカナまたは半角カタカナをひらがなに変換）
                    const hiragana = toHiragana(addressKana);
                    // デバッグ用：APIが返した値をコンソールに出力（開発時のみ）
                    console.log('API返却値（住所フリガナ）:', addressKana, '→ 変換後:', hiragana);
                    // 既存の値がある場合は、市区町村部分だけを更新
                    const currentKanaValue = addressKanaInput.value.trim();
                    if (currentKanaValue && !currentKanaValue.startsWith(hiragana)) {
                        const kanaParts = currentKanaValue.split(/\s+/);
                        if (kanaParts.length > 0) {
                            addressKanaInput.value = hiragana + ' ' + kanaParts.slice(1).join(' ');
                        } else {
                            addressKanaInput.value = hiragana;
                        }
                    } else {
                        addressKanaInput.value = hiragana;
                    }
                }
            }
        } catch (error) {
            console.error('郵便番号検索エラー:', error);
        }
    }

    // 氏名（ひらがな）の入力はそのまま（変換なし）

    // フォーム送信前のデータ正規化
    function normalizeFormData(form) {
        // 全角数字を半角に変換
        document.querySelectorAll('input[type="tel"], input[name="postal_code"]').forEach(input => {
            input.value = toHalfWidth(input.value).replace(/[^\d]/g, '');
        });
        // 前後の空白を削除
        document.querySelectorAll('input, textarea').forEach(input => {
            if (input.type !== 'month' && input.type !== 'date') {
                input.value = input.value.trim().replace(/\s+/g, ' ');
            }
        });
    }
    
    // フォームデータを復元
    function restoreFormData() {
        const savedData = sessionStorage.getItem('resumeFormData');
        if (!savedData) return;
        
        try {
            const formObject = JSON.parse(savedData);
            const form = document.getElementById('resume-form');
            
            Object.keys(formObject).forEach(key => {
                const values = Array.isArray(formObject[key]) ? formObject[key] : [formObject[key]];
                const inputs = form.querySelectorAll(`[name="${key}"]`);
                
                inputs.forEach((input, idx) => {
                    if (idx < values.length) {
                        input.value = values[idx];
                    }
                });
            });
        } catch (e) {
            console.error('Error restoring form data:', e);
        }
    }
    
    // 既存データをフォームにセット
    function loadExistingData() {
        @if(isset($resumeData) && $resumeData)
            const resumeData = @json($resumeData);
            
            // 学歴データをセット
            if (resumeData.education && resumeData.education.length > 0) {
                const schoolsContainer = document.getElementById('schools-container');
                // 既存の行をクリア（最初の1行は残す）
                while (schoolsContainer.children.length > 1) {
                    schoolsContainer.lastElementChild.remove();
                }
                
                resumeData.education.forEach((edu, index) => {
                    if (index > 0) {
                        addSchoolField();
                    }
                    const rows = schoolsContainer.querySelectorAll('.school-row');
                    const row = rows[index];
                    if (row) {
                        row.querySelector('input[name="school_name[]"]').value = edu.school_name || '';
                        row.querySelector('select[name="school_event_type[]"]').value = edu.event_type || '';
                        if (edu.date) {
                            const date = new Date(edu.date + '-01');
                            row.querySelector('input[name="school_date[]"]').value = 
                                date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
                        }
                    }
                });
                toggleSchoolAddButton();
            }
            
            // 職歴データをセット
            if (resumeData.work_history && resumeData.work_history.length > 0) {
                const jobsContainer = document.getElementById('jobs-container');
                while (jobsContainer.children.length > 1) {
                    jobsContainer.lastElementChild.remove();
                }
                
                resumeData.work_history.forEach((work, index) => {
                    if (index > 0) {
                        addJobField();
                    }
                    const rows = jobsContainer.querySelectorAll('.job-row');
                    const row = rows[index];
                    if (row) {
                        row.querySelector('input[name="company_name[]"]').value = work.company_name || '';
                        row.querySelector('select[name="job_event_type[]"]').value = work.event_type || '';
                        if (work.date) {
                            const date = new Date(work.date + '-01');
                            row.querySelector('input[name="job_date[]"]').value = 
                                date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
                        }
                        row.querySelector('textarea[name="job_detail[]"]').value = work.job_detail || '';
                    }
                });
                toggleJobAddButton();
            }
            
            // 免許・資格データをセット
            if (resumeData.licenses && resumeData.licenses.length > 0) {
                const licensesContainer = document.getElementById('licenses-container');
                while (licensesContainer.children.length > 1) {
                    licensesContainer.lastElementChild.remove();
                }
                
                resumeData.licenses.forEach((license, index) => {
                    if (index > 0) {
                        addLicenseField();
                    }
                    const rows = licensesContainer.querySelectorAll('.license-row');
                    const row = rows[index];
                    if (row) {
                        row.querySelector('input[name="license_name[]"]').value = license.name || '';
                        if (license.date) {
                            const date = new Date(license.date + '-01');
                            row.querySelector('input[name="license_date[]"]').value = 
                                date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
                        }
                    }
                });
                toggleLicenseAddButton();
            }
        @endif
    }
    
    // 入力中にリアルタイムで電話番号・郵便番号を正規化
    document.addEventListener('DOMContentLoaded', function() {
        loadExistingData();
        toggleSchoolAddButton();
        toggleJobAddButton();
        toggleLicenseAddButton();
        
        document.querySelectorAll('input[type="tel"], input[name="postal_code"]').forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value;
                value = toHalfWidth(value);
                value = value.replace(/[^\d]/g, '');
                if (this.value !== value) {
                    this.value = value;
                }
            });
        });
        
        // 削除ボタン制御
        function updateMinusButtons(containerId, rowClass) {
            let container = document.getElementById(containerId);
            if (!container) return;
            let rows = container.getElementsByClassName(rowClass);
            for (let i = 0; i < rows.length; i++) {
                let btn = rows[i].querySelector('button[onclick*="remove"]');
                if (btn) btn.style.display = (rows.length > 1) ? '' : 'none';
            }
        }
        setInterval(() => {
            updateMinusButtons('schools-container','school-row');
            updateMinusButtons('jobs-container','job-row');
            updateMinusButtons('licenses-container','license-row');
        }, 250);
    });
</script>

<div class="w-full bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4 text-center">履歴書作成フォーム<span class="block text-base text-gray-500 mt-1">बायोडाटा तयार गर्ने फारम</span></h2>
    <div id="form-errors" class="mb-4"></div>
    <form id="resume-form" class="space-y-4" onsubmit="validateForm(event)">
        @csrf
        <!-- 氏名（ローマ字） -->
        <div>
            <label class="block font-medium mb-1">氏名（ローマ字） / नाम (Roman Alphabet)<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">पासपोर्ट वा रेजिडेन्स कार्डमा लेखिएको रोमन अक्षरमा नाम लेख्नुहोस्। उदाहरण: TANAKA TARO</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">姓 / थर</label>
                    <input type="text" name="last_name_roman" maxlength="25" inputmode="latin-name" autocomplete="family-name"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $resumeData['last_name_roman'] ?? old('last_name_roman', '') }}" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">名 / नाम</label>
                    <input type="text" name="first_name_roman" maxlength="25" inputmode="latin-name" autocomplete="given-name"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $resumeData['first_name_roman'] ?? old('first_name_roman', '') }}" required>
                </div>
            </div>
        </div>
        <!-- 氏名（ひらがな） -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">氏名（ひらがな） / नाम (ひらがな)<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">ひらがなで入力してください。उदाहरण: たなか たろう</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">姓 / थर</label>
                    <input type="text" name="last_name_kana" maxlength="25" inputmode="hiragana" autocomplete="off"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $resumeData['last_name_kana'] ?? old('last_name_kana', '') }}" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">名 / नाम</label>
                    <input type="text" name="first_name_kana" maxlength="25" inputmode="hiragana" autocomplete="off"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                        value="{{ $resumeData['first_name_kana'] ?? old('first_name_kana', '') }}" required>
                </div>
            </div>
        </div>
        <!-- 生年月日 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">生年月日 / जन्म मिति<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">क्यालेन्डरबाट छान्नुहोस् वा मिति लेख्नुहोस्। उदाहरण: १९९० जनवरी १ → 1990-01-01</p>
            <input type="date" name="birthday"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                value="{{ $resumeData['birthday'] ?? old('birthday', '') }}" required>
        </div>
        <!-- 性別 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">性別 / लिङ्ग<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">आफ्नो लिङ्ग छान्नुहोस्।</p>
            <div class="flex gap-6 mt-1">
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="男" class="accent-blue-600" 
                        {{ ($resumeData['gender'] ?? old('gender')) === '男' ? 'checked' : '' }} required>
                    <span class="ml-2">男<span class="ml-1 text-xs text-gray-500">पुरुष</span></span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="女" class="accent-blue-600" 
                        {{ ($resumeData['gender'] ?? old('gender')) === '女' ? 'checked' : '' }} required>
                    <span class="ml-2">女<span class="ml-1 text-xs text-gray-500">महिला</span></span>
                </label>
            </div>
        </div>
        <!-- 電話番号 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">電話番号 / फोन नम्बर<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">हाइफन (-) बिना १० वा ११ अंकको संख्या मात्र लेख्नुहोस्। पूर्ण-वर्ण संख्या लेख्नुभयो भने स्वचालित रूपमा अर्ध-वर्णमा परिवर्तन हुनेछ। उदाहरण: 09012345678</p>
            <input type="tel" name="phone" maxlength="11" pattern="\d{10,11}" inputmode="numeric"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                value="{{ $resumeData['phone'] ?? old('phone', '') }}"
                onblur="normalizeNumeric(this)" required>
        </div>
        <!-- 郵便番号 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">郵便番号 / हुलाक नम्बर<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">हाइफन (-) बिना ७ अंकको संख्या मात्र लेख्नुहोस्। पूर्ण-वर्ण संख्या लेख्नुभयो भने स्वचालित रूपमा अर्ध-वर्णमा परिवर्तन हुनेछ। उदाहरण: 1234567</p>
            <input type="text" name="postal_code" maxlength="7" pattern="\d{7}" inputmode="numeric"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                value="{{ $resumeData['postal_code'] ?? old('postal_code', '') }}"
                onblur="normalizeNumeric(this)" required>
        </div>
        <!-- 住所 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">住所 / ठेगाना<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">郵便番号を入力すると、市区町村まで自動でセットされます。番地、建物名、号室だけ追記してください。प्रान्तबाट सङ्ख्या, मेन्सनको नाम, कोठा नम्बर सम्म सही रूपमा लेख्नुहोस्। हुलाक नम्बर लेख्नुभयो भने शहर/जिल्ला सम्म स्वचालित रूपमा सेट हुनेछ। बाँकी सङ्ख्या, मेन्सनको नाम, कोठा नम्बर मात्र थप्नुहोस्। उदाहरण: 東京都渋谷区〇〇1-2-3 マンション名101号室</p>
            <input type="text" name="address" id="address" maxlength="150"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                value="{{ $resumeData['address'] ?? old('address', '') }}" required>
        </div>
        <!-- 住所ふりがな -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">住所ふりがな / ठेगाना (ひらがな)<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">
                郵便番号を入力すると住所のひらがな読み方が自動的にセットされます。残りの番地、建物名、号室のひらがな読み方だけ追加してください。
                <span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">
                    हुलाक नम्बर हाल्दा ठेगानाको हिरागाना स्वतः भरिनेछ। बाँकी घर नम्बर, भवनको नाम, कोठा नम्बरको हिरागाना मात्र थप्नुहोस्। उदाहरण: とうきょうとしぶやく〇〇1-2-3 まんしょんめい101ごうしつ
                </span>
            </p>
            <input type="text" name="address_kana" id="address_kana" maxlength="200" inputmode="hiragana"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                value="{{ $resumeData['address_kana'] ?? old('address_kana', '') }}" required>
        </div>

        <!-- 学歴 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">学歴 / शैक्षिक विवरण<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">स्कूलको नाम लेख्नुहोस्, त्यसपछि प्रवेश वा स्नातक छान्नुहोस्, र वर्ष/महिना छान्नुहोस्। धेरै स्कूल भएको खण्डमा "+" बटन थिचेर थप्नुहोस्।</p>
            <div id="schools-container">
                <div class="school-row mb-3 pb-3 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-2 items-start mb-2 flex-wrap">
                        <input type="text" name="school_name[]" placeholder="स्कूलको नाम (उदाहरण: 〇〇 विश्वविद्यालय)" maxlength="40"
                            class="border rounded px-3 py-2 flex-1 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <select name="school_event_type[]" 
                            class="border rounded px-3 py-2 sm:w-36 md:w-40 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                            <option value="">छान्नुहोस्</option>
                            <option value="入学">入学 / प्रवेश</option>
                            <option value="卒業">卒業 / स्नातक</option>
                        </select>
                        <input type="month" name="school_date[]" 
                            class="border rounded px-3 py-2 sm:w-40 md:w-44 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <button type="button" onclick="removeSchoolField(this)" class="text-red-500 px-2 py-2 hidden sm:block">
                            &#8722;
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-school-btn" onclick="addSchoolField()"
                class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                ＋ 学歴を追加 / शैक्षिक विवरण थप्नुहोस्
            </button>
        </div>
        <!-- 職歴 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">職歴 / रोजगार विवरण<span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-2">कम्पनीको नाम लेख्नुहोस्, त्यसपछि नियुक्ति वा राजिनामा छान्नुहोस्, र वर्ष/महिना छान्नुहोस्। कामको विवरण विस्तृत रूपमा लेख्नुहोस्। धेरै काम भएको खण्डमा "+" बटन थिचेर थप्नुहोस्।</p>
            <div id="jobs-container">
                <div class="job-row mb-3 pb-3 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-2 items-start mb-2 flex-wrap">
                        <input type="text" name="company_name[]" placeholder="कम्पनीको नाम (उदाहरण: 〇〇 कम्पनी)" maxlength="40"
                            class="border rounded px-3 py-2 flex-1 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <select name="job_event_type[]" 
                            class="border rounded px-3 py-2 sm:w-36 md:w-40 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                            <option value="">छान्नुहोस्</option>
                            <option value="入社">入社 / नियुक्ति</option>
                            <option value="退職">退職 / राजिनामा</option>
                        </select>
                        <input type="month" name="job_date[]" 
                            class="border rounded px-3 py-2 sm:w-40 md:w-44 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <button type="button" onclick="removeJobField(this)" class="text-red-500 px-2 py-2 hidden sm:block">
                            &#8722;
                        </button>
                    </div>
                    <textarea name="job_detail[]" rows="3" maxlength="300"
                        class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-blue-400 focus:ring-2 mt-1"
                        placeholder="कामको विवरण विस्तृत रूपमा लेख्नुहोस् (उदाहरण: बिक्रीमा नयाँ ग्राहक खोज्ने जिम्मेवारी। मासिक बिक्री लक्ष्य १२०% पूरा गरे।)" required></textarea>
                </div>
            </div>
            <button type="button" id="add-job-btn" onclick="addJobField()"
                class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                ＋ 職歴を追加 / रोजगार विवरण थप्नुहोस्
            </button>
        </div>

        <!-- 免許・資格 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">免許・資格 / अन्य योग्यता<span class="text-gray-500"> (任意)</span></label>
            <p class="text-xs text-gray-500 mb-2">प्राप्त गरेको लाइसेन्स वा योग्यता भएमा लेख्नुहोस्। योग्यताको नाम र प्राप्त गरेको वर्ष/महिना लेख्नुहोस्। धेरै योग्यता भएको खण्डमा "+" बटन थिचेर थप्नुहोस्।</p>
            <div id="licenses-container">
                <div class="license-row flex flex-col sm:flex-row gap-2 items-start mb-2">
                    <input type="text" name="license_name[]" placeholder="योग्यताको नाम (उदाहरण: साधारण कार ड्राइभिङ लाइसेन्स)" maxlength="40"
                        class="border rounded px-3 py-2 w-full sm:w-2/3 focus:outline-none focus:ring-blue-400 focus:ring-2">
                    <input type="month" name="license_date[]" placeholder="प्राप्त गरेको वर्ष/महिना"
                        class="border rounded px-3 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-blue-400 focus:ring-2">
                    <button type="button" onclick="removeLicenseField(this)" class="text-red-500 px-1 ml-1 hidden sm:block">
                        &#8722;
                    </button>
                </div>
            </div>
            <button type="button" id="add-license-btn" onclick="addLicenseField()"
                class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                ＋ 免許・資格を追加 / योग्यता थप्नुहोस्
            </button>
        </div>

        <!-- 志望動機・特技・アピールポイント -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">志望動機・特技・アピールポイント / आफ्नो तयारी, रुचि, विशेषता</label>
            <p class="text-xs text-gray-500 mb-2">रोजगारको लागि तयारी, तपाईंको विशेषता, आफूलाई प्रस्तुत गर्न सक्ने बुँदाहरू लेख्नुहोस्। संक्षेपमा विस्तृत रूपमा लेख्नुहोस्। वैकल्पिक खण्ड हो।</p>
            <textarea name="appeal_points" rows="4" maxlength="400"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"
                placeholder="उदाहरण: जापानमा काम गर्न चाहन्छु। भाषा कौशल प्रयोग गरेर विश्वव्यापी दृष्टिकोणबाट योगदान दिन चाहन्छु。">{{ $resumeData['appeal_points'] ?? old('appeal_points', '') }}</textarea>
        </div>
        <!-- 本人希望欄 -->
        <div class="pt-4 border-t border-gray-200">
            <label class="block font-medium mb-1">本人希望欄 / आफ्नो चाहना</label>
            <p class="text-xs text-gray-500 mb-2">कामको ठेगाना, समय, तलबको चाहना भएमा लेख्नुहोस्। विशेष चाहना नभएको खण्डमा खाली राख्न सकिन्छ। वैकल्पिक खण्ड हो।</p>
            <textarea name="self_request" rows="2" maxlength="200"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"
                placeholder="उदाहरण: चाहिएको कामको ठेगाना: टोक्यो शहर / कामको समय: हप्ता ५ दिन, ९:०० बजे देखि ६:०० बजे सम्म">{{ $resumeData['self_request'] ?? old('self_request', '') }}</textarea>
        </div>

        <div class="mt-6 flex justify-center">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700 transition">
                内容確認 / विवरण जाँच गर्नुहोस्
            </button>
        </div>
    </form>
</div>

