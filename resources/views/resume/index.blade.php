@extends('layouts.main')

@section('title', '履歴書作成 - 就労支援サービス')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Tailwind CSS読み込み前にヘッダーを完全に保護 - all: revertを使わずに個別に指定 */
    html body .header {
        width: 100% !important;
        max-width: 100% !important;
        min-height: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 24px 0 16px 0 !important;
        box-sizing: border-box !important;
        display: block !important;
        position: relative !important;
        overflow: visible !important;
        background-color: #ffffffe6 !important;
        box-shadow: 0 2px 8px rgba(180,180,180,0.05) !important;
        line-height: normal !important;
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
    
    html body .header .nav-link,
    html body .header a.nav-link {
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
    
    html body .header .nav-link:hover,
    html body .header a.nav-link:hover {
        background-color: #f0f4ff !important;
        color: #1160E6 !important;
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
    
    html body .header .nav-link span,
    html body .header .nav-link-btn span,
    html body .header button.nav-link-btn span,
    html body .header form .nav-link-btn span,
    html body .header a.nav-link-btn span {
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: normal !important;
        font-size: 0.7rem !important;
        opacity: 0.9 !important;
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
</style>
@endpush

@section('content')
<style>
    /* ヘッダーエリアを完全に保護 - 履歴書ページのスタイルが一切影響しないように */
    html body .header {
        width: 100% !important;
        max-width: 100% !important;
        min-height: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 24px 0 16px 0 !important;
        box-sizing: border-box !important;
        display: block !important;
        position: relative !important;
        overflow: visible !important;
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
        margin-bottom: 16px !important;
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
        display: inline-block !important;
        text-decoration: none !important;
        color: inherit !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: normal !important;
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
        color: #888 !important;
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
        border-top: 1px solid #e5e7eb !important;
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
        display: block !important;
        line-height: normal !important;
        margin: 0 !important;
        padding: 0 !important;
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
    
    html body .header .nav-link,
    html body .header a.nav-link {
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
    
    html body .header .nav-link:hover,
    html body .header a.nav-link:hover {
        background-color: #f0f4ff !important;
        color: #1160E6 !important;
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
    
    html body .header .logo-main {
        font-size: 2rem !important;
        font-weight: 600 !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: auto !important;
        height: auto !important;
    }
    
    /* 入力画面のコンテンツのみ1000pxに制限 - メニューには影響しない */
    .main-content .resume-container {
        max-width: 1000px;
        margin: 0 auto;
        box-sizing: border-box;
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
</style>

<!-- コンテンツ部分 -->
<div class="resume-container">
    @if(isset($showConfirm) && $showConfirm)
        @include('resume.confirm')
    @else
        @include('resume._create_form', ['resumeData' => $resumeData ?? null])
    @endif
</div>

<script>
    // グローバル関数として定義（_create_form.blade.phpで使用される可能性があるため）
    window.showConfirm = function() {
        // 内容確認画面に遷移する処理は必要に応じて実装
        window.location.href = '{{ route("resume.index") }}?showConfirm=1';
    };
    
    window.backToForm = function() {
        window.location.href = '{{ route("resume.index") }}';
    };
</script>
@endsection
