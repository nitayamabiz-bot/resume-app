@extends('layouts.main')

@section('title', 'トップページ - 就労支援サービス')

@section('content')
<style>
    .center-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
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
        margin-bottom: 2em;
        display: block;
        text-align: center;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .welcome-text {
        text-align: center;
        color: #4b5563;
        line-height: 1.8;
        max-width: 800px;
        margin: 0 auto 40px;
    }
    .welcome-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    @media (max-width: 700px) {
        .main-heading {
            font-size: 1.5rem;
        }
        .welcome-text {
            font-size: 0.95rem;
            padding: 0 16px;
        }
    }
</style>
<div class="center-content">
    <h1 class="main-heading">
        就労支援サービスへようこそ
        <span class="heading-nepali">रोजगार सहायता सेवामा स्वागत छ</span>
    </h1>
    <div class="welcome-text">
        日本での生活をサポートする各種サービスをご案内しています。
        賃貸物件の検索、アルバイト・就職情報、銀行口座開設、インターネット回線・SIMカードの手続きなど、
        あなたの生活に必要な情報をまとめて提供しています。
        <span class="welcome-text-nepali">
            जापानमा बस्नका लागि विभिन्न सेवाहरू प्रदान गर्दछौं।
            भाडाको खोज, अंशकालिक र रोजगार जानकारी, बैंक खाता खोल्ने, इन्टरनेट र SIM कार्डको प्रक्रिया लगायत,
            तपाईंको जीवनको लागि आवश्यक जानकारीहरू यहाँ उपलब्ध छन्।
        </span>
    </div>
</div>
@endsection

