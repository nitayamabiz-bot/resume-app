@extends('layouts.main')

@section('title', '就職 - 就労支援サービス')

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
        就職情報
        <span class="page-heading-nepali">रोजगार जानकारी</span>
    </h1>
    <div class="page-text">
        就職情報の検索ページです。準備中です。
        <span class="page-text-nepali">
            रोजगार जानकारी खोज्ने पृष्ठ। यो पृष्ठ तयारीमा छ।
        </span>
    </div>
</div>

@php
$rankings = [
    [
        'name' => 'リクナビ',
        'description' => 'リクナビは日本最大級の就職情報サイトです。新卒・中途採用の求人情報が豊富で、企業の詳細情報や選考プロセスも確認できます。',
        'description_nepali' => 'リクナビ जापानको सबैभन्दा ठूलो रोजगार जानकारी साइट हो। नयाँ स्नातक र मध्य-कार्यकाल नियुक्ति जानकारी धेरै छ, कम्पनीको विस्तृत जानकारी र छनोट प्रक्रिया पनि जाँच गर्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/1160E6/FFFFFF?text=リクナビ'
    ],
    [
        'name' => 'マイナビ',
        'description' => 'マイナビは学生向けの就職支援サイトとして人気があります。企業説明会の情報やES（エントリーシート）の書き方など、就職活動をサポートする情報が充実しています。',
        'description_nepali' => 'マイナビ विद्यार्थीहरूको लागि रोजगार सहायता साइटको रूपमा लोकप्रिय छ। कम्पनी वर्णन सभाको जानकारी र ES (प्रवेश पत्र) लेख्ने तरिका लगायत, रोजगार खोजी सहायता गर्ने जानकारी सम्पूर्ण छ।',
        'image' => 'https://via.placeholder.com/300x200/0346b0/FFFFFF?text=マイナビ'
    ],
    [
        'name' => 'doda',
        'description' => 'dodaは転職に特化した就職情報サイトです。経験豊富なキャリアアドバイザーがサポートし、あなたのスキルや経験に合った転職先を見つけることができます。',
        'description_nepali' => 'doda काम परिवर्तनमा विशेषज्ञ रोजगार जानकारी साइट हो। अनुभवी क्यारियर सल्लाहकारले सहयोग गर्दछ, तपाईंको कौशल र अनुभव अनुसारको काम परिवर्तन ठाउँ फेला पार्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/3E5387/FFFFFF?text=doda'
    ]
];
@endphp

<x-ranking-section :rankings="$rankings" />
@endsection

