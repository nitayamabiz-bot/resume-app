<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録またはログイン</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold mb-2 text-center">
            履歴書を保存する
            <span class="block text-base text-gray-500 mt-1 font-normal">बायोडाटा बचत गर्नुहोस्</span>
        </h1>
        <p class="text-center text-gray-600 mb-6">
            履歴書を保存するには、会員登録またはログインが必要です。
            <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">बायोडाटा बचत गर्न, दर्ता वा लगइन आवश्यक छ।</span>
        </p>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- 会員登録 -->
            <div class="border-2 border-blue-200 rounded-lg p-6 hover:border-blue-400 transition">
                <h2 class="text-xl font-semibold mb-2">
                    新規会員登録
                    <span class="block text-sm text-gray-500 font-normal mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">नयाँ दर्ता</span>
                </h2>
                <p class="text-gray-600 mb-4 text-sm">
                    新しいアカウントを作成して履歴書を保存します。
                    <span class="block mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">नयाँ खाता सिर्जना गरेर बायोडाटा बचत गर्नुहोस्।</span>
                </p>
                <a href="{{ route('register') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded font-semibold hover:bg-blue-700 transition">
                    会員登録する
                    <span class="block text-xs mt-1 opacity-90" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">दर्ता गर्नुहोस्</span>
                </a>
            </div>

            <!-- ログイン -->
            <div class="border-2 border-green-200 rounded-lg p-6 hover:border-green-400 transition">
                <h2 class="text-xl font-semibold mb-2">
                    ログイン
                    <span class="block text-sm text-gray-500 font-normal mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">लगइन</span>
                </h2>
                <p class="text-gray-600 mb-4 text-sm">
                    既存のアカウントでログインして履歴書を保存します。
                    <span class="block mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">अवस्थित खातामा लगइन गरेर बायोडाटा बचत गर्नुहोस्।</span>
                </p>
                <a href="{{ route('login') }}" class="block w-full bg-green-600 text-white text-center py-3 rounded font-semibold hover:bg-green-700 transition">
                    ログインする
                    <span class="block text-xs mt-1 opacity-90" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">लगइन गर्नुहोस्</span>
                </a>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('resume.create') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                戻る / फिर्ता जानुहोस्
            </a>
        </div>
    </div>
</body>
</html>



