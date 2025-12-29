@extends('layouts.main')

@section('title', '賃貸 - 就労支援サービス')

@section('content')
<style>
    .page-content {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
    }
    .page-heading {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 0.5em;
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
    }
</style>
<div class="page-content">
    <h1 class="page-heading">
        賃貸物件検索
        <span class="page-heading-nepali">भाडाको खोज</span>
    </h1>
    <div class="page-text">
        賃貸物件の検索ページです。準備中です。
        <span class="page-text-nepali">
            भाडाको खोज पृष्ठ। यो पृष्ठ तयारीमा छ।
        </span>
    </div>
</div>

@php
$rankings = [
    [
        'name' => 'SUUMO',
        'description' => 'SUUMOは日本最大級の不動産情報サイトです。豊富な物件情報と詳細な検索機能で、あなたにぴったりの物件を見つけることができます。',
        'description_nepali' => 'SUUMO जापानको सबैभन्दा ठूलो रियल एस्टेट जानकारी साइट हो। धेरै संख्यामा रहेको रूम जानकारी र विस्तृत खोज सुविधाहरूले तपाईंको लागि उपयुक्त रूम फेला पार्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/1160E6/FFFFFF?text=SUUMO'
    ],
    [
        'name' => 'HOME\'S',
        'description' => 'HOME\'Sは使いやすいインターフェースと充実した物件情報で、賃貸物件探しをサポートします。駅近検索や条件検索が簡単にできます。',
        'description_nepali' => 'HOME\'S प्रयोग गर्न सजिलो इन्टरफेस र सम्पूर्ण रूम जानकारीले भाडाको खोजमा सहयोग गर्दछ। स्टेशन नजिकैको खोज र अवस्था खोज सजिलैसँग गर्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/0346b0/FFFFFF?text=HOME\'S'
    ],
    [
        'name' => 'アットホーム',
        'description' => 'アットホームは全国の賃貸物件情報を提供しています。詳細な間取り図や周辺環境の情報も充実しており、物件選びに役立ちます。',
        'description_nepali' => 'アットホーム ले देशभरिको भाडाको जानकारी प्रदान गर्दछ। विस्तृत लेआउट चित्र र वरपरको वातावरण जानकारी पनि सम्पूर्ण छ, रूम छनोटमा मद्दत गर्दछ।',
        'image' => 'https://via.placeholder.com/300x200/3E5387/FFFFFF?text=アットホーム'
    ]
];
@endphp

<x-ranking-section :rankings="$rankings" />
@endsection

