<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>履歴書作成フォーム</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // 学歴追加/削除
        function addSchoolField() {
            let container = document.getElementById('schools-container');
            let count = container.children.length;
            if (count >= 6) return;
            let clone = container.children[0].cloneNode(true);
            Array.from(clone.querySelectorAll('input')).forEach(input => input.value = '');
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
            Array.from(clone.querySelectorAll('input,textarea')).forEach(input => input.value = '');
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
                let period = row.querySelector('input[name="school_period[]"]').value.trim();
                if (!school && !period && idx > 0) return; // 最初以外空欄許可
                if (!school) errors.push(`学歴${idx+1}：学校名を入力してください。`);
                if (!period) errors.push(`学歴${idx+1}：期間を入力してください。`);
            });
            // 職歴チェック
            document.querySelectorAll('.job-row').forEach((row, idx) => {
                let company = row.querySelector('input[name="company_name[]"]').value.trim();
                let period = row.querySelector('input[name="company_period[]"]').value.trim();
                let detail = row.querySelector('textarea[name="job_detail[]"]').value.trim();
                if (!company && !period && !detail && idx > 0) return; // 最初以外空欄許可
                if (!company) errors.push(`職歴${idx+1}：会社名を入力してください。`);
                if (!period) errors.push(`職歴${idx+1}：期間を入力してください。`);
                if (!detail) errors.push(`職歴${idx+1}：業務内容を入力してください。`);
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
    </script>
</head>
<body class="bg-gray-50 py-4">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-2 text-center">履歴書作成フォーム<span class="block text-base text-gray-500 mt-1">बायोडाटा तयार गर्ने फारम</span></h1>
        <div id="form-errors" class="mb-2"></div>
        <form id="resume-form" class="space-y-4" method="post" action="<?php echo e(route('resume.store')); ?>" onsubmit="validateForm(event)">
            <?php echo csrf_field(); ?>
            <!-- 氏名（ローマ字） -->
            <div>
                <label class="block font-medium mb-1">氏名（ローマ字）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">नाम (Roman Alphabet)</span>
                </label>
                <input type="text" name="name_roman" maxlength="90" inputmode="latin-name" autocomplete="name"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 氏名（カタカナ） -->
            <div>
                <label class="block font-medium mb-1">氏名（カタカナ）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">नाम (カタカナ)</span>
                </label>
                <input type="text" name="name_kana" maxlength="90" autocomplete="off"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 生年月日 -->
            <div>
                <label class="block font-medium mb-1">生年月日<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">जन्म मिति</span>
                </label>
                <input type="date" name="birthday"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 性別 -->
            <div>
                <label class="block font-medium mb-1">性別<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">लिङ्ग</span>
                </label>
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
            <div>
                <label class="block font-medium mb-1">電話番号（ハイフンなし）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">फोन नम्बर (हाइफन नगर्नुहोस्)</span>
                </label>
                <input type="tel" name="phone" maxlength="11" pattern="\d*" inputmode="numeric"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 郵便番号 -->
            <div>
                <label class="block font-medium mb-1">郵便番号<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">हुलाक नम्बर</span>
                </label>
                <input type="text" name="postal_code" maxlength="7" pattern="\d{7}" inputmode="numeric"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>
            <!-- 住所 -->
            <div>
                <label class="block font-medium mb-1">住所（マンション名・号室まで正確に）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">ठेगाना</span>
                </label>
                <input type="text" name="address" maxlength="200"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
            </div>

            <!-- 学歴 -->
            <div>
                <label class="block font-medium mb-1">学歴（学校名・期間）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">शैक्षिक विवरण</span>
                </label>
                <div id="schools-container">
                    <div class="school-row flex flex-col sm:flex-row gap-2 items-start mb-2">
                        <input type="text" name="school_name[]" placeholder="学校名・School Name"
                            class="border rounded px-3 py-2 w-full sm:w-1/2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <input type="text" name="school_period[]" placeholder="期間（例: 2015-2018）"
                            class="border rounded px-3 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                        <button type="button" onclick="removeSchoolField(this)" class="text-red-500 px-1 ml-1 hidden sm:block">
                            &#8722;
                        </button>
                    </div>
                </div>
                <button type="button" id="add-school-btn" onclick="addSchoolField()"
                    class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                    ＋
                </button>
            </div>
            <!-- 職歴 -->
            <div>
                <label class="block font-medium mb-1">職歴（会社名・期間・業務内容）<span class="text-red-500">*</span>
                    <span class="block text-xs text-gray-500">रोजगार विवरण</span>
                </label>
                <div id="jobs-container">
                    <div class="job-row flex flex-col gap-2 mb-2 border-b pb-2">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="text" name="company_name[]" placeholder="会社名・Company Name"
                                class="border rounded px-3 py-2 w-full sm:w-1/2 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                            <input type="text" name="company_period[]" placeholder="期間（例: 2020-2023）"
                                class="border rounded px-3 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-blue-400 focus:ring-2" required>
                            <button type="button" onclick="removeJobField(this)" class="text-red-500 px-1 ml-1 hidden sm:block">
                                &#8722;
                            </button>
                        </div>
                        <textarea name="job_detail[]" rows="2" maxlength="300"
                            class="border rounded px-3 py-2 w-full focus:outline-none focus:ring-blue-400 focus:ring-2 mt-1"
                            placeholder="業務内容・仕事内容・Job Description" required></textarea>
                    </div>
                </div>
                <button type="button" id="add-job-btn" onclick="addJobField()"
                    class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                    ＋
                </button>
            </div>

            <!-- 免許・資格 -->
            <div>
                <label class="block font-medium mb-1">免許・資格（名称、取得年月）<span class="text-gray-500">(任意)</span>
                    <span class="block text-xs text-gray-500">अन्य योग्यता</span>
                </label>
                <div id="licenses-container">
                    <div class="license-row flex flex-col sm:flex-row gap-2 items-start mb-2">
                        <input type="text" name="license_name[]" placeholder="資格・License/Certificate Name"
                            class="border rounded px-3 py-2 w-full sm:w-2/3 focus:outline-none focus:ring-blue-400 focus:ring-2">
                        <input type="month" name="license_date[]" placeholder="取得年月"
                            class="border rounded px-3 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-blue-400 focus:ring-2">
                        <button type="button" onclick="removeLicenseField(this)" class="text-red-500 px-1 ml-1 hidden sm:block">
                            &#8722;
                        </button>
                    </div>
                </div>
                <button type="button" id="add-license-btn" onclick="addLicenseField()"
                    class="mt-2 px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm">
                    ＋
                </button>
            </div>

            <!-- 志望動機・特技・アピールポイント -->
            <div>
                <label class="block font-medium mb-1">志望動機・特技・アピールポイント
                    <span class="block text-xs text-gray-500">आफ्नो तयारी, रुचि, विशेषता</span>
                </label>
                <textarea name="appeal_points" rows="4" maxlength="800"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"></textarea>
            </div>
            <!-- 本人希望欄 -->
            <div>
                <label class="block font-medium mb-1">本人希望欄
                    <span class="block text-xs text-gray-500">आफ्नो चाहना</span>
                </label>
                <textarea name="self_request" rows="2" maxlength="400"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-blue-400 focus:ring-2"></textarea>
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
<?php /**PATH /Users/ni/Desktop/resume-app/resources/views/resume/create.blade.php ENDPATH**/ ?>