@extends('layouts.main')

@section('title', '職務経歴書作成 - 就労支援サービス')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* ヘッダー保護スタイル（履歴書と同じ） */
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
    
    .main-content .career-history-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 16px;
        box-sizing: border-box;
    }
    
    @media (min-width: 640px) {
        .main-content .career-history-container {
            padding: 0 24px;
        }
    }
    
    @media (max-width: 768px) {
        html body .header {
            padding: 24px 0 0px 0 !important;
        }
        html body .header .nav-links,
        html body .header > .nav-links {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="career-history-container">
    @if(isset($showConfirm) && $showConfirm)
        @include('career-history.confirm')
    @else
        @include('career-history._create_form', ['careerHistoryData' => $careerHistoryData ?? null])
    @endif
</div>
@endsection

