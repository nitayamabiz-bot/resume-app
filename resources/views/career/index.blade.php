@extends('layouts.main')

@section('title', '職務経歴書作成 - 就労支援サービス')

@section('content')
<style>
    .page-content {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        padding: 4rem 1rem;
    }
    .page-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 1em;
        color: #1f2937;
    }
    .page-heading-nepali {
        font-size: 1.05rem;
        color: #3E5387;
        display: block;
        margin-bottom: 2em;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .page-text {
        color: #4b5563;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.1rem;
    }
    .page-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    @media (max-width: 700px) {
        .page-heading {
            font-size: 1.5rem;
        }
        .page-content {
            padding: 2rem 1rem;
        }
    }
</style>
<div class="page-content">
    <h1 class="page-heading">
        職務経歴書作成
        <span class="page-heading-nepali">कामको अनुभव तयार गर्नुहोस्</span>
    </h1>
    <div class="page-text">
        現在、職務経歴書作成機能を開発中です。リリースを楽しみにお待ちください。
        <span class="page-text-nepali">
            हाल, कामको अनुभव तयार गर्ने सुविधा विकास भइरहेको छ। रिलिजको लागि कृपया प्रतीक्षा गर्नुहोस्।
        </span>
    </div>
</div>
@endsection

