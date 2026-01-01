@extends('layouts.main')

@section('title', '銀行口座 - 就労支援サービス')

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
        銀行口座開設
        <span class="page-heading-nepali">बैंक खाता खोल्ने</span>
    </h1>
    <div class="page-text">
        現在、銀行口座開設情報を収集中です。おすすめできる情報が入り次第、更新します！お楽しみに。
        <span class="page-text-nepali">
            हाल, बैंक खाता खोल्ने जानकारी संग्रह भइरहेको छ। सिफारिस गर्न सकिने जानकारी आएपछि, अपडेट गर्नेछौं! कृपया प्रतीक्षा गर्नुहोस्।
        </span>
    </div>
</div>
@endsection

