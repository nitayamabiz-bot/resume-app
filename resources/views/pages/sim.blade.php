@extends('layouts.main')

@section('title', 'SIM - 就労支援サービス')

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
        SIMカード
        <span class="page-heading-nepali">SIM कार्ड</span>
    </h1>
    <div class="page-text">
        SIMカードの申し込みサポートページです。準備中です。
        <span class="page-text-nepali">
            SIM कार्ड आवेदन सहायता पृष्ठ। यो पृष्ठ तयारीमा छ।
        </span>
    </div>
</div>

@php
$rankings = [
    [
        'name' => 'Y!mobile',
        'description' => 'Y!mobileは格安SIMとして人気があります。データ容量が豊富で、通話料金もお得なプランが充実しています。オンラインで簡単に申し込みができます。',
        'description_nepali' => 'Y!mobile सस्तो SIM को रूपमा लोकप्रिय छ। डाटा क्षमता धेरै छ, कल शुल्क पनि लाभदायक योजनाहरू सम्पूर्ण छन्। अनलाइनमा सजिलैसँग आवेदन गर्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/1160E6/FFFFFF?text=Y!mobile'
    ],
    [
        'name' => '楽天モバイル',
        'description' => '楽天モバイルは楽天ポイントが貯まるサービスが魅力です。データ容量無制限プランもあり、動画視聴やSNS利用も安心して楽しめます。',
        'description_nepali' => '楽天モバイル 楽天 पोइन्ट जम्मा हुने सेवा आकर्षक छ। डाटा क्षमता असीमित योजना पनि छ, भिडियो हेर्ने र SNS प्रयोग पनि निश्चिन्त रूपमा मजा लिन सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/0346b0/FFFFFF?text=楽天モバイル'
    ],
    [
        'name' => 'IIJmio',
        'description' => 'IIJmioは柔軟なプラン設計で人気があります。データ容量を選べるプランが豊富で、使用状況に合わせて最適なプランを選択できます。',
        'description_nepali' => 'IIJmio लचिलो योजना डिजाइनले लोकप्रिय छ। डाटा क्षमता छनोट गर्न सकिने योजनाहरू धेरै छन्, प्रयोग अवस्था अनुसार उपयुक्त योजना छनोट गर्न सकिन्छ।',
        'image' => 'https://via.placeholder.com/300x200/3E5387/FFFFFF?text=IIJmio'
    ]
];
@endphp

<x-ranking-section :rankings="$rankings" />
@endsection

