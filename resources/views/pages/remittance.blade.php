@extends('layouts.main')

@section('title', '送金サービス紹介 - Wise | 就労支援サービス')

@section('description', '国際送金サービスWise（ワイズ）の紹介。手数料が透明・為替は中間レート・74%が20秒以内に到着。日本からネパールなど世界へ送金する方へ。')

@section('keywords', 'Wise,ワイズ,国際送金,海外送金,ネパール送金,送金サービス,低手数料')

@section('content')
<style>
    :root {
        --wise-accent: #4f46e5;
        --wise-accent-hover: #4338ca;
        --wise-card-bg: #ffffff;
        --wise-card-shadow: 0 4px 24px rgba(79, 70, 229, 0.08);
        --wise-text: #1e293b;
        --wise-text-muted: #64748b;
        --wise-border: #e2e8f0;
    }

    .remittance-page {
        overflow-x: hidden;
    }

    /* Hero - 背景画像を薄く表示し、その上にグラデと文字 */
    .remittance-hero {
        position: relative;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        padding: 48px 24px 100px;
        text-align: center;
        overflow: hidden;
    }
    /* 背景画像（濃く表示して画像を見せる） */
    .remittance-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image: url('{{ asset('images/remittance-hero.webp') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform: translate3d(0, 0, 0);
        backface-visibility: hidden;
    }
    /* 暗いオーバーレイ（白文字のコントラスト確保） */
    .remittance-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background: rgba(0, 0, 0, 0.45);
        pointer-events: none;
    }
    .remittance-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 720px;
    }
    .remittance-hero-logo {
        display: inline-block;
        margin-bottom: 28px;
        line-height: 0;
        background: rgba(255, 255, 255, 0.95);
        padding: 12px 56px;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
    }
    .remittance-hero-logo img {
        width: 420px;
        height: 180px;
        object-fit: contain;
        display: block;
    }
    .remittance-hero h1 {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        line-height: 1.2;
        margin: 0 0 16px;
        letter-spacing: -0.02em;
    }
    .remittance-hero-sub {
        font-size: 1.125rem;
        opacity: 0.95;
        margin: 0 0 32px;
        line-height: 1.6;
    }
    .remittance-hero-sub-ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        font-size: 1rem;
        opacity: 0.9;
        margin-top: 8px;
    }
    .remittance-hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--wise-accent) 0%, #6366f1 100%);
        color: #fff;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1.0625rem;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.15) inset;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
    }
    .remittance-hero-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(79, 70, 229, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2) inset;
        filter: brightness(1.05);
    }
    .remittance-hero-cta-text {
        display: inline-block;
        text-align: center;
        line-height: 1.5;
    }
    @media (max-width: 768px) {
        .remittance-hero {
            padding: 32px 16px 80px;
        }
        .remittance-hero-inner {
            width: 100%;
            padding: 0 8px;
            box-sizing: border-box;
        }
        .remittance-hero-logo {
            max-width: 100%;
            padding: 12px 16px;
            box-sizing: border-box;
        }
        .remittance-hero-logo img {
            width: 100%;
            max-width: 320px;
            height: auto;
            aspect-ratio: 420/180;
        }
        .remittance-hero-cta {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 14px 20px;
            font-size: 0.9375rem;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            text-align: center;
            line-height: 1.5;
            white-space: normal;
            box-sizing: border-box;
        }
    }

    /* Image placeholder */
    .remittance-img-placeholder {
        aspect-ratio: 16/10;
        background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
        border: 2px dashed var(--wise-border);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--wise-text-muted);
        font-size: 0.9375rem;
        font-family: 'Noto Sans JP', sans-serif;
    }
    .remittance-img-placeholder span {
        text-align: center;
        padding: 24px;
    }
    /* Wiseとは：広告エリア */
    .remittance-ad-wise-intro {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .remittance-ad-wise-intro a {
        display: block;
        line-height: 0;
    }
    .remittance-ad-wise-intro img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    /* Section common */
    .remittance-section {
        padding: 80px 24px;
        max-width: 1100px;
        margin: 0 auto;
        position: relative;
    }
    /* セクション間の区切り線（グラデーション） */
    .remittance-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, rgba(79, 70, 229, 0.12) 15%, rgba(79, 70, 229, 0.22) 50%, rgba(79, 70, 229, 0.12) 85%, transparent 100%);
    }
    .remittance-stats {
        position: relative;
    }
    .remittance-stats::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, rgba(79, 70, 229, 0.12) 15%, rgba(79, 70, 229, 0.22) 50%, rgba(79, 70, 229, 0.12) 85%, transparent 100%);
    }
    .remittance-cta-section {
        position: relative;
    }
    .remittance-cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, rgba(79, 70, 229, 0.12) 15%, rgba(79, 70, 229, 0.22) 50%, rgba(79, 70, 229, 0.12) 85%, transparent 100%);
    }
    /* セクション背景：ごく薄い単色グラデ（主張しすぎない） */
    .remittance-section-intro {
        background: #fafafa;
    }
    .remittance-section-speed {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }
    .remittance-section-features {
        background: linear-gradient(180deg, #fafafa 0%, #f4f4f5 100%);
    }
    .remittance-section-fees {
        background: linear-gradient(180deg, #fcfcfb 0%, #f8f7f4 100%);
    }
    .remittance-section-security {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }
    .remittance-section-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 700;
        color: var(--wise-text);
        margin: 0 0 12px;
        text-align: center;
    }
    .remittance-section-sub {
        color: var(--wise-text-muted);
        font-size: 1rem;
        text-align: center;
        margin: 0 0 48px;
    }
    .remittance-section-sub-ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        margin-top: 4px;
    }

    /* Intro + logo placeholder */
    .remittance-intro {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: center;
    }
    @media (max-width: 768px) {
        .remittance-intro {
            grid-template-columns: 1fr;
        }
    }
    .remittance-intro-text p {
        color: var(--wise-text);
        line-height: 1.8;
        margin: 0 0 16px;
        font-size: 1.0625rem;
    }
    .remittance-intro-text p.ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: var(--wise-text-muted);
        font-size: 0.9375rem;
    }

    /* Feature cards */
    .remittance-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }
    /* できることセクション：横4列・コンパクト */
    .remittance-section-features .remittance-features {
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    @media (max-width: 1024px) {
        .remittance-section-features .remittance-features {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .remittance-section-features .remittance-features {
            grid-template-columns: 1fr;
        }
    }
    .remittance-section-features .remittance-feature-card {
        padding: 20px 16px;
    }
    .remittance-section-features .remittance-feature-icon {
        width: 44px;
        height: 44px;
        margin-bottom: 14px;
    }
    .remittance-section-features .remittance-feature-icon svg {
        width: 22px;
        height: 22px;
    }
    .remittance-section-features .remittance-feature-card h3 {
        font-size: 1.0625rem;
    }
    .remittance-section-features .remittance-feature-card h3 .ne {
        font-size: 0.875rem;
    }
    .remittance-section-features .remittance-feature-card p {
        font-size: 0.875rem;
        line-height: 1.6;
    }
    .remittance-section-features .remittance-feature-card p.ne {
        font-size: 0.8125rem;
    }
    .remittance-feature-card {
        background: var(--wise-card-bg);
        border-radius: 16px;
        padding: 32px;
        box-shadow: var(--wise-card-shadow);
        border: 1px solid rgba(79, 70, 229, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .remittance-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.15);
    }
    .remittance-feature-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.06) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: var(--wise-accent);
    }
    .remittance-feature-icon svg {
        width: 28px;
        height: 28px;
    }
    .remittance-feature-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--wise-text);
        margin: 0 0 8px;
    }
    .remittance-feature-card h3 .ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        font-size: 0.95rem;
        color: var(--wise-text-muted);
        font-weight: 500;
        display: block;
        margin-top: 4px;
    }
    /* スピードカード：1文で意味が伝わる見出し */
    .remittance-feature-card .remittance-speed-headline {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--wise-text);
        margin: 0 0 6px;
        line-height: 1.5;
    }
    .remittance-feature-card .remittance-speed-headline strong {
        color: var(--wise-accent);
        font-weight: 700;
    }
    .remittance-feature-card .remittance-speed-headline-ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        font-size: 1rem;
        color: var(--wise-text-muted);
        margin: 0 0 16px;
        line-height: 1.5;
    }
    .remittance-feature-card .remittance-speed-headline-ne strong {
        color: var(--wise-accent);
    }
    .remittance-feature-card .remittance-feature-card-desc {
        font-size: 0.9375rem;
        color: var(--wise-text-muted);
        margin: 0;
        line-height: 1.6;
    }
    .remittance-feature-card .remittance-feature-card-desc .ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        display: block;
        margin-top: 4px;
        font-size: 0.875rem;
    }
    .remittance-feature-card p {
        color: var(--wise-text-muted);
        font-size: 0.9375rem;
        line-height: 1.7;
        margin: 0;
    }
    .remittance-feature-card p.ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        margin-top: 6px;
        font-size: 0.875rem;
    }

    /* Stats strip：1文で意味が伝わるカード */
    .remittance-stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 40px 24px 80px;
        margin: 0 auto 0;
        max-width: 1060px;
    }
    .remittance-stat {
        flex: 1 1 200px;
        max-width: 260px;
        background: #fff;
        border: 2px solid rgba(79, 70, 229, 0.15);
        border-radius: 16px;
        padding: 24px 20px;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.06);
        text-align: center;
    }
    .remittance-stat-value {
        font-size: clamp(1.75rem, 3vw, 2.25rem);
        font-weight: 700;
        color: var(--wise-accent);
        margin: 0 0 8px;
        line-height: 1;
    }
    .remittance-stat-label {
        margin: 0;
        font-size: 0.9375rem;
        font-weight: 500;
        color: var(--wise-text);
        line-height: 1.5;
    }
    .remittance-stat-label .ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        display: block;
        margin-top: 6px;
        font-size: 0.8125rem;
        color: var(--wise-text-muted);
        font-weight: 400;
    }

    /* Two column block */
    .remittance-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .remittance-two-col {
            grid-template-columns: 1fr;
        }
    }
    .remittance-two-col .remittance-img-placeholder {
        aspect-ratio: 4/3;
    }
    .remittance-img-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .remittance-section-img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    /* 手数料・セキュリティセクションの画像は小さめに（同サイズ感） */
    .remittance-section-fees .remittance-section-img,
    .remittance-section-security .remittance-section-img {
        max-width: 320px;
    }
    @media (max-width: 768px) {
        .remittance-section-fees .remittance-section-img,
        .remittance-section-security .remittance-section-img {
            max-width: 240px;
        }
    }

    /* Security list */
    .remittance-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .remittance-list li {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid var(--wise-border);
        color: var(--wise-text);
        line-height: 1.6;
    }
    .remittance-list li:last-child {
        border-bottom: none;
    }
    .remittance-list-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        color: var(--wise-accent);
    }
    .remittance-list li span.ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        display: block;
        margin-top: 6px;
        color: var(--wise-text-muted);
        font-size: 0.9375rem;
    }

    /* CTA bottom */
    .remittance-cta-section {
        padding: 80px 24px 100px;
        background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 50%, #f1f5f9 100%);
    }
    .remittance-cta-card {
        max-width: 560px;
        margin: 0 auto;
        text-align: center;
        background: #fff;
        border-radius: 24px;
        padding: 24px 40px 32px;
        box-shadow: 0 4px 24px rgba(79, 70, 229, 0.08), 0 0 0 1px rgba(79, 70, 229, 0.06);
        border: 1px solid rgba(79, 70, 229, 0.1);
    }
    .remittance-cta-logo {
        display: inline-block;
        margin-bottom: 12px;
        line-height: 0;
    }
    .remittance-cta-logo img {
        width: 120px;
        height: 120px;
        object-fit: contain;
    }
    .remittance-cta-section h2 {
        font-size: clamp(1.375rem, 2.5vw, 1.75rem);
        font-weight: 700;
        color: var(--wise-text);
        margin: 0 0 12px;
    }
    .remittance-cta-section .remittance-cta-desc {
        color: var(--wise-text-muted);
        font-size: 0.9375rem;
        line-height: 1.7;
        margin: 0 0 28px;
    }
    .remittance-cta-section .remittance-cta-desc .ne {
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        display: block;
        margin-top: 6px;
        font-size: 0.875rem;
    }
    .remittance-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--wise-accent);
        color: #fff;
        padding: 16px 32px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }
    .remittance-cta-btn:hover {
        background: var(--wise-accent-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
    }

    /* Disclaimer */
    .remittance-disclaimer {
        font-size: 0.8125rem;
        color: var(--wise-text-muted);
        text-align: center;
        padding: 24px;
        border-top: 1px solid var(--wise-border);
        margin-top: 48px;
    }
</style>

<div class="remittance-page">
    {{-- Hero --}}
    <section class="remittance-hero">
        <div class="remittance-hero-inner">
            <a href="https://wise.prf.hn/click/camref:1101l5CK5N/creativeref:1011l101119" target="_blank" rel="noopener noreferrer sponsored" class="remittance-hero-logo">
                <img src="https://wise-creative.prf.hn/source/camref:1101l5CK5N/creativeref:1011l101119" width="420" height="180" alt="Wise">
            </a>
            <h1>国境をこえた送金を、<br>シンプルに。<br><span class="remittance-hero-sub-ne" style="display: block; margin-top: 12px; font-size: 1.1rem;">सीमा पार पैसा पठाउनु सजिलो।</span></h1>
            <p class="remittance-hero-sub">
                手数料が透明で、為替は中間レート。銀行よりお得に、世界へ送金できるサービス「Wise」をご紹介します。
                <span class="remittance-hero-sub-ne">पारदर्शी शुल्क र मध्य बजार दर। बैंक भन्दा राम्रो दरमा विश्वमा पैसा पठाउनुहोस्। Wise सेवाको परिचय।</span>
            </p>
            <a href="https://wise.prf.hn/click/camref:1101l5CK5N" target="_blank" rel="noopener noreferrer" class="remittance-hero-cta">
                <span class="remittance-hero-cta-text">Wise 公式サイトへ<br>Wise आधिकारिक साइटमा जानुहोस्</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </section>

    {{-- What is Wise + image placeholder --}}
    <section class="remittance-section remittance-section-intro">
        <h2 class="remittance-section-title">Wise（ワイズ）とは / Wise (वाइज) भनेको के हो?</h2>
        <p class="remittance-section-sub">
            世界中で利用されている国際送金・マルチカレンシー口座サービスです。<br>
            <span class="remittance-section-sub-ne">विश्वव्यापी रूपमा प्रयोग गरिने अन्तर्राष्ट्रिय पैसा पठाउने र बहु-मुद्रा खाता सेवा।</span>
        </p>
        <div class="remittance-intro">
            <div class="remittance-intro-text">
                <p>Wiseは、送金時の為替レートに上乗せ（マークアップ）をせず、中間レートに近いレートを提供しています。手数料も事前に表示されるため、銀行などと比べて「いくら届くか」が分かりやすいサービスです。</p>
                <p class="ne">Wise ले पैसा पठाउँदा विनिमय दरमा मार्कअप थप्दैन, मध्य बजार दर नजिकको दर दिन्छ। शुल्क पनि अग्रिम रूपमा देखाइन्छ। बैंक भन्दा कति पुग्छ भन्ने सजिलै बुझिन्छ।</p>
                <p>日本では関東財務局の登録を受けた資金移動業者として運営されています。<br><span class="ne">जापानमा कान्तो वित्तीय ब्युरोको दर्ता भएको कोष स्थानान्तरण व्यवसायको रूपमा सञ्चालन गरिन्छ।</span></p>
            </div>
            <div class="remittance-ad-wise-intro">
                <a href="https://wise.prf.hn/click/camref:1101l5CK5N/creativeref:1100l100085" rel="sponsored"><img src="https://wise-creative.prf.hn/source/camref:1101l5CK5N/creativeref:1100l100085" width="300" height="300" border="0" alt="Wise"/></a>
            </div>
        </div>
    </section>

    {{-- Approved claims: Speed --}}
    <section class="remittance-section remittance-section-speed">
        <h2 class="remittance-section-title">スピード / गति</h2>
        <p class="remittance-section-sub">送金の到着スピードについて、Wiseが公表している実績です。<br><span class="remittance-section-sub-ne">पठाइ कति छिटो पुग्छ भन्ने Wise को सार्वजनिक तथ्याङ्क।</span></p>
        <div class="remittance-features">
            <div class="remittance-feature-card">
                <p class="remittance-speed-headline">送金の<strong>74%</strong>が20秒以内に到着</p>
                <p class="remittance-speed-headline-ne">पठाइको <strong>७४%</strong> २० सेकेन्ड भित्र पुग्छ</p>
                <p class="remittance-feature-card-desc">ほとんどが即時で届くスピードです。<br><span class="ne">धेरै तत्काल पुग्छ।</span></p>
            </div>
            <div class="remittance-feature-card">
                <p class="remittance-speed-headline">送金の<strong>87%</strong>が1時間以内に到着</p>
                <p class="remittance-speed-headline-ne">पठाइको <strong>८७%</strong> १ घण्टा भित्र पुग्छ</p>
                <p class="remittance-feature-card-desc">同日中に届くケースがほとんどです。<br><span class="ne">उही दिन पुग्ने धेरै छ।</span></p>
            </div>
        </div>
    </section>

    {{-- Product coverage (approved claims) --}}
    <section class="remittance-section remittance-section-features">
        <h2 class="remittance-section-title">できること / गर्न सकिने कुराहरू</h2>
        <p class="remittance-section-sub">Wiseで利用できる主な機能です。<br><span class="remittance-section-sub-ne">Wise मा उपलब्ध मुख्य सुविधाहरू।</span></p>
        <div class="remittance-features">
            <div class="remittance-feature-card">
                <div class="remittance-feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3>送金 / पैसा पठाउनु</h3>
                <p>45以上の通貨・70以上の国・地域へ、現地通貨で送金できます。<br><span class="ne">४५ भन्दा बढी मुद्रा, ७० भन्दा बढी देश・क्षेत्रमा स्थानीय मुद्रामा पठाउन सकिन्छ।</span></p>
            </div>
            <div class="remittance-feature-card">
                <div class="remittance-feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3>口座で保有 / खातामा राख्नु</h3>
                <p>40以上の通貨をWise口座で保有・両替できます。<br><span class="ne">४० भन्दा बढी मुद्रा Wise खातामा राख्न र विनिमय गर्न सकिन्छ।</span></p>
            </div>
            <div class="remittance-feature-card">
                <div class="remittance-feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3>カードで支払い / कार्डले तिर्नु</h3>
                <p>150以上の国・地域で、Wiseデビットカードを使って支払いやATM出金ができます。<br><span class="ne">१५० भन्दा बढी देश・क्षेत्रमा Wise डेबिट कार्डले तिर्न र ATM बाट निकासी गर्न सकिन्छ।</span></p>
            </div>
            <div class="remittance-feature-card">
                <div class="remittance-feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5H4a1 1 0 00-1 1v12a1 1 0 001 1h16a1 1 0 001-1V7a1 1 0 00-1-1h-3z"/></svg>
                </div>
                <h3>受け取り口座 / प्राप्ति खाता</h3>
                <p>11通貨分の受取用口座番号（例：USD・GBP・EUR）を取得し、海外から送金を受け取れます。<br><span class="ne">११ मुद्राको लागि प्राप्ति खाता नम्बर (उदाहरण: USD・GBP・EUR) लिन सकिन्छ, विदेशबाट पठाइ प्राप्त गर्न सकिन्छ।</span></p>
            </div>
        </div>
    </section>

    {{-- Stats strip：数字と意味を1文で --}}
    <div class="remittance-stats">
        <div class="remittance-stat">
            <p class="remittance-stat-value">74%</p>
            <p class="remittance-stat-label">送金の74%が20秒以内に到着<br><span class="ne">पठाइको ७४% २० सेकेन्ड भित्र पुग्छ</span></p>
        </div>
        <div class="remittance-stat">
            <p class="remittance-stat-value">45+</p>
            <p class="remittance-stat-label">45以上の通貨へ送金可能<br><span class="ne">४५ भन्दा बढी मुद्रामा पठाउन सकिन्छ</span></p>
        </div>
        <div class="remittance-stat">
            <p class="remittance-stat-value">40+</p>
            <p class="remittance-stat-label">40以上の通貨を口座で保有可能<br><span class="ne">४० भन्दा बढी मुद्रा खातामा राख्न सकिन्छ</span></p>
        </div>
        <div class="remittance-stat">
            <p class="remittance-stat-value">150+</p>
            <p class="remittance-stat-label">150以上の国・地域で利用可能<br><span class="ne">१५० भन्दा बढी देश・क्षेत्रमा उपलब्ध</span></p>
        </div>
    </div>

    {{-- Transparent fees + image --}}
    <section class="remittance-section remittance-section-fees">
        <h2 class="remittance-section-title">手数料が透明 / शुल्क पारदर्शी</h2>
        <p class="remittance-section-sub">為替レートに隠れた上乗せをせず、事前に手数料が分かります。<br><span class="remittance-section-sub-ne">विनिमय दरमा लुकेको मार्कअप छैन, शुल्क अग्रिममा थाहा हुन्छ।</span></p>
        <div class="remittance-two-col">
            <div>
                <p style="color: var(--wise-text); line-height: 1.8; margin: 0 0 16px;">銀行や一部の送金サービスでは、為替レートにマークアップを加えて利益を得ています。Wiseは中間レートに近いレートと、事前に表示される少額の手数料で送金できます。</p>
                <p style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; color: var(--wise-text-muted); font-size: 0.9375rem; line-height: 1.7; margin: 0 0 16px;">बैंक र केही पठाइ सेवाहरूले विनिमय दरमा मार्कअप थपेर नाफा लिन्छन्। Wise ले मध्य बजार दर नजिकको दर र अग्रिममा देखाइने सानो शुल्कमा पठाउन सकिन्छ।</p>
                <p style="color: var(--wise-text-muted); font-size: 0.9375rem; line-height: 1.7; margin: 0;">USD・GBPなどSWIFT送金でも、隠れた費用に驚くことなく、多くの送金が24時間以内に届く設計です。</p>
                <p style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; color: var(--wise-text-muted); font-size: 0.9375rem; line-height: 1.7; margin: 0;">USD・GBP आदि SWIFT पठाइमा पनि लुकेको लागत छैन, धेरै पठाइ २४ घण्टा भित्र पुग्ने डिजाइन।</p>
            </div>
            <div class="remittance-img-wrap">
                <img src="{{ asset('images/remittance-fees.webp') }}" alt="手数料・為替比較" width="400" height="300" loading="lazy" class="remittance-section-img">
            </div>
        </div>
    </section>

    {{-- Security & Trust --}}
    <section class="remittance-section remittance-section-security">
        <h2 class="remittance-section-title">セキュリティと信頼 / सुरक्षा र विश्वास</h2>
        <p class="remittance-section-sub">お金を預けるサービスとして、規制とサポート体制を紹介します。<br><span class="remittance-section-sub-ne">पैसा राख्ने सेवाको रूपमा नियमन र सहयोग परिचय।</span></p>
        <div class="remittance-two-col">
            <div>
                <ul class="remittance-list">
                    <li>
                        <svg class="remittance-list-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>日本では関東財務局の登録を受けた資金移動業者として運営されています。<br><span class="ne">जापानमा कान्तो वित्तीय ब्युरोको दर्ता भएको कोष स्थानान्तरण व्यवसायको रूपमा सञ्चालन गरिन्छ।</span></span>
                    </li>
                    <li>
                        <svg class="remittance-list-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a2 2 0 00-2-2H4a2 2 0 00-2 2v2h12z"/></svg>
                        <span>2段階認証（2FA）でアカウントを保護。資金は規制対象の金融機関に預けています。<br><span class="ne">२ चरण प्रमाणीकरण (२FA) ले खाता सुरक्षित। कोष नियमन अन्तर्गतको वित्तीय संस्थामा राखिन्छ।</span></span>
                    </li>
                    <li>
                        <svg class="remittance-list-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>メール・電話・チャットで24時間、サポートが利用できます。<br><span class="ne">इमेल・फोन・च्याटमार्फत २४ घण्टा सहयोग उपलब्ध छ।</span></span>
                    </li>
                </ul>
            </div>
            <div class="remittance-img-wrap">
                <img src="{{ asset('images/remittance-security.webp') }}" alt="セキュリティと信頼 / सुरक्षा र विश्वास" width="320" height="240" loading="lazy" class="remittance-section-img">
            </div>
        </div>
        <p style="text-align: center; color: var(--wise-text-muted); font-size: 0.9375rem; margin-top: 24px;">世界中の個人・法人顧客が、毎月多額の送金にWiseを利用しています。<br><span class="ne" style="display: block; margin-top: 6px;">विश्वभरि व्यक्तिगत र व्यावसायिक ग्राहकहरूले हरेक महिना ठूलो रकम Wise मार्फत पठाउँछन्।</span></p>
    </section>

    {{-- CTA --}}
    <section class="remittance-cta-section">
        <div class="remittance-cta-card">
            <a href="https://wise.prf.hn/click/camref:1101l5CK5N/creativeref:1011l101119" target="_blank" rel="noopener noreferrer sponsored" class="remittance-cta-logo">
                <img src="https://wise-creative.prf.hn/source/camref:1101l5CK5N/creativeref:1011l101119" width="120" height="120" alt="Wise">
            </a>
            <h2>詳しくはWise公式サイトで / बिस्तृत Wise आधिकारिक साइटमा</h2>
            <p class="remittance-cta-desc">手数料や対応通貨・国は公式サイトで最新情報をご確認ください。<br><span class="ne">शुल्क र समर्थित मुद्रा・देशको लागि आधिकारिक साइटमा नवीनतम जानकारी हेर्नुहोस्।</span></p>
            <a href="https://wise.prf.hn/click/camref:1101l5CK5N" target="_blank" rel="noopener noreferrer sponsored" class="remittance-cta-btn">
                公式サイトを開く / आधिकारिक साइट खोल्नुहोस्
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </section>

    <p class="remittance-disclaimer">
        就労支援サービスはWiseパートナーシッププログラムのパートナーです。<br>
        <span style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; display: block; margin-top: 8px;">रोजगार सहायता सेवा Wise पार्टनरशिप कार्यक्रमको पार्टनर हो।</span>
    </p>
</div>
@endsection
