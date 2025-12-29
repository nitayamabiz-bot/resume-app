<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>履歴書作成フォーム</title>
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
            btn.disabled = container.children.length >= 6;
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
            btn.disabled = container.children.length >= 6;
        }

        // 入力チェック 
        function validateForm(event) {
            let form = document.getElementById('resume-form');
            let errors = [];

            // 必須チェック
            if (!form['name_roman'].value.trim()) errors.push('氏名（ローマ字）は必須です。');
            if (!form['name_kana'].value.trim()) errors.push('氏名（カタカナ）は必須です。');
            if (!form['birthday'].value) errors.push('生年月日を選択してください。');
            if (!form['gender'].value) errors.push('性別を選択してください。');
            // 電話番号: 必須, 数値のみ, 10〜11ケタ
            let phone = form['phone'].value.trim();
            if (!phone) {
                errors.push('電話番号は必須です。');
            } else if (!/^\d{10,11}$/.test(phone)) {
                errors.push('電話番号は10〜11桁の数字のみで入力してください（ハイフンなし）。');
            }
            // 住所
            if (!form['address'].value.trim()) {
                errors.push('住所は必須です。');
            }
            // 郵便番号: 必須, 数値のみ, 7桁
            let postal = form['postal_code'].value.trim();
            if (!postal) {
                errors.push('郵便番号は必須です。');
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
                event.preventDefault();
                let errDiv = document.getElementById('form-errors');
                errDiv.innerHTML = errors.map(e => `<div class="text-red-600">${e}</div>`).join('');
                window.scrollTo(0,0);
            } else {
                // エラーがない場合、データを正規化
                normalizeFormData(form);
            }
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
            btn.disabled = container.children.length >= 6;
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
        }

        // 入力中にリアルタイムで電話番号・郵便番号を正規化
        document.addEventListener('DOMContentLoaded', function() {
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
        });

        // 期間の自動フォーマット（YYYY.MM ～ YYYY.MM形式に統一）
        function formatPeriod(input) {
            let value = input.value.trim();
            if (!value) return;
            // 全角数字を半角に変換
            value = toHalfWidth(value);
            // YYYY-MM形式をYYYY.MMに変換
            value = value.replace(/(\d{4})-(\d{1,2})/g, '$1.$2');
            // YYYY年MM月形式をYYYY.MMに変換
            value = value.replace(/(\d{4})年(\d{1,2})月?/g, '$1.$2');
            // 全角記号を半角に統一（～、ー、〜）
            value = value.replace(/[～ー〜]/g, '～');
            // 空白を削除
            value = value.replace(/\s+/g, ' ');
            // 期間の区切りを「 ～ 」に統一
            value = value.replace(/\s*[～〜ー]\s*/g, ' ～ ');
            input.value = value;
        }

        // 氏名（カタカナ）の自動変換（ひらがな→カタカナ、英数字→全角）
        function toKatakana(input) {
            let value = input.value;
            // ひらがなをカタカナに変換
            value = value.replace(/[\u3041-\u3096]/g, function(match) {
                return String.fromCharCode(match.charCodeAt(0) + 0x60);
            });
            // 半角英数字を全角に変換
            value = value.replace(/[A-Za-z0-9]/g, function(s) {
                return String.fromCharCode(s.charCodeAt(0) + 0xFEE0);
            });
            input.value = value;
        }

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
    </script>
