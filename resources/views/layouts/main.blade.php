<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '就労支援サービス')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <style>
        body {
            background-color: #f6f7fa;
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', 'Noto Sans Devanagari', Arial, sans-serif;
            color: #222;
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
        }
        .header .header-content {
            max-width: 1200px !important;
            width: 100% !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
        }
        .header .nav-menu {
            display: flex !important;
            justify-content: center !important;
            gap: 0 !important;
            flex-wrap: nowrap !important;
            border-top: 1px solid #e5e7eb !important;
            padding-top: 12px !important;
            overflow: hidden !important;
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
            flex-shrink: 0;
            margin-top: 0.1em;
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
        .logo-text-wrapper {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .logo-main {
            line-height: 1.2;
        }
        .logo-sub {
            display: block;
            font-size: 0.92rem;
            color: #888;
            margin-top: 2px;
        }
        .logo-image {
            margin-top: 0.1em;
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
        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 0;
            flex-wrap: nowrap;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            overflow: hidden;
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
            max-height: 100vh;
            overflow-y: auto;
        }
        .mobile-menu .nav-item {
            display: block;
            width: 100%;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0;
            min-width: auto;
            text-align: left;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .mobile-menu .nav-item:not(:last-child)::after {
            display: none;
        }
        .mobile-menu .nav-item-main {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .mobile-menu .nav-item-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        .mobile-menu .nav-item-sub {
            margin-left: 12px;
            font-size: 0.75rem;
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
        }
        .nav-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 24px;
            background-color: #e5e7eb;
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
        .main-content {
            min-height: calc(100vh - 200px);
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
            padding: 12px 0;
            box-shadow: 0 -2px 8px rgba(180,180,180,0.05);
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 100;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .ad-slider {
            position: relative;
            width: 100%;
            height: 80px;
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
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
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
                height: 70px;
            }
            .ad-indicator {
                width: 6px;
                height: 6px;
            }
            .footer {
                padding: 10px 0;
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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600&family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
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
        
        /* コンテンツ部分のスタイルがヘッダーに影響しないように明示的に分離 */
        .main-content,
        .resume-container {
            /* ヘッダーとは完全に分離 */
        }
        
        /* より詳細度を上げて保護 - コンテンツ部分のスタイルがヘッダーに影響しないように */
        html body .header,
        html body .header *:not(.main-content):not(.main-content *):not(.resume-container):not(.resume-container *) {
            /* ヘッダー内の要素を保護 */
        }
        
        /* コンテンツ部分のスタイルがヘッダーに影響しないように */
        .main-content,
        .main-content *,
        .resume-container,
        .resume-container * {
            /* ヘッダーに影響を与えない */
        }
        
        /* より詳細度を上げて保護 */
        html body .header,
        html body .header *:not(.main-content):not(.main-content *) {
            /* ヘッダー内の要素を保護 */
        }
        
        /* 画面幅が480px以下のスマホ表示時のみ適用 - 最優先で適用 */
        @media screen and (max-width: 480px) {
            html body .header .logo-main {
                font-size: 1.5rem !important;
            }
        }
    </style>
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
                    <img src="{{ asset('images/logo.png') }}" alt="就労支援サービス" class="logo-image">
                    <span class="logo-text-wrapper">
                        <span class="logo-main">就労支援サービス</span>
                        <span class="logo-sub">रोजगार सहायता सेवा</span>
                    </span>
                </a>
            </div>
            <nav class="nav-menu" id="desktopMenu">
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="nav-item-main">トップページ</span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="{{ route('rental') }}" class="nav-item {{ request()->routeIs('rental') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        賃貸
                    </span>
                    <span class="nav-item-sub">भाडा</span>
                </a>
                <a href="{{ route('parttime') }}" class="nav-item {{ request()->routeIs('parttime') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        アルバイト
                    </span>
                    <span class="nav-item-sub">अंशकालिक</span>
                </a>
                <a href="{{ route('job') }}" class="nav-item {{ request()->routeIs('job') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        就職
                    </span>
                    <span class="nav-item-sub">रोजगार</span>
                </a>
                <a href="{{ route('internet') }}" class="nav-item {{ request()->routeIs('internet') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                        </svg>
                        ネット回線
                    </span>
                    <span class="nav-item-sub">इन्टरनेट</span>
                </a>
                <a href="{{ route('sim') }}" class="nav-item {{ request()->routeIs('sim') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        SIM
                    </span>
                    <span class="nav-item-sub">सिम</span>
                </a>
                <a href="{{ route('campaign') }}" class="nav-item {{ request()->routeIs('campaign') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        キャンペーン
                    </span>
                    <span class="nav-item-sub">अभियान</span>
                </a>
                <a href="{{ route('resume.index') }}" class="nav-item {{ request()->routeIs('resume.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        履歴書作成
                    </span>
                    <span class="nav-item-sub">बायोडाटा</span>
                </a>
                <a href="{{ route('career.index') }}" class="nav-item {{ request()->routeIs('career.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        職務経歴書作成
                    </span>
                    <span class="nav-item-sub">कामको अनुभव</span>
                </a>
            </nav>
            <nav class="mobile-menu" id="mobileMenu">
                <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="nav-item-main">トップページ</span>
                    <span class="nav-item-sub">मुख्य पृष्ठ</span>
                </a>
                <a href="{{ route('rental') }}" class="nav-item {{ request()->routeIs('rental') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        賃貸
                    </span>
                    <span class="nav-item-sub">भाडा</span>
                </a>
                <a href="{{ route('parttime') }}" class="nav-item {{ request()->routeIs('parttime') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        アルバイト
                    </span>
                    <span class="nav-item-sub">अंशकालिक</span>
                </a>
                <a href="{{ route('job') }}" class="nav-item {{ request()->routeIs('job') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        就職
                    </span>
                    <span class="nav-item-sub">रोजगार</span>
                </a>
                <a href="{{ route('internet') }}" class="nav-item {{ request()->routeIs('internet') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                        </svg>
                        ネット回線
                    </span>
                    <span class="nav-item-sub">इन्टरनेट</span>
                </a>
                <a href="{{ route('sim') }}" class="nav-item {{ request()->routeIs('sim') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        SIM
                    </span>
                    <span class="nav-item-sub">सिम</span>
                </a>
                <a href="{{ route('campaign') }}" class="nav-item {{ request()->routeIs('campaign') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        キャンペーン
                    </span>
                    <span class="nav-item-sub">अभियान</span>
                </a>
                <a href="{{ route('resume.index') }}" class="nav-item {{ request()->routeIs('resume.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        履歴書作成
                    </span>
                    <span class="nav-item-sub">बायोडाटा</span>
                </a>
                <a href="{{ route('career.index') }}" class="nav-item {{ request()->routeIs('career.*') ? 'active' : '' }}">
                    <span class="nav-item-main">
                        <svg class="nav-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        職務経歴書作成
                    </span>
                    <span class="nav-item-sub">कामको अनुभव</span>
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
                <div class="ad-slides" id="adSlides">
                    <div class="ad-slide">
                        {!! '<a href="https://rpx.a8.net/svt/ejp?a8mat=45KOC7+DTQEIA+2HOM+62U35&rakuten=y&a8ejpredirect=http%3A%2F%2Fhb.afl.rakuten.co.jp%2Fhgc%2F0ea62065.34400275.0ea62066.204f04c0%2Fa25122762590_45KOC7_DTQEIA_2HOM_62U35%3Fpc%3Dhttp%253A%252F%252Fwww.rakuten.co.jp%252F%26m%3Dhttp%253A%252F%252Fm.rakuten.co.jp%252F" rel="nofollow">
<img src="http://hbb.afl.rakuten.co.jp/hsb/0eb4bbdb.d3e5aa19.0eb4bbaa.95151395/" border="0"></a>
<img border="0" width="1" height="1" src="https://www17.a8.net/0.gif?a8mat=45KOC7+DTQEIA+2HOM+62U35" alt="">' !!}
                    </div>
                    @if(file_exists(public_path('images/ads/ad2.jpg')))
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad2.jpg') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/0346b0/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                    @if(file_exists(public_path('images/ads/ad3.jpg')))
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad3.jpg') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/3E5387/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                    @if(file_exists(public_path('images/ads/ad4.jpg')))
                    <div class="ad-slide">
                        <a href="{{ route('advertisement.create') }}">
                            <img src="{{ asset('images/ads/ad4.jpg') }}" alt="広告募集" onerror="this.src='https://via.placeholder.com/1200x120/6b7280/FFFFFF?text=広告募集+Advertisement+Application'">
                        </a>
                    </div>
                    @endif
                </div>
                <div class="ad-indicators" id="adIndicators">
                    <span class="ad-indicator active" data-slide="0"></span>
                    @if(file_exists(public_path('images/ads/ad2.jpg')))
                    <span class="ad-indicator" data-slide="1"></span>
                    @endif
                    @if(file_exists(public_path('images/ads/ad3.jpg')))
                    <span class="ad-indicator" data-slide="2"></span>
                    @endif
                    @if(file_exists(public_path('images/ads/ad4.jpg')))
                    <span class="ad-indicator" data-slide="3"></span>
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
                
                const menuItems = desktopMenu.querySelectorAll('.nav-item');
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
            
            if (hamburgerBtn && mobileMenu) {
                hamburgerBtn.addEventListener('click', function() {
                    hamburgerBtn.classList.toggle('active');
                    mobileMenu.classList.toggle('active');
                });
                
                // メニュー項目をクリックしたらメニューを閉じる
                const menuItems = mobileMenu.querySelectorAll('.nav-item');
                menuItems.forEach(item => {
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
    </script>
</body>
</html>

