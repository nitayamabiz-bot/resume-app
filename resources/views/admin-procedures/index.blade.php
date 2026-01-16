@extends('layouts.main')

@section('title', '行政手続きガイド - 就労支援サービス')

@section('content')
<style>
    .admin-procedures-page {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
        box-sizing: border-box;
    }
    .admin-procedures-header {
        text-align: center;
        letter-spacing: 0.04em;
        max-width: 800px;
        margin: 1.5rem auto 1.75rem;
    }
    .admin-procedures-title {
        font-size: 1.75rem; /* 他メニューのメイン見出しと揃える */
        font-weight: 700;
        color: #1f2937;
        line-height: 1.3;
        margin: 0;
    }
    .admin-procedures-lead {
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.7;
        margin-top: 0.75rem;
    }
    .admin-procedures-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    @media (min-width: 768px) {
        .admin-procedures-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    .admin-procedures-card {
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.15s ease-out, box-shadow 0.15s ease-out, border-color 0.15s ease-out;
    }
    .admin-procedures-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.09);
        border-color: #bfdbfe;
    }
    .admin-procedures-card-header {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }
    .admin-procedures-card-title-jp {
        font-size: 0.98rem;
        font-weight: 600;
        color: #111827;
    }
    .admin-procedures-card-title-np {
        font-size: 0.78rem;
        color: #6b7280;
        margin-top: 0.15rem;
    }
    .admin-procedures-chip {
        font-size: 0.68rem;
        padding: 0.1rem 0.6rem;
        border-radius: 9999px;
        border-width: 1px;
        border-style: solid;
        font-weight: 600;
        letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .admin-procedures-card-body {
        padding: 0.85rem 1rem 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        font-size: 0.8rem;
        color: #4b5563;
    }
    .admin-procedures-description {
        line-height: 1.7;
    }
    .admin-procedures-details {
        border-radius: 0.6rem;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
        overflow: hidden;
    }
    .admin-procedures-details + .admin-procedures-details {
        margin-top: 0.45rem;
    }
    .admin-procedures-summary {
        list-style: none;
        padding: 0.55rem 0.8rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        font-size: 0.82rem;
        color: #111827;
        background: linear-gradient(to right, #f9fafb, #eff6ff);
    }
    .admin-procedures-summary::-webkit-details-marker {
        display: none;
    }
    .admin-procedures-summary-title {
        font-weight: 600;
    }
    .admin-procedures-summary-sub {
        font-size: 0.7rem;
        color: #6b7280;
        margin-left: 0.4rem;
    }
    .admin-procedures-summary-arrow {
        font-size: 0.7rem;
        color: #6b7280;
        margin-left: 0.5rem;
        transition: transform 0.15s ease-out;
    }
    details[open] .admin-procedures-summary-arrow {
        transform: rotate(180deg);
    }
    .admin-procedures-details-body {
        padding: 0.6rem 0.85rem 0.8rem;
        border-top: 1px solid #e5e7eb;
        background-color: #ffffff;
    }
    .admin-procedures-doc-title,
    .admin-procedures-source-label,
    .admin-procedures-downloads-title {
        display: block;
        width: 90%;
        font-weight: 700; /* 3つの見出しをすべて同じ太さ（太字）に統一 */
        color: #1f2937;
        margin: 0 0 0.3rem 0;
        font-size: 0.78rem;
        padding: 0.25rem 0.75rem;
        border-radius: 0.4rem; /* 丸ではなく、ダウンロードボタン程度の角丸の四角に */
        background: linear-gradient(to right, #eff6ff, #f9fafb);
        border: 1px solid #dbeafe;
    }
    .admin-procedures-doc-list {
        margin: 0;
        padding-left: 1.1rem;
    }
    .admin-procedures-doc-list li {
        margin: 0.08rem 0;
    }
    .admin-procedures-doc-list span {
        color: #6b7280;
    }
    .admin-procedures-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem 0.75rem;
        align-items: center;
        margin-top: 0.4rem;
    }
    .admin-procedures-source-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0.7rem 0 0.3rem 0; /* 必要書類ブロックとの間に十分な余白を確保 */
    }
    .admin-procedures-source-chip {
        font-size: 0.7rem;
        padding: 0.1rem 0.6rem;
        border-radius: 9999px;
        border-width: 1px;
        border-style: solid;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
    }
    .admin-procedures-downloads {
        margin-top: 0.8rem !important; /* 手続き先ブロックとの間に十分な余白を確保 */
        padding-top: 0.6rem;
    }
    .admin-procedures-downloads a,
    .admin-procedures-generate a {
        display: inline-flex;
        align-items: center;
        border-radius: 0.4rem;
        font-weight: 600;
        text-decoration: none;
        margin-right: 0.35rem;
    }
    .admin-procedures-downloads a {
        background-color: transparent; /* ダウンロード書類名は背景色なし */
        color: #374151;
        padding: 0.18rem 0.45rem; /* テキストに近い余白＋枠線用 */
        font-size: 0.75rem;
        border: 1px solid #e5e7eb; /* 二行になったときにも形がわかるように薄い枠線 */
        border-radius: 0.35rem;
    }
    .admin-procedures-downloads a:hover {
        background-color: #f9fafb;
        text-decoration: none;
        border-color: #d1d5db;
    }
    .admin-procedures-downloads a span:first-child {
        margin-right: 0.35rem; /* アイコンと書類名の間に少しだけ余白を追加 */
    }
    .admin-procedures-generate a {
        background-color: #2563eb;
        color: #ffffff;
        padding: 0.4rem 0.7rem;
        font-size: 0.78rem;
    }
    .admin-procedures-generate a::before {
        content: '★';
        font-size: 0.7rem;
        margin-right: 0.25rem;
    }
    .admin-procedures-generate a:hover {
        background-color: #1d4ed8;
    }
</style>

<div class="admin-procedures-page">
    <div class="admin-procedures-header">
        <h2 class="admin-procedures-title">
            行政手続きガイド / प्रशासनिक प्रक्रिया गाइड
        </h2>
        <p class="admin-procedures-lead">
            日本で生活・就労するネパール人の方向けに、ビザ・家族・転職・永住・役所の手続きなどを状況別にまとめました。<br>
            तपाईंको अहिलेको अवस्थाअनुसार कुन कागजात चाहिन्छ र कहाँ जाने भन्ने कुरा सजिलै बुझ्न सकिने गरी संक्षेपमा दिइिएको छ।
        </p>
    </div>

    {{-- カテゴリ一覧（カード形式・モックアップ） --}}
    <div class="admin-procedures-grid grid gap-4 sm:grid-cols-2">
        @foreach($categories as $category)
            <div class="admin-procedures-card border border-gray-200 rounded-lg shadow-sm bg-white flex flex-col">
                <div class="admin-procedures-card-header px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="admin-procedures-card-title-jp text-base font-semibold text-gray-800">
                            {{ $category['title_jp'] }}
                        </h3>
                        <p class="admin-procedures-card-title-np text-xs text-gray-500 mt-1">
                            {{ $category['title_np'] }}
                        </p>
                    </div>
                    <span class="admin-procedures-chip inline-flex items-center rounded-full px-2 py-1 text-[11px] font-medium
                        @if($category['color'] === 'blue') bg-blue-50 text-blue-700 border border-blue-200
                        @elseif($category['color'] === 'green') bg-green-50 text-green-700 border border-green-200
                        @elseif($category['color'] === 'amber') bg-amber-50 text-amber-700 border border-amber-200
                        @elseif($category['color'] === 'purple') bg-purple-50 text-purple-700 border border-purple-200
                        @else bg-teal-50 text-teal-700 border border-teal-200
                        @endif
                    ">
                        {{-- ラベルの色でざっくりカテゴリを視覚化（場所ではなくテーマ単位） --}}
                        GUIDE
                    </span>
                </div>

                <div class="admin-procedures-card-body px-4 py-3 flex-1 flex flex-col">
                    <p class="admin-procedures-description text-xs text-gray-600 mb-3 leading-relaxed">
                        {{ $category['description'] }}
                    </p>

                    {{-- 手続きリスト（モックアップ） --}}
                    @if(!empty($category['procedures']))
                        <div class="space-y-2">
                            @foreach($category['procedures'] as $procedure)
                                <details class="admin-procedures-details border border-gray-200 rounded-md overflow-hidden bg-gray-50">
                                    <summary class="admin-procedures-summary px-3 py-2 flex items-center justify-between cursor-pointer text-xs sm:text-sm">
                                        <span class="admin-procedures-summary-title font-medium text-gray-800">
                                            {{ $procedure['name_jp'] }}
                                        </span>
                                        <span class="admin-procedures-summary-sub ml-2 text-[11px] text-gray-500 hidden sm:inline">
                                            {{ $procedure['name_np'] }}
                                        </span>
                                        <span class="admin-procedures-summary-arrow">▼</span>
                                    </summary>
                                    <div class="admin-procedures-details-body px-3 py-2 border-t border-gray-200 bg-white text-[11px] sm:text-xs space-y-2">
                                        <div>
                                            <p class="admin-procedures-doc-title">
                                                必要書類 / आवश्यक कागजात
                                            </p>
                                            <ul class="admin-procedures-doc-list list-disc list-inside text-gray-700 space-y-0.5">
                                                @foreach($procedure['documents'] as $doc)
                                                    <li>
                                                        {{ $doc['label_jp'] }}
                                                        <span class="text-gray-500"> / {{ $doc['label_np'] }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @php
                                                $hasReasonDoc = false;
                                                foreach ($procedure['documents'] as $doc) {
                                                    if (isset($doc['label_jp']) && str_contains($doc['label_jp'], '理由書')) {
                                                        $hasReasonDoc = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @if($hasReasonDoc)
                                                <p class="mt-1 text-[11px] text-gray-500 leading-relaxed">
                                                    理由書は多くの場合、決まった公式様式はなく、自分でWordなどで作成します。入管や市区町村のWEBサイトにある記載例を参考に、日本語または英語で分かりやすく理由を書いてください。<br>
                                                    धेरै अवस्थामा कारण पत्र (理由書) को निश्चित फारम हुँदैन, आफैंले Word आदि मा तयार पार्नुपर्छ। इमिग्रेशन वा नगरपालिकाको वेबसाइटमा दिइएका उदाहरण हेरेर जापानी वा अङ्ग्रेजीमा स्पष्ट रूपमा कारण लेख्नुहोस्।
                                                </p>
                                            @endif
                                        </div>

                                        <div class="border-t border-dashed border-slate-200 pt-2 mt-1 space-y-1">
                                            <p class="admin-procedures-source-label">
                                                手続き先・どこへ行くか / कहाँ जाने:
                                            </p>
                                            <div class="admin-procedures-meta-row flex flex-wrap items-center gap-2">
                                            @php
                                                $source = $procedure['source'];
                                                $sourceLabel = [
                                                    'immigration' => ['label' => '入管', 'np' => 'इमिग्रेशन', 'color' => 'bg-red-50 text-red-700 border-red-200'],
                                                    'city-hall' => ['label' => '役所', 'np' => 'नगरपालिका', 'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                                    'school' => ['label' => '学校', 'np' => 'स्कुल', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                                                    'web' => ['label' => 'WEBダウンロード', 'np' => 'वेबबाट डाउनलोड', 'color' => 'bg-sky-50 text-sky-700 border-sky-200'],
                                                    'site' => ['label' => 'このサイトで作成', 'np' => 'यस साइटबाट तयार', 'color' => 'bg-orange-50 text-orange-700 border-orange-200'],
                                                ][$source] ?? ['label' => 'その他', 'np' => 'अन्य', 'color' => 'bg-gray-50 text-gray-700 border-gray-200'];
                                            @endphp
                                                <span class="admin-procedures-source-chip inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] {{ $sourceLabel['color'] }}">
                                                    {{ $sourceLabel['label'] }} / {{ $sourceLabel['np'] }}
                                                </span>
                                                @if(!empty($procedure['place_jp'] ?? null))
                                                    <span class="text-[11px] text-gray-600 leading-snug">
                                                        {{ $procedure['place_jp'] }}<br>
                                                        <span class="block text-[11px] text-gray-400">{{ $procedure['place_np'] ?? '' }}</span>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- 書類ダウンロード（WEB配布されている様式を、このサイトからもDL可能に） --}}
                                        @if(!empty($procedure['downloads'] ?? []))
                                            <div class="admin-procedures-downloads pt-2 space-y-1 border-t border-slate-200 mt-1">
                                                <p class="admin-procedures-downloads-title">
                                                    ダウンロード / डाउनलोड
                                                </p>
                                                @foreach($procedure['downloads'] as $download)
                                                    <a href="{{ asset($download['path']) }}"
                                                       class="inline-flex items-center px-3 py-1.5 rounded-md text-[11px] sm:text-xs font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200 transition"
                                                       download>
                                                        <span class="mr-1">⬇️</span>{{ $download['label_jp'] }}&nbsp;/&nbsp;<span class="text-gray-500">{{ $download['label_np'] }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- このサイトでPDF生成できる手続き --}}
                                        @if($procedure['can_generate_pdf'] && $procedure['generate_route'])
                                            <div class="admin-procedures-generate pt-1">
                                                <a href="{{ route($procedure['generate_route']) }}"
                                                   class="inline-flex items-center px-3 py-1.5 rounded-md text-[11px] sm:text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition">
                                                    このサイトで作成する<br>
                                                    यस साइटबाट फारम तयार गर्नुहोस्
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[11px] text-gray-500">
                            詳細な手続きガイドは順次追加予定です。<br>
                            विस्तृत प्रक्रिया गाइड क्रमशः थप्दै जानेछ।
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