</head>
<body class="bg-gray-50 py-4">
    <div class="max-w-lg md:max-w-2xl lg:max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-2 text-center">履歴書作成フォーム<span class="block text-base text-gray-500 mt-1">बायोडाटा तयार गर्ने फारम</span></h1>
        <div id="form-errors" class="mb-2"></div>
        <form id="resume-form" class="space-y-4" method="post" action="{{ route('resume.store') }}" onsubmit="validateForm(event)">
            @csrf
            <!-- 氏名（ローマ字） -->
            <div>
                <label class="block font-medium mb-1">氏名（ローマ字） / नाम (Roman Alphabet)<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">पासपोर्ट वा रेजिडेन्स कार्डमा लेखिएको रोमन अक्षरमा नाम लेख्नुहोस्। उदाहरण: TANAKA TARO</p>
                <input type="text" name="name_roman" maxlength="50" inputmode="latin-name" autocomplete="name"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 氏名（カタカナ） -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">氏名（カタカナ） / नाम (カタカナ)<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">पूर्ण-वर्ण काताकानामा लेख्नुहोस्। हिरागानामा लेख्नुभयो भने स्वचालित रूपमा काताकानामा परिवर्तन हुनेछ। उदाहरण: タナカ タロウ</p>
                <input type="text" name="name_kana" maxlength="50" autocomplete="off"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                    onblur="toKatakana(this)" required>
            </div>
            <!-- 生年月日 -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">生年月日 / जन्म मिति<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">क्यालेन्डरबाट छान्नुहोस् वा मिति लेख्नुहोस्। उदाहरण: १९९० जनवरी १ → 1990-01-01</p>
                <input type="date" name="birthday"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 性別 -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">性別 / लिङ्ग<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">आफ्नो लिङ्ग छान्नुहोस्।</p>
                <div class="flex gap-6 mt-1">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="男" class="accent-blue-600" required>
                        <span class="ml-2">男<span class="ml-1 text-xs text-gray-500">पुरुष</span></span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="女" class="accent-blue-600" required>
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
                    onblur="normalizeNumeric(this)" required>
            </div>
            <!-- 郵便番号 -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">郵便番号 / हुलाक नम्बर<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">हाइफन (-) बिना ७ अंकको संख्या मात्र लेख्नुहोस्। पूर्ण-वर्ण संख्या लेख्नुभयो भने स्वचालित रूपमा अर्ध-वर्णमा परिवर्तन हुनेछ। उदाहरण: 1234567</p>
                <input type="text" name="postal_code" maxlength="7" pattern="\d{7}" inputmode="numeric"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" 
                    onblur="normalizeNumeric(this)" required>
            </div>
            <!-- 住所 -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">住所 / ठेगाना<span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">प्रान्तबाट सङ्ख्या, मेन्सनको नाम, कोठा नम्बर सम्म सही रूपमा लेख्नुहोस्। उदाहरण: 東京都渋谷区〇〇1-2-3 マンション名101号室</p>
                <input type="text" name="address" maxlength="150"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
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
                    placeholder="उदाहरण: जापानमा काम गर्न चाहन्छु। भाषा कौशल प्रयोग गरेर विश्वव्यापी दृष्टिकोणबाट योगदान दिन चाहन्छु।"></textarea>
            </div>
            <!-- 本人希望欄 -->
            <div class="pt-4 border-t border-gray-200">
                <label class="block font-medium mb-1">本人希望欄 / आफ्नो चाहना</label>
                <p class="text-xs text-gray-500 mb-2">कामको ठेगाना, समय, तलबको चाहना भएमा लेख्नुहोस्। विशेष चाहना नभएको खण्डमा खाली राख्न सकिन्छ। वैकल्पिक खण्ड हो।</p>
                <textarea name="self_request" rows="2" maxlength="200"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"
                    placeholder="उदाहरण: चाहिएको कामको ठेगाना: टोक्यो शहर / कामको समय: हप्ता ५ दिन, ९:०० बजे देखि ६:०० बजे सम्म"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition">
                    送信する / पठाउनुहोस्
                </button>
            </div>
        </form>
    </div>
    <script>
        // ページロード時、最初の行の削除ボタンを非表示
        document.addEventListener('DOMContentLoaded', function () {
            toggleSchoolAddButton();
            toggleJobAddButton();
            toggleLicenseAddButton();
            // 削除ボタン制御
            function updateMinusButtons(containerId, rowClass) {
                let rows = document.getElementById(containerId).getElementsByClassName(rowClass);
                for (let i = 0; i < rows.length; i++) {
                    let btn = rows[i].querySelector('button');
                    if (btn) btn.style.display = (rows.length > 1) ? '' : 'none';
                }
            }
            window.setInterval(() => {
                updateMinusButtons('schools-container','school-row');
                updateMinusButtons('jobs-container','job-row');
                updateMinusButtons('licenses-container','license-row');
            }, 250);
        });
    </script>
</body>
</html>
