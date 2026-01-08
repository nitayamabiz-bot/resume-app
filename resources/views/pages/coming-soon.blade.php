@extends('layouts.main')

@section('title', '開発中 - 就労支援サービス')

@section('content')
<style>
    .page-content {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
        padding: 60px 20px;
    }
    .page-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 1em;
        color: #1160E6;
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
    .icon-container {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }
    @media (max-width: 700px) {
        .page-heading {
            font-size: 1.5rem;
        }
        .icon-container {
            font-size: 3rem;
        }
    }
</style>
<div class="page-content">
    <div class="icon-container">🚧</div>
    <h1 class="page-heading">
        開発中 / विकास गर्दै
        <span class="page-heading-nepali">यो पृष्ठ अहिले विकास अन्तर्गत छ</span>
    </h1>
    <div class="page-text">
        <span>現在このページは開発中です。もうしばらくお待ちください。</span>
        <span class="page-text-nepali">यो पृष्ठ हाल विकास अन्तर्गत छ। कृपया थोरै समय पर्खनुहोस्।</span>
    </div>
</div>
@endsection

