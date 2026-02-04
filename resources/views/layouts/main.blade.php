<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', '就労支援サービス')</title>
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('description', '日本で生活・就労するネパール人の方向けの就労支援サービス。ビザ・家族・転職・永住・役所の手続き、履歴書・職務経歴書作成、就職・アルバイト情報、賃貸・SIM・ネット回線情報などを提供しています。')">
    <meta name="keywords" content="@yield('keywords', 'ネパール,就労支援,ビザ,在留資格,履歴書,職務経歴書,就職,アルバイト,賃貸,SIM,ネット回線,行政手続き')">
    <meta name="author" content="就労支援サービス">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    @php
        // 正規URLを生成（末尾スラッシュなし、クエリパラメータなし）
        // サイトマップと一致させるため、すべてのページで末尾スラッシュなし
        $currentPath = parse_url(url()->current(), PHP_URL_PATH);
        $baseUrl = rtrim(config('sitemap.base_url'), '/');
        $canonicalUrl = $baseUrl . ($currentPath === '/' ? '/' : rtrim($currentPath, '/'));
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">
    
    {{-- Language Alternates --}}
    <link rel="alternate" hreflang="ja" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="ne" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="@yield('og:title', '就労支援サービス')">
    <meta property="og:description" content="@yield('og:description', '日本で生活・就労するネパール人の方向けの就労支援サービス。ビザ・家族・転職・永住・役所の手続き、履歴書・職務経歴書作成、就職・アルバイト情報、賃貸・SIM・ネット回線情報などを提供しています。')">
    <meta property="og:image" content="@yield('og:image', asset('images/logo.webp'))">
    <meta property="og:site_name" content="就労支援サービス">
    <meta property="og:locale" content="ja_JP">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="@yield('twitter:title', '就労支援サービス')">
    <meta name="twitter:description" content="@yield('twitter:description', '日本で生活・就労するネパール人の方向けの就労支援サービス。ビザ・家族・転職・永住・役所の手続き、履歴書・職務経歴書作成、就職・アルバイト情報、賃貸・SIM・ネット回線情報などを提供しています。')">
    <meta name="twitter:image" content="@yield('twitter:image', asset('images/logo.webp'))">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.webp') }}">
    
    {{-- Preconnect for Performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Preload critical resources (LCP改善) --}}
    <link rel="preload" href="{{ asset('images/logo.webp') }}" as="image" fetchpriority="high">
    @stack('head')
    <style>
        /* クリティカルCSS: レイアウトシフトを防ぐための初期スタイル */
        /* FCPを早めるため、初期表示を改善 */
        html {
            visibility: visible;
            opacity: 1;
        }
        html.loading {
            visibility: hidden;
            opacity: 0;
        }
        html.loaded {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.1s;
        }
        body {
            background-color: #f6f7fa;
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif;
            color: #222;
            min-height: 100vh;
        }
        .header {
            width: 100% !important;
            max-width: 100% !important;
            background-color: #ffffffe6;
            padding: 24px 0 0px 0;
            box-shadow: 0 2px 8px rgba(180,180,180,0.05);
            position: relative;
            margin: 0 !important;
            box-sizing: border-box !important;
            overflow: visible !important;
            z-index: 100;
            min-height: 100px; /* 初期高さを固定してレイアウトシフトを防ぐ */
        }
        .header .header-content {
            max-width: 1200px !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
            overflow: visible !important;
            position: relative;
        }
        .header .nav-menu {
            display: flex !important;
            justify-content: center !important;
            gap: 0 !important;
            flex-wrap: nowrap !important;
            border-top: 1px solid #e5e7eb !important;
            padding-top: 12px !important;
            padding-bottom: 20px !important;
            overflow: visible !important;
            min-height: 50px; /* 初期高さを固定してレイアウトシフトを防ぐ */
        }
        .logo-section {
            text-align: center;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
        }
        .logo-image {
            height: 40px;
            width: auto;
            min-width: 40px; /* 初期幅を指定 */
            flex-shrink: 0;
            margin-top: 0.1em;
            display: block; /* レイアウトシフトを防ぐ */
        }
        .logo-text-wrapper {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .logo-main {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            line-height: 1.2;
            min-height: 1.2em; /* フォント読み込み前の高さを固定 */
            display: inline-block; /* レイアウトシフトを防ぐ */
        }
        .logo-link {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: opacity 0.2s;
        }
        .logo-link:hover {
            opacity: 0.7;
        }
        .logo-sub {
            display: block;
            font-size: 0.92rem;
            color: #888;
            margin-top: 2px;
            min-height: 1.2em; /* フォント読み込み前の高さを固定 */
        }
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            gap: 5px;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        .hamburger-btn span {
            display: block;
            width: 24px;
            height: 2px;
            background-color: #1160E6;
            transition: all 0.3s;
        }
        .hamburger-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(7px, 7px);
        }
        .hamburger-btn.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        /* ドロップダウンメニューのスタイル */
        .dropdown {
            position: relative;
            flex: 1;
            min-width: 0;
            display: flex;
            justify-content: center;
        }
        .dropdown .nav-item {
            position: relative;
            width: 100%;
        }
        /* ドロップダウンの区切り線は表示する */
        .nav-menu > .dropdown:not(:last-child) > .nav-item::after {
            content: '' !important;
            display: block !important;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 24px;
            background-color: #e5e7eb;
            z-index: 1;
        }
        /* 通常のnav-itemの区切り線 */
        .nav-menu > .nav-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 24px;
            background-color: #e5e7eb;
        }
        .dropdown-toggle {
            cursor: pointer;
            user-select: none;
        }
        .dropdown-menu {
            display: none !important;
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            z-index: 1001;
            white-space: nowrap;
        }
        .dropdown.active .dropdown-menu {
            display: block !important;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #1e293b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        .dropdown-item:first-child {
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }
        .dropdown-item:last-child {
            border-bottom: none;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .dropdown-item:hover {
            background-color: #e0e7ff;
            color: #1160E6;
        }
        .dropdown-item.active {
            background-color: #dbeafe;
            color: #1160E6;
            font-weight: 600;
        }
        .dropdown-item-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 8px;
            vertical-align: middle;
            flex-shrink: 0;
        }
        .dropdown-arrow {
            display: inline-block;
            margin-left: 4px;
            transition: transform 0.2s;
            font-size: 0.7rem;
            vertical-align: middle;
        }
        .dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .mobile-menu.active {
            max-height: calc(var(--vh, 1vh) * 100);
            overflow-y: auto;
        }
        .mobile-menu .nav-item {
            display: flex;
            width: 100%;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0;
            min-width: auto;
            text-align: left;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
        }
        .mobile-menu .nav-item:not(:last-child)::after {
            display: none;
        }
        .mobile-menu .nav-item-main {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-start;
            flex-shrink: 0;
            padding-left: 8px;
        }
        .mobile-menu .nav-item-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            min-width: 20px;
        }
        .mobile-menu .nav-item-sub {
            margin-left: 12px;
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        /* モバイルドロップダウンメニュー内のアイコンをさらに右にずらす（サブメニューであることを視覚的に明確にする） */
        html body .mobile-menu .mobile-dropdown-menu .nav-item {
            padding-left: 32px !important;
        }
        html body .mobile-menu .mobile-dropdown-menu .nav-item-main {
            padding-left: 12px !important;
        }
        /* モバイルドロップダウン */
        .mobile-dropdown {
            border-bottom: 1px solid #e5e7eb;
        }
        .mobile-dropdown-toggle {
            cursor: pointer;
            user-select: none;
        }
        .mobile-dropdown-menu {
            display: none;
            background-color: #f9fafb;
        }
        .mobile-dropdown.active .mobile-dropdown-menu {
            display: block;
        }
        .mobile-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        .nav-item {
            text-decoration: none;
            color: #4b5563;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
            position: relative;
            min-width: 100px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            max-width: 100%;
            box-sizing: border-box;
        }
        /* PC表示時のみ、メニュー項目の幅を均等に */
        @media (min-width: 769px) {
            .header .nav-menu > .nav-item {
                flex: 1;
                min-width: 0;
            }
            .header .nav-menu > .dropdown {
                flex: 1;
                min-width: 0;
                display: flex;
                justify-content: center;
            }
            .header .nav-menu > .dropdown > .nav-item {
                flex: 1;
                width: 100%;
            }
        }
        .nav-item:hover {
            background-color: #f3f4f6;
            color: #1160E6;
        }
        .nav-item.active {
            background-color: #1160E6;
            color: #fff;
            font-weight: 600;
        }
        .nav-item.active:hover {
            background-color: #0346b0;
        }
        .nav-item-main {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .nav-item-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: inline-block;
        }
        .nav-item-sub {
            display: block;
            font-size: 0.7rem;
            margin-top: 2px;
            opacity: 0.8;
            font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        }
        .nav-links {
            position: absolute;
            top: 24px;
            right: 20px;
            display: flex;
            gap: 12px;
            align-items: center;
            z-index: 100;
        }
        .nav-link {
            color: #1160E6;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
            cursor: pointer;
            display: inline-block;
            position: relative;
            pointer-events: auto;
        }
        .nav-link:hover {
            background-color: #f0f4ff;
        }
        a.nav-link {
            text-decoration: none;
            color: #1160E6;
        }
        a.nav-link:hover {
            text-decoration: none;
            color: #1160E6;
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
        :root {
            --vh: 1vh;
            --safe-area-inset-bottom: env(safe-area-inset-bottom, 0px);
        }
        .main-content {
            min-height: calc(var(--vh, 1vh) * 100 - 200px);
            padding: 40px 20px 120px 20px;
        }
        /* スマホ表示時の認証ボタンブロック（デスクトップでは非表示） */
        .mobile-auth-block {
            display: none;
        }
        .mobile-auth-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background-color: #ffffffe6;
            box-shadow: 0 2px 8px rgba(180,180,180,0.05);
        }
        .mobile-auth-links .nav-link,
        .mobile-auth-links .nav-link-btn {
            padding: 6px 12px;
            font-size: 0.9rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }
        .mobile-auth-links .nav-link {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.25);
        }
        .mobile-auth-links .nav-link-btn {
            background: linear-gradient(135deg, #1160E6 0%, #0d4fc7 100%);
            color: #fff;
            box-shadow: 0 2px 4px rgba(17, 96, 230, 0.25);
            border: none;
            cursor: pointer;
        }
        .mobile-auth-links span.nav-link {
            background: transparent;
            color: #1160E6;
            box-shadow: none;
        }
        .footer {
            width: 100%;
            background-color: #ffffffe6;
            padding: 12px 0 6px;
            padding-bottom: calc(6px + var(--safe-area-inset-bottom));
            box-shadow: 0 -2px 8px rgba(180,180,180,0.05);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            transform: translateY(0);
            will-change: transform;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .ad-slider {
            position: relative;
            width: 100%;
            height: 76px;
            overflow: hidden;
            border-radius: 8px;
            background-color: #f3f4f6;
        }
        .ad-slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }
        .ad-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ad-slide a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            text-decoration: none;
        }
        .ad-slide img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
        }
        .ad-indicators {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        .ad-slider {
            padding-bottom: 4px;
        }
        .ad-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .ad-indicator.active {
            background-color: #1160E6;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 15px 5px 100px 5px;
            }
            /* スマホ表示時：認証ボタンブロックを表示、ヘッダー内のnav-linksを非表示 */
            .mobile-auth-block {
                display: block !important;
            }
            .header .nav-links,
            html body .header .nav-links,
            html body .header > .nav-links {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
            html body .header {
                padding: 24px 0 0px 0 !important;
            }
            html body .header .logo-section {
                margin-bottom: 0 !important;
            }
            .ad-slider {
                height: 66px;
                padding-bottom: 4px;
            }
            .ad-indicator {
                width: 6px;
                height: 6px;
            }
            .footer {
                padding: 10px 0 4px;
                padding-bottom: calc(4px + var(--safe-area-inset-bottom));
            }
            
            /* スマホ表示時のヘッダーレイアウト */
            .header .header-content {
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                padding: 0 16px !important;
            }
            
            /* スマホ表示時：アイコン、タイトル、ハンバーガーメニューの順に配置 */
            .header .logo-section {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                position: relative !important;
                margin: 0 !important;
                padding: 12px 0 12px 0 !important;
                gap: 8px !important;
            }
            
            .header .hamburger-btn {
                display: flex !important;
                position: static !important;
                order: 3 !important;
                margin: 0 !important;
                padding: 8px !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            .header .logo-link {
                display: flex !important;
                align-items: flex-start !important;
                justify-content: flex-start !important;
                gap: 8px !important;
                flex: 1 !important;
                min-width: 0 !important;
            }
            .header .logo-image {
                height: 28px !important;
                width: auto !important;
                flex-shrink: 0 !important;
                margin-top: 0.1em !important;
            }
            .header .logo-text-wrapper {
                display: flex !important;
                flex-direction: column !important;
                min-width: 0 !important;
                flex: 1 !important;
            }
            .header .logo-main {
                font-size: 1.1rem !important;
                line-height: 1.2 !important;
                display: block !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
            
            .header .logo-sub {
                font-size: 0.7rem !important;
                display: block !important;
                margin-top: 2px !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
            
            /* ログインボタンとユーザー名：header-contentの下に完全に切り分けたブロックとして配置 */
            html body .header > .nav-links {
                position: static !important;
                top: auto !important;
                right: auto !important;
                left: auto !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                padding: 8px 16px !important;
                margin: 0 !important;
                gap: 4px !important;
                flex-wrap: nowrap !important;
                z-index: auto !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            
            .header .nav-link,
            .header .nav-link-btn {
                padding: 4px 8px !important;
                font-size: 0.65rem !important;
                border-radius: 8px !important;
                white-space: nowrap !important;
            }
            
            /* ユーザー名（span.nav-link）は緑背景にしない */
            .header span.nav-link {
                border-radius: 4px !important;
                background-color: transparent !important;
                color: #1160E6 !important;
                transition: background-color 0.2s !important;
            }
            
            .header span.nav-link:hover {
                background-color: #f0f4ff !important;
                color: #1160E6 !important;
            }
            
            /* ログインボタン（a.nav-link）は緑色の背景 */
            .header a.nav-link {
                border-radius: 8px !important;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                box-shadow: 0 2px 4px rgba(16, 185, 129, 0.25) !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                font-weight: 500 !important;
                color: #fff !important;
            }
            
            .header a.nav-link:hover {
                background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
                box-shadow: 0 3px 8px rgba(16, 185, 129, 0.35) !important;
                transform: translateY(-1px) scale(1.02) !important;
                color: #fff !important;
            }
            
            /* 新規登録ボタン：青色の背景 */
            .header .nav-link-btn {
                border-radius: 8px !important;
                background: linear-gradient(135deg, #1160E6 0%, #0d4fc7 100%) !important;
                box-shadow: 0 2px 4px rgba(17, 96, 230, 0.25) !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                font-weight: 500 !important;
            }
            
            .header .nav-link-btn:hover {
                background: linear-gradient(135deg, #0346b0 0%, #023a9e 100%) !important;
                box-shadow: 0 3px 8px rgba(17, 96, 230, 0.35) !important;
                transform: translateY(-1px) scale(1.02) !important;
            }
            
            .header .nav-link span,
            .header .nav-link-btn span {
                font-size: 0.55rem !important;
                line-height: 1.2 !important;
                display: inline !important;
                white-space: nowrap !important;
            }
            
            /* ボタン内のspanを1行で表示 */
            .header .nav-link span.block,
            .header .nav-link-btn span.block {
                display: inline !important;
            }
            
            /* ハンバーガーメニューの縦位置を「就労支援」の漢字に合わせる */
            .header .hamburger-btn {
                align-items: center !important;
                justify-content: center !important;
            }
            
            .header .nav-menu {
                display: none !important;
            }
            
            .header .mobile-menu {
                display: block !important;
            }
        }
        @media (max-width: 1280px) {
            html body .header .nav-links {
                position: static !important;
                justify-content: center !important;
                margin-bottom: 16px !important;
                flex-wrap: wrap !important;
                top: auto !important;
                right: auto !important;
            }
            html body .header {
                padding: 16px 0 !important;
            }
            html body .header .logo-section {
                justify-content: center !important;
                padding: 0 20px 0 60px !important;
                margin-bottom: 0 !important;
                text-align: center !important;
                position: relative !important;
            }
            html body .header .logo-main {
                font-size: 1.5rem !important;
                line-height: 1.2 !important;
            }
            html body .header .logo-link {
                align-items: flex-start !important;
            }
            html body .header .logo-image {
                margin-top: 0.1em !important;
            }
            html body .header .hamburger-btn {
                display: flex !important;
            }
            html body .header .nav-menu {
                display: none !important;
            }
            html body .header .mobile-menu {
                display: block !important;
            }
        }
        
        /* メニューが収まらない場合のハンバーガーメニュー切り替え用クラス */
        .header.menu-overflow .nav-menu {
            display: none !important;
        }
        
        .header.menu-overflow .hamburger-btn {
            display: flex !important;
        }
        
        .header.menu-overflow .mobile-menu {
            display: block;
        }
        @media (max-width: 550px) {
            .logo-main {
                font-size: 1.25rem;
            }
        }
    </style>
    {{-- フォント読み込み最適化: 非ブロッキングで読み込み（FCP改善） --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet"></noscript>
    @stack('styles')
    <style>
        /* ヘッダーエリアを完全に分離・保護 - コンテンツ部分のスタイルが一切影響しないように */
        html body .header {
            width: 100% !important;
            max-width: 100% !important;
            min-height: auto !important;
            height: auto !important;
            margin: 0 !important;
            padding: 24px 0 0px 0 !important;
            box-sizing: border-box !important;
            display: block !important;
            position: relative !important;
            overflow: visible !important;
            background-color: #ffffffe6 !important;
            box-shadow: 0 2px 8px rgba(180,180,180,0.05) !important;
        }
        
        html body .header .header-content {
            max-width: 1200px !important;
            width: 100% !important;
            min-height: auto !important;
            height: auto !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
            display: block !important;
            overflow: visible !important;
        }
        
        html body .header .nav-links {
            position: absolute !important;
            top: 24px !important;
            right: 20px !important;
            display: flex !important;
            gap: 12px !important;
            align-items: center !important;
            z-index: 100 !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
        }
        
        html body .header .logo-section {
            text-align: center !important;
            margin-bottom: 0 !important;
            margin-top: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            position: relative !important;
            min-height: auto !important;
            height: auto !important;
            padding: 0 !important;
            box-sizing: border-box !important;
            line-height: normal !important;
        }
        
        html body .header .logo-link {
            display: flex !important;
            align-items: flex-start !important;
            gap: 12px !important;
            text-decoration: none !important;
            color: inherit !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        html body .header .logo-image {
            height: 40px !important;
            width: auto !important;
            flex-shrink: 0 !important;
            margin-top: 0.1em !important;
        }
        html body .header .logo-text-wrapper {
            display: flex !important;
            flex-direction: column !important;
            line-height: 1.2 !important;
        }
        
        html body .header .nav-menu {
            max-width: 100% !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            flex-wrap: nowrap !important;
            margin: 0 !important;
            padding-top: 12px !important;
            padding-bottom: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            min-height: auto !important;
            height: auto !important;
            line-height: normal !important;
        }
        
        html body .header .nav-item {
            margin: 0 !important;
            padding: 8px 16px !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
            line-height: normal !important;
            font-size: 0.9rem !important;
        }
        
        html body .header .nav-item-main {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            line-height: normal !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        html body .header .nav-item-icon {
            width: 18px !important;
            height: 18px !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
        }
        
        html body .header .nav-item-sub {
            display: block !important;
            font-size: 0.7rem !important;
            margin-top: 2px !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            line-height: normal !important;
            opacity: 0.8 !important;
        }
        
        /* ユーザー名（span.nav-link）は緑背景にしない */
        html body .header span.nav-link {
            margin: 0 !important;
            padding: 6px 12px !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
            display: inline-block !important;
            font-size: 0.9rem !important;
            color: #1160E6 !important;
            text-decoration: none !important;
            border-radius: 4px !important;
            transition: background-color 0.2s !important;
            cursor: pointer !important;
            position: relative !important;
            pointer-events: auto !important;
            border: none !important;
            background-color: transparent !important;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif !important;
            line-height: normal !important;
            vertical-align: baseline !important;
        }
        
        /* ログインボタン（a.nav-link）は緑背景 */
        html body .header a.nav-link {
            margin: 0 !important;
            padding: 6px 12px !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
            display: inline-block !important;
            font-size: 0.9rem !important;
            color: #fff !important;
            text-decoration: none !important;
            border-radius: 8px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer !important;
            position: relative !important;
            pointer-events: auto !important;
            border: none !important;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.25) !important;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif !important;
            line-height: normal !important;
            vertical-align: baseline !important;
            font-weight: 500 !important;
        }
        
        html body .header a.nav-link:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            box-shadow: 0 3px 8px rgba(16, 185, 129, 0.35) !important;
            transform: translateY(-1px) scale(1.02) !important;
            color: #fff !important;
        }
        
        html body .header .nav-link-btn,
        html body .header button.nav-link-btn,
        html body .header form .nav-link-btn,
        html body .header a.nav-link-btn {
            margin: 0 !important;
            padding: 6px 12px !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
            display: inline-block !important;
            font-size: 0.9rem !important;
            color: #fff !important;
            text-decoration: none !important;
            border-radius: 4px !important;
            transition: background-color 0.2s !important;
            cursor: pointer !important;
            position: relative !important;
            pointer-events: auto !important;
            border: none !important;
            background-color: #1160E6 !important;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif !important;
            line-height: normal !important;
            vertical-align: baseline !important;
        }
        
        html body .header .nav-link-btn:hover,
        html body .header button.nav-link-btn:hover,
        html body .header form .nav-link-btn:hover,
        html body .header a.nav-link-btn:hover {
            background-color: #0346b0 !important;
            color: #fff !important;
        }
        
        /* PC表示時も1行で表示、日本語とネパール語の間に「 / 」を追加 */
        html body .header .nav-link span,
        html body .header .nav-link-btn span,
        html body .header button.nav-link-btn span,
        html body .header form .nav-link-btn span,
        html body .header a.nav-link-btn span,
        html body .header .nav-link span.inline-text,
        html body .header .nav-link-btn span.inline-text,
        html body .header button.nav-link-btn span.inline-text,
        html body .header form .nav-link-btn span.inline-text,
        html body .header a.nav-link-btn span.inline-text {
            display: inline !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: normal !important;
            font-size: 0.7rem !important;
            opacity: 0.9 !important;
            white-space: nowrap !important;
        }
        
        html body .header .nav-links form {
            display: inline !important;
            margin: 0 !important;
            padding: 0 !important;
            line-height: normal !important;
        }
        
        html body .header .nav-links form button {
            margin: 0 !important;
            padding: 6px 12px !important;
            line-height: normal !important;
        }
        
        html body .header .hamburger-btn {
            margin: 0 !important;
            padding: 8px !important;
            min-height: auto !important;
            height: auto !important;
            box-sizing: border-box !important;
        }
        
        /* スマホ表示時のボタンスタイル（保護スタイルの後に読み込まれるため、確実に適用される） */
        @media (max-width: 768px) {
            html body .header .nav-link,
            html body .header a.nav-link {
                padding: 3px 8px !important;
                font-size: 0.7rem !important;
                border-radius: 6px !important;
            }
            
            html body .header .nav-link-btn,
            html body .header button.nav-link-btn,
            html body .header form .nav-link-btn,
            html body .header a.nav-link-btn {
                padding: 4px 12px !important;
                font-size: 0.7rem !important;
                border-radius: 10px !important;
                background: linear-gradient(135deg, #1160E6 0%, #0d4fc7 100%) !important;
                box-shadow: 0 2px 6px rgba(17, 96, 230, 0.3) !important;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
                font-weight: 500 !important;
            }
            
            html body .header .nav-link-btn:hover,
            html body .header button.nav-link-btn:hover,
            html body .header form .nav-link-btn:hover,
            html body .header a.nav-link-btn:hover {
                background: linear-gradient(135deg, #0346b0 0%, #023a9e 100%) !important;
                box-shadow: 0 4px 12px rgba(17, 96, 230, 0.4) !important;
                transform: translateY(-1px) scale(1.02) !important;
            }
            
            html body .header .nav-link span,
            html body .header .nav-link-btn span,
            html body .header button.nav-link-btn span,
            html body .header form .nav-link-btn span,
            html body .header a.nav-link-btn span {
                font-size: 0.6rem !important;
                line-height: 1.3 !important;
            }
            
            /* ボタン内のspanを1行で表示 */
            html body .header .nav-link span.block,
            html body .header .nav-link-btn span.block {
                display: inline !important;
            }
        }
        
        html body .header .logo-main {
            font-size: 2rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: auto !important;
            height: auto !important;
            line-height: 1.2 !important;
            letter-spacing: 0.07em !important;
            display: block !important;
        }
        
        html body .header .logo-sub {
            font-size: 0.92rem !important;
            margin-top: 2px !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            min-height: auto !important;
            height: auto !important;
            line-height: normal !important;
            display: block !important;
        }
        
        /* Tailwind CSSやその他のスタイルがヘッダーに影響しないように完全に保護 */
        html body .header * {
            box-sizing: border-box !important;
        }
        
        /* 画面幅が480px以下のスマホ表示時のみ適用 - 最優先で適用 */
        @media screen and (max-width: 480px) {
            html body .header .logo-main {
                font-size: 1.5rem !important;
            }
        }
    </style>
    
    {{-- Structured Data (JSON-LD) --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => '就労支援サービス',
        'alternateName' => 'रोजगार सहायता सेवा',
        'url' => url('/'),
        'logo' => asset('images/logo.webp'),
        'description' => '日本で生活・就労するネパール人の方向けの就労支援サービス。ビザ・家族・転職・永住・役所の手続き、履歴書・職務経歴書作成、就職・アルバイト情報、賃貸・SIM・ネット回線情報などを提供しています。',
        'sameAs' => [],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'availableLanguage' => ['Japanese', 'Nepali'],
        ],
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'Japan',
        ],
        'audience' => [
            '@type' => 'Audience',
            'audienceType' => 'Nepali people living in Japan',
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @yield('structured_data')
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="メニュー">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a href="{{ route('home') }}" class="logo-link">
                    <img src="{{ asset('images/logo.webp') }}" alt="就労支援サービス" class="logo-image" loading="eager" width="40" height="40">
                    <span class="logo-text-wrapper">
                        <span class="logo-main">就労支援サービス</span>
                    <span class="logo-sub">रोजगार सहायता सेवा</span>
                </span>
                </a>
            </div>
            <nav class="nav-menu" id="desktopMenu">
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        トップページ
                    </span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="{{ route('admin-procedures.index') }}" class="nav-item {{ request()->routeIs('admin-procedures.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {{-- 行政手続き用アイコン（庁舎ビルのイメージ） --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 21h18M5 21V10a1 1 0 011-1h4v12M14 21V5a1 1 0 011-1h3a1 1 0 011 1v16M9 13h1M9 16h1M9 19h1M16 8h1M16 11h1M16 14h1M16 17h1" />
                        </svg>
                        行政手続き
                    </span>
                    <span class="nav-item-sub">प्रशासनिक प्रक्रिया</span>
                </a>
                <a href="{{ route('remittance') }}" class="nav-item {{ request()->routeIs('remittance') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        送金
                    </span>
                    <span class="nav-item-sub">रेमिटेन्स</span>
                </a>
                <div class="dropdown">
                    <div class="nav-item dropdown-toggle {{ request()->routeIs('rental') || request()->routeIs('internet') || request()->routeIs('sim') || request()->routeIs('campaign') || request()->routeIs('parttime') || request()->routeIs('job') ? 'active' : '' }}">
                        <span class="nav-item-main">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            生活サポート<span class="dropdown-arrow">▼</span>
                        </span>
                        <span class="nav-item-sub">जीवन सहायता</span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('parttime') }}" class="dropdown-item {{ request()->routeIs('parttime') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>アルバイト / अंशकालिक</span>
                        </a>
                        <a href="{{ route('job') }}" class="dropdown-item {{ request()->routeIs('job') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>就職 / रोजगार</span>
                        </a>
                        <a href="{{ route('rental') }}" class="dropdown-item {{ request()->routeIs('rental') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>賃貸 / भाडा</span>
                        </a>
                        <a href="{{ route('internet') }}" class="dropdown-item {{ request()->routeIs('internet') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                            </svg>
                            <span>ネット回線 / इन्टरनेट</span>
                        </a>
                        <a href="{{ route('sim') }}" class="dropdown-item {{ request()->routeIs('sim') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>SIM / सिम</span>
                        </a>
                        <a href="{{ route('campaign') }}" class="dropdown-item {{ request()->routeIs('campaign') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                            <span>キャンペーン / अभियान</span>
                        </a>
                    </div>
                </div>
                <div class="dropdown">
                    <div class="nav-item dropdown-toggle {{ request()->routeIs('resume.*') || request()->routeIs('career-history.*') || request()->routeIs('work-permit') ? 'active' : '' }}">
                        <span class="nav-item-main">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            書類作成<span class="dropdown-arrow">▼</span>
                        </span>
                        <span class="nav-item-sub">कागजात निर्माण</span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ route('resume.index') }}" class="dropdown-item {{ request()->routeIs('resume.*') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>履歴書 / बायोडाटा</span>
                        </a>
                        <a href="{{ route('career-history.index') }}" class="dropdown-item {{ request()->routeIs('career-history.*') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>職務経歴書 / कामको अनुभव</span>
                        </a>
                        <a href="{{ route('work-permit') }}" class="dropdown-item {{ request()->routeIs('work-permit') ? 'active' : '' }}">
                            <svg class="dropdown-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>資格外活動許可申請書 / कामको अनुमति</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('contact.create') }}" class="nav-item {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        お問い合わせ
                    </span>
                    <span class="nav-item-sub">सम्पर्क</span>
                </a>
            </nav>
            <nav class="mobile-menu" id="mobileMenu">
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        トップページ
                    </span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="{{ route('admin-procedures.index') }}" class="nav-item {{ request()->routeIs('admin-procedures.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {{-- 行政手続き用アイコン（庁舎ビルのイメージ） --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 21h18M5 21V10a1 1 0 011-1h4v12M14 21V5a1 1 0 011-1h3a1 1 0 011 1v16M9 13h1M9 16h1M9 19h1M16 8h1M16 11h1M16 14h1M16 17h1" />
                        </svg>
                        行政手続き
                    </span>
                    <span class="nav-item-sub">प्रशासनिक प्रक्रिया</span>
                </a>
                <a href="{{ route('remittance') }}" class="nav-item {{ request()->routeIs('remittance') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        送金
                    </span>
                    <span class="nav-item-sub">रेमिटेन्स</span>
                </a>
                <div class="mobile-dropdown">
                    <div class="nav-item mobile-dropdown-toggle">
                        <span class="nav-item-main">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            生活サポート<span class="dropdown-arrow">▼</span>
                        </span>
                        <span class="nav-item-sub">जीवन सहायता</span>
                    </div>
                    <div class="mobile-dropdown-menu">
                        <a href="{{ route('parttime') }}" class="nav-item {{ request()->routeIs('parttime') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                アルバイト
                            </span>
                            <span class="nav-item-sub">अंशकालिक</span>
                        </a>
                        <a href="{{ route('job') }}" class="nav-item {{ request()->routeIs('job') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                就職
                            </span>
                            <span class="nav-item-sub">रोजगार</span>
                        </a>
                        <a href="{{ route('rental') }}" class="nav-item {{ request()->routeIs('rental') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                賃貸
                            </span>
                            <span class="nav-item-sub">भाडा</span>
                        </a>
                        <a href="{{ route('internet') }}" class="nav-item {{ request()->routeIs('internet') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                </svg>
                                ネット回線
                            </span>
                            <span class="nav-item-sub">इन्टरनेट</span>
                        </a>
                        <a href="{{ route('sim') }}" class="nav-item {{ request()->routeIs('sim') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                SIM
                            </span>
                            <span class="nav-item-sub">सिम</span>
                        </a>
                        <a href="{{ route('campaign') }}" class="nav-item {{ request()->routeIs('campaign') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                                キャンペーン
                            </span>
                            <span class="nav-item-sub">अभियान</span>
                        </a>
                    </div>
                </div>
                <div class="mobile-dropdown">
                    <div class="nav-item mobile-dropdown-toggle">
                        <span class="nav-item-main">
                            <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            書類作成<span class="dropdown-arrow">▼</span>
                        </span>
                        <span class="nav-item-sub">कागजात निर्माण</span>
                    </div>
                    <div class="mobile-dropdown-menu">
                        <a href="{{ route('resume.index') }}" class="nav-item {{ request()->routeIs('resume.*') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                履歴書
                            </span>
                            <span class="nav-item-sub">बायोडाटा</span>
                        </a>
                        <a href="{{ route('career-history.index') }}" class="nav-item {{ request()->routeIs('career-history.*') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                職務経歴書
                            </span>
                            <span class="nav-item-sub">कामको अनुभव</span>
                        </a>
                        <a href="{{ route('work-permit') }}" class="nav-item {{ request()->routeIs('work-permit') ? 'active' : '' }}" style="padding-left: 32px;">
                            <span class="nav-item-main">
                                <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                資格外活動許可申請書
                            </span>
                            <span class="nav-item-sub">कामको अनुमति</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('contact.create') }}" class="nav-item {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        お問い合わせ
                    </span>
                    <span class="nav-item-sub">सम्पर्क</span>
                </a>
            </nav>
        </div>
        <div class="nav-links">
            @auth
                @if(Auth::user()->email === 'info@hamro-life-japan.com')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-btn" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">管理者画面 <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ व्यवस्थापन प्यानल</span></a>
                    <span class="nav-link">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link-btn">ログアウト <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ लगआउट</span></button>
                    </form>
                @else
                    <span class="nav-link">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link-btn">ログアウト <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ लगआउट</span></button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-link" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">ログイン <span class="inline-text" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">/ लगइन</span></a>
                <a href="{{ route('register') }}" class="nav-link-btn" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">新規登録 <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ दर्ता</span></a>
            @endauth
        </div>
    </header>
    <!-- スマホ表示時の認証ボタンブロック -->
    <div class="mobile-auth-block">
        <div class="mobile-auth-links">
            @auth
                @if(Auth::user()->email === 'info@hamro-life-japan.com')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-btn" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">管理者画面 <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ व्यवस्थापन प्यानल</span></a>
                    <span class="nav-link">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link-btn">ログアウト <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ लगआउट</span></button>
                    </form>
                @else
                    <span class="nav-link">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link-btn">ログアウト <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ लगआउट</span></button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="nav-link" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">ログイン <span class="inline-text" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">/ लगइन</span></a>
                <a href="{{ route('register') }}" class="nav-link-btn" style="display: inline-block; text-decoration: none; cursor: pointer; pointer-events: auto;">新規登録 <span class="inline-text" style="font-size: 0.7rem; opacity: 0.9;">/ दर्ता</span></a>
            @endauth
        </div>
    </div>
    <main class="main-content">
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer-content">
            <div class="ad-slider">
                @php
                    $slideIndex = 0;
                    $hasVinayaka = file_exists(public_path('images/ads/vinayaka.webp'));
                    $hasAd1 = file_exists(public_path('images/ads/ad1.webp'));
                    $hasAd2 = file_exists(public_path('images/ads/ad2.webp'));
                    $hasAd3 = file_exists(public_path('images/ads/ad3.jpg'));
                    $hasAd4 = file_exists(public_path('images/ads/ad4.jpg'));
                @endphp
                <div class="ad-slides" id="adSlides">
                    @if($hasVinayaka)
                    <div class="ad-slide">
                        <a href="https://tabelog.com/fukuoka/A4001/A400202/40057305/" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('images/ads/vinayaka.webp') }}" alt="VINAYAKA ネパール＆インドレストラン">
                        </a>
                    </div>
                    @endif
                    @if($hasAd1)
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad1.webp') }}" alt="広告募集" loading="lazy" onerror="this.src='https://via.placeholder.com/1200x120/0346b0/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                    <div class="ad-slide">
                        {!! '<a href="https://rpx.a8.net/svt/ejp?a8mat=45KOC7+DTQEIA+2HOM+62U35&rakuten=y&a8ejpredirect=http%3A%2F%2Fhb.afl.rakuten.co.jp%2Fhgc%2F0ea62065.34400275.0ea62066.204f04c0%2Fa25122762590_45KOC7_DTQEIA_2HOM_62U35%3Fpc%3Dhttp%253A%252F%252Fwww.rakuten.co.jp%252F%26m%3Dhttp%253A%252F%252Fm.rakuten.co.jp%252F" rel="nofollow">
<img src="http://hbb.afl.rakuten.co.jp/hsb/0eb4bbdb.d3e5aa19.0eb4bbaa.95151395/" border="0"></a>
<img border="0" width="1" height="1" src="https://www17.a8.net/0.gif?a8mat=45KOC7+DTQEIA+2HOM+62U35" alt="">' !!}
                    </div>
                    @if($hasAd2)
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad2.webp') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/0346b0/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                    @if($hasAd3)
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad3.jpg') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/3E5387/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                    @if($hasAd4)
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad4.jpg') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/6b7280/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                </div>
                <div class="ad-indicators" id="adIndicators">
                    @if($hasVinayaka)
                    <span class="ad-indicator active" data-slide="0"></span>
                    @endif
                    @if($hasAd1)
                    <span class="ad-indicator {{ !$hasVinayaka ? 'active' : '' }}" data-slide="1"></span>
                    @endif
                    <span class="ad-indicator {{ !$hasVinayaka && !$hasAd1 ? 'active' : '' }}" data-slide="2"></span>
                    @if($hasAd2)
                    <span class="ad-indicator" data-slide="3"></span>
                    @endif
                    @if($hasAd3)
                    <span class="ad-indicator" data-slide="4"></span>
                    @endif
                    @if($hasAd4)
                    <span class="ad-indicator" data-slide="5"></span>
                    @endif
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const desktopMenu = document.getElementById('desktopMenu');
            const header = document.querySelector('.header');
            
            // メニューが収まらないかチェックする関数
            function checkMenuOverflow() {
                if (!desktopMenu || !header) return;
                
                // 1280px以下の場合は常にハンバーガーメニュー
                if (window.innerWidth <= 1280) {
                    header.classList.add('menu-overflow');
                    return;
                }
                
                // デスクトップメニューを一時的に表示してチェック
                const originalDisplay = desktopMenu.style.display;
                desktopMenu.style.display = 'flex';
                
                // 直接の子要素（.nav-itemと.dropdown）を取得
                const menuItems = Array.from(desktopMenu.children);
                let totalWidth = 0;
                menuItems.forEach(item => {
                    totalWidth += item.offsetWidth;
                });
                
                const menuContainer = desktopMenu.parentElement;
                const availableWidth = menuContainer.offsetWidth - 40; // padding分を考慮
                
                // 元の表示状態に戻す
                desktopMenu.style.display = originalDisplay || '';
                
                // メニューが収まらない場合はハンバーガーメニューに切り替え
                if (totalWidth > availableWidth) {
                    header.classList.add('menu-overflow');
                } else {
                    header.classList.remove('menu-overflow');
                }
            }
            
            // 初回チェック
            checkMenuOverflow();
            
            // リサイズ時にチェック
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(checkMenuOverflow, 100);
            });
            
            // デスクトップドロップダウンの制御
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const dropdown = this.closest('.dropdown');
                    if (!dropdown) {
                        console.error('Dropdown not found');
                        return;
                    }
                    
                    const isActive = dropdown.classList.contains('active');
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                    
                    // 他のドロップダウンを閉じる
                    document.querySelectorAll('.dropdown').forEach(d => {
                        if (d !== dropdown) {
                            d.classList.remove('active');
                        }
                    });
                    
                    // クリックしたドロップダウンを開閉
                    if (isActive) {
                        dropdown.classList.remove('active');
                    } else {
                        dropdown.classList.add('active');
                    }
                });
            });
            
            // ドロップダウン外をクリックしたら閉じる
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown').forEach(d => {
                        d.classList.remove('active');
                    });
                }
            });
            
            if (hamburgerBtn && mobileMenu) {
                hamburgerBtn.addEventListener('click', function() {
                    hamburgerBtn.classList.toggle('active');
                    mobileMenu.classList.toggle('active');
                });
                
                // モバイルドロップダウンの制御
                document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        const dropdown = this.closest('.mobile-dropdown');
                        dropdown.classList.toggle('active');
                    });
                });
                
                // メニュー項目（リンク）をクリックしたらメニューを閉じる
                const menuLinks = mobileMenu.querySelectorAll('.nav-item[href]');
                menuLinks.forEach(item => {
                    item.addEventListener('click', function() {
                        hamburgerBtn.classList.remove('active');
                        mobileMenu.classList.remove('active');
                    });
                });
            }

            // 広告スライドショー
            const adSlides = document.getElementById('adSlides');
            const adIndicators = document.getElementById('adIndicators');
            
            if (adSlides && adIndicators) {
            const indicators = adIndicators.querySelectorAll('.ad-indicator');
            let currentSlide = 0;
            const totalSlides = indicators.length;
                
                if (totalSlides > 0) {
                    const slideInterval = 8000; // 8秒ごとにスライド

            function showSlide(index) {
                        if (adSlides && index >= 0 && index < totalSlides) {
                adSlides.style.transform = `translateX(-${index * 100}%)`;
                        }
                
                // インジケーターを更新
                indicators.forEach((indicator, i) => {
                    if (i === index) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }

            function nextSlide() {
                        if (totalSlides > 0) {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
                        }
            }

            // インジケーターをクリックしたらそのスライドに移動
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    currentSlide = index;
                    showSlide(currentSlide);
                });
            });

                    // 自動スライド（複数スライドがある場合のみ）
                    if (totalSlides > 1) {
            setInterval(nextSlide, slideInterval);
                    }
                }
            }
        });

        // iPhoneのビューポート高さの変動に対応
        function setViewportHeight() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
            
            // フッターの位置を確実に最下部に固定
            const footer = document.querySelector('.footer');
            if (footer) {
                footer.style.bottom = '0';
                footer.style.transform = 'translateY(0)';
            }
        }

        // 初回設定（DOMContentLoadedとloadの両方で実行）
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setViewportHeight);
        } else {
            setViewportHeight();
        }
        window.addEventListener('load', setViewportHeight);

        // リサイズ時とスクロール時に更新（iPhoneのアドレスバー非表示時に対応）
        let lastHeight = window.innerHeight;
        let ticking = false;

        function updateViewportHeight() {
            const currentHeight = window.innerHeight;
            if (currentHeight !== lastHeight) {
                lastHeight = currentHeight;
                setViewportHeight();
            }
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateViewportHeight);
                ticking = true;
            }
        }

        window.addEventListener('resize', requestTick);
        window.addEventListener('scroll', requestTick);
        window.addEventListener('touchmove', requestTick);
        window.addEventListener('touchend', requestTick);

        // オリエンテーション変更時にも更新
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                setViewportHeight();
                // 複数回実行して確実に更新
                setTimeout(setViewportHeight, 200);
                setTimeout(setViewportHeight, 500);
            }, 100);
        });

        // 定期的にも更新（念のため）
        setInterval(setViewportHeight, 500);

        // FOUCを防ぐ: ページ読み込み完了時に表示（FCPを早めるため改善）
        (function() {
            function showPage() {
                document.documentElement.classList.remove('loading');
                document.documentElement.classList.add('loaded');
            }
            
            // 初期状態をloadingに設定（FCPを早めるため、すぐに表示）
            if (document.readyState === 'loading') {
                document.documentElement.classList.add('loading');
                document.addEventListener('DOMContentLoaded', showPage);
            } else {
                // DOMContentLoadedが既に発火している場合
                showPage();
            }
            
            // フォールバック: 一定時間経過後も表示（短縮してFCPを早める）
            setTimeout(showPage, 50);
        })();
    </script>
</body>
</html>

