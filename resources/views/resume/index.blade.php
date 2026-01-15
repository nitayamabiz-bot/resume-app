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
    
    /* ユーザー名（span.nav-link）のみ青文字 */
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
    
    html body .header span.nav-link:hover {
        background-color: #f0f4ff !important;
        color: #1160E6 !important;
    }
    
    /* ログインボタン（a.nav-link）は緑背景で白文字 */
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
    /* 入力画面のコンテンツのみ1000pxに制限 - メニューには影響しない */
    .main-content .resume-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 16px;
        box-sizing: border-box;
    }
    
    @media (min-width: 640px) {
        .main-content .resume-container {
            padding: 0 24px;
        }
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
