<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>就労支援サービス</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.webp') }}">
    <style>
        body {
            background-color: #f6f7fa;
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif;
            color: #222;
        }
        .header {
            width: 100%;
            background-color: #ffffffe6;
            padding: 24px 0 16px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(180,180,180,0.05);
            position: relative;
        }
        .nav-links {
            position: absolute;
            top: 24px;
            right: 20px;
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .nav-link {
            color: #1160E6;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .nav-link:hover {
            background-color: #f0f4ff;
        }
        .nav-link-btn {
            background-color: #1160E6;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }
        .nav-link-btn:hover {
            background-color: #0346b0;
        }
        @media (max-width: 550px) {
            .nav-links {
                position: static;
                justify-content: center;
                margin-bottom: 16px;
                flex-wrap: wrap;
            }
            .header {
                padding: 16px 0;
            }
        }
        .logo-main {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.07em;
        }
        .logo-sub {
            display: block;
            font-size: 0.92rem;
            color: #888;
            margin-top: 2px;
        }
        .center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 48px 20px 0 20px;
            width: 100%;
            box-sizing: border-box;
        }
        .main-heading {
            font-size: 2rem;
            font-weight: 500;
            margin-bottom: 0.35em;
            text-align: center;
            line-height: 1.22;
        }
        .heading-nepali {
            font-size: 1.05rem;
            color: #3E5387;
            margin-bottom: 2.5em;
            display: block;
            text-align: center;
            font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        }
        .buttons-row {
            display: flex;
            flex-direction: row;
            gap: 28px;
            justify-content: center;
            flex-wrap: nowrap;
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
        }
        .action-btn {
            background-color: #1160E6;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            border: none;
            border-radius: 999px;
            padding: 20px 38px;
            box-shadow: 0 3px 12px rgba(50,90,180,0.04);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 220px;
            cursor: pointer;
            transition: background 0.16s;
            position: relative;
            text-decoration: none;
        }
        .action-btn:hover {
            background-color: #0346b0;
        }
        .btn-main-text {
            font-size: 1.15em;
        }
        .btn-sub-text {
            font-size: 0.92em;
            color: #e0eaff;
            margin-top: 6px;
            font-family: 'Noto Sans Devanagari', Arial, sans-serif;
            font-weight: 400;
        }

        @media (max-width: 700px) {
            .center-content {
                margin: 30px 8px 0 8px;
                padding: 0;
            }
            .main-heading {
                font-size: 1.3rem;
            }
            .logo-main {
                font-size: 1.25rem;
            }
            .buttons-row {
                flex-wrap: wrap;
                width: 100%;
                padding: 0;
            }
        }
        @media (max-width: 550px) {
            .center-content {
                margin: 30px 0 0 0;
                padding: 0 16px;
            }
            .buttons-row {
                flex-direction: column;
                gap: 14px;
                align-items: stretch;
                width: 100%;
                padding: 0;
            }
            .action-btn {
                width: 100%;
                min-width: 0;
                font-size: 1.06rem;
                padding: 16px 20px;
                margin-bottom: 0;
                box-sizing: border-box;
            }
        }
    </style>
    <!-- Google Fonts Noto Sans Devanagari and Noto Sans JP (optional, can be removed if not available) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="nav-links">
            @auth
                <a href="{{ route('home') }}" class="nav-link">マイページ<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">मेरो पृष्ठ</span></a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link-btn">ログアウト<span class="block text-xs" style="font-size: 0.7rem; opacity: 0.9;">लगआउट</span></button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">ログイン<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">लगइन</span></a>
                <a href="{{ route('register') }}" class="nav-link-btn">新規登録<span class="block text-xs" style="font-size: 0.7rem; opacity: 0.9;">दर्ता</span></a>
            @endauth
        </div>
        <span class="logo-main">就労支援サービス
            <span class="logo-sub">रोजगार सहायता सेवा</span>
        </span>
    </header>
    <main>
        <div class="center-content">
            <h1 class="main-heading">
                日本での就職活動を簡単に。
                <span class="heading-nepali">जापानमा रोजगारको खोजी सजिलो बनाऔं।</span>
            </h1>
            <div class="buttons-row">
                <a href="/create" class="action-btn">
                    <span class="btn-main-text">履歴書を作成する</span>
                    <span class="btn-sub-text">बायोडाटा तयार गर्नुहोस्</span>
                </a>
                <button class="action-btn">
                    <span class="btn-main-text">職務経歴書を作成する</span>
                    <span class="btn-sub-text">कामको अनुभव तयार गर्नुहोस्</span>
                </button>
            </div>
        </div>
    </main>
</body>
</html>
