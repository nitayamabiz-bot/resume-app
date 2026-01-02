@extends('layouts.main')

@section('title', 'プライバシーポリシー - 就労支援サービス')

@section('content')
<style>
    .privacy-policy-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .privacy-policy-title {
        font-size: 2rem;
        font-weight: 600;
        color: #1f2937;
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .language-switcher {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    
    .language-btn {
        padding: 8px 16px;
        border: 2px solid #3b82f6;
        background-color: #ffffff;
        color: #3b82f6;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .language-btn:hover {
        background-color: #eff6ff;
    }
    
    .language-btn.active {
        background-color: #3b82f6;
        color: #ffffff;
    }
    
    .title-japanese {
        display: block;
    }
    
    .title-nepali {
        display: none;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    
    .title-nepali.show {
        display: block;
    }
    
    .title-japanese.hide {
        display: none;
    }
    
    .content-japanese {
        display: block;
    }
    
    .content-nepali {
        display: none;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    
    .content-nepali.show {
        display: block;
    }
    
    .content-japanese.hide {
        display: none;
    }
    
    .privacy-policy-content {
        color: #374151;
        line-height: 1.8;
        font-size: 0.95rem;
    }
    
    .privacy-policy-content p {
        margin-bottom: 1rem;
    }
    
    .privacy-policy-content h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .privacy-policy-content ul {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
        list-style-type: disc;
    }
    
    .privacy-policy-content li {
        margin-bottom: 0.5rem;
    }
    
    .privacy-policy-content strong {
        color: #1f2937;
        font-weight: 600;
    }
    
    .privacy-policy-contact {
        background-color: #f9fafb;
        padding: 1.5rem;
        border-radius: 6px;
        margin-top: 2rem;
        border-left: 4px solid #3b82f6;
    }
    
    .privacy-policy-contact h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .privacy-policy-contact p {
        margin-bottom: 0.5rem;
    }
    
    .privacy-policy-date {
        text-align: right;
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }
    
    @media (max-width: 700px) {
        .privacy-policy-container {
            padding: 20px 16px;
        }
        
        .privacy-policy-title {
            font-size: 1.5rem;
        }
        
        .privacy-policy-content h2 {
            font-size: 1.25rem;
        }
    }
</style>

<div class="privacy-policy-container">
    <div class="language-switcher">
        <button class="language-btn active" onclick="switchLanguage('ja')" id="btn-ja">日本語</button>
        <button class="language-btn" onclick="switchLanguage('ne')" id="btn-ne">नेपाली</button>
    </div>
    <h1 class="privacy-policy-title">
        <span class="title-japanese">プライバシーポリシー</span>
        <span class="title-nepali">गोपनीयता नीति</span>
    </h1>
    
    <div class="privacy-policy-content">
        <!-- 日本語版 -->
        <div class="content-japanese">
            <p>
                就労支援サービス事務局（以下、「当事務局」といいます。）は、本ウェブサイト上で提供するサービス（以下、「本サービス」といいます。）における、ユーザーの個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」といいます。）を定めます。
            </p>
            
            <h2>第1条（個人情報の定義）</h2>
            <p>
                「個人情報」とは、個人情報保護法にいう「個人情報」を指すものとし、生存する個人に関する情報であって、当該情報に含まれる氏名、生年月日、住所、電話番号、連絡先その他の記述等により特定の個人を識別できる情報、および容貌、指紋、声紋にかかるデータ、および健康保険証の保険者番号などの当該情報単体から特定の個人を識別できる情報（個人識別符号）を指します。
            </p>
            
            <h2>第2条（個人情報の収集方法）</h2>
            <p>
                当事務局は、ユーザーが本サービスを利用する際、会員登録や書類作成機能の利用において個人情報を保持することがあります。
            </p>
            
            <h2>第3条（個人情報を収集・利用する目的）</h2>
            <p>
                当事務局が個人情報を収集・利用する目的は、以下のとおりです。
            </p>
            <ul>
                <li>ユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）</li>
                <li>ユーザーが利用中のサービスの新機能、更新情報、キャンペーン等および当事務局が提供する他のサービスの案内をメール等で送付するため</li>
                <li>利用規約に違反したユーザーや、不正・不当な目的でサービスを利用しようとするユーザーの特定をおこない、利用をお断りするため</li>
                <li>上記の利用目的に付随する目的</li>
            </ul>
            
            <h2>第4条（利用目的の変更）</h2>
            <p>
                当事務局は、利用目的が変更前と関連性を有すると合理的に認められる場合に限り、個人情報の利用目的を変更するものとします。変更を行った場合には、本ウェブサイト上に公表します。
            </p>
            
            <h2>第5条（個人情報の第三者提供）</h2>
            <p>
                当事務局は、次に掲げる場合を除いて、あらかじめユーザーの同意を得ることなく、第三者に個人情報を提供することはありません。ただし、個人情報保護法その他の法令で認められる場合を除きます。
            </p>
            <ul>
                <li>人の生命、身体または財産の保護のために必要がある場合であって、本人の同意を得ることが困難であるとき</li>
                <li>公衆衛生の向上または児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難であるとき</li>
                <li>国の機関もしくは地方公共団体またはその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがあるとき</li>
            </ul>
            
            <h2>第6条（個人情報の開示・訂正・利用停止等）</h2>
            <p>
                ユーザー本人から個人情報の開示、訂正、追加、削除、利用の停止を求められたときは、遅滞なく本人確認を行い、これに対応します。
            </p>
            
            <h2>第7条（アクセス解析ツールについて）</h2>
            <p>
                本サービスでは、Googleによるアクセス解析ツール「Googleアナリティクス」を利用しています。このGoogleアナリティクスはトラフィックデータの収集のためにクッキー（Cookie）を使用しています。このトラフィックデータは匿名で収集されており、個人を特定するものではありません。
            </p>
            
            <h2>第8条（免責事項）</h2>
            <p>
                本サービスからリンクやバナーなどによって他のサイトに移動された場合、移動先サイトで提供される情報、サービス等について一切の責任を負いません。また、本サービスのコンテンツ・情報について、可能な限り正確な情報を掲載するよう努めておりますが、誤情報が入り込んだり、情報が古くなっていることもございます。本サービスに掲載された内容によって生じた損害等の一切の責任を負いかねますのでご了承ください。
            </p>
            
            <h2>第9条（お問い合わせ窓口）</h2>
            <div class="privacy-policy-contact">
                <h3>お問い合わせ窓口</h3>
                <p><strong>運営者：</strong>就労支援サービス事務局</p>
                <p><strong>お問い合わせ先：</strong><a href="mailto:info@hamro-life-japan.com" class="text-blue-600 hover:text-blue-800 underline">info@hamro-life-japan.com</a></p>
            </div>
            
            <div class="privacy-policy-date">
                制定日：2026年1月3日
            </div>
        </div>
        
        <!-- ネパール語版 -->
        <div class="content-nepali">
            <p>
                रोजगार सहायता सेवा सचिवालय (यसपछि "सचिवालय" भनिनेछ) ले यस वेबसाइटमा प्रदान गरिने सेवाहरूमा (यसपछि "सेवा" भनिनेछ) प्रयोगकर्ताको व्यक्तिगत जानकारीको ह्यान्डलिंगको सम्बन्धमा निम्नुसार गोपनीयता नीति (यसपछि "नीति" भनिनेछ) निर्धारण गर्दछ।
            </p>
            
            <h2>धारा १ (व्यक्तिगत जानकारीको परिभाषा)</h2>
            <p>
                "व्यक्तिगत जानकारी" भन्नाले व्यक्तिगत जानकारी संरक्षण ऐनमा उल्लेख गरिएको "व्यक्तिगत जानकारी" लाई जनाउँछ। यसले जीवित व्यक्तिको बारेमा जानकारीलाई जनाउँछ, जसमा नाम, जन्म मिति, ठेगाना, फोन नम्बर, सम्पर्क जानकारी, र अन्य विवरणहरू मार्फत विशिष्ट व्यक्ति पहिचान गर्न सकिने जानकारी, साथै उपस्थिति, औंठाछाप, आवाजको छापसँग सम्बन्धित डाटा, र स्वास्थ्य बीमा कार्डको बीमाकर्ता नम्बर जस्ता एकल जानकारीबाट विशिष्ट व्यक्ति पहिचान गर्न सकिने जानकारी (व्यक्तिगत पहिचान कोड) समावेश हुन्छ।
            </p>
            
            <h2>धारा २ (व्यक्तिगत जानकारी सङ्कलन गर्ने विधि)</h2>
            <p>
                प्रयोगकर्ताले यस सेवाको प्रयोग गर्दा, सदस्य दर्ता वा कागजात निर्माण कार्यको प्रयोगको क्रममा सचिवालयले व्यक्तिगत जानकारी राख्न सक्छ।
            </p>
            
            <h2>धारा ३ (व्यक्तिगत जानकारी सङ्कलन र प्रयोग गर्नुको उद्देश्य)</h2>
            <p>
                सचिवालयले व्यक्तिगत जानकारी सङ्कलन र प्रयोग गर्नुको उद्देश्य निम्नानुसार छ:
            </p>
            <ul>
                <li>प्रयोगकर्ताका सोधपुछको जवाफ दिन (पहिचान प्रमाणीकरण सहित)।</li>
                <li>प्रयोगकर्ताले प्रयोग गरिरहेको सेवाका नयाँ सुविधाहरू, अपडेट जानकारी, अभियानहरू, र सचिवालयले प्रदान गर्ने अन्य सेवाहरूको जानकारी इमेल मार्फत पठाउन।</li>
                <li>प्रयोगका सर्तहरू उल्लङ्घन गर्ने वा धोखाधडी/अनुचित उद्देश्यका लागि सेवा प्रयोग गर्न खोज्ने प्रयोगकर्ताहरूलाई पहिचान गर्न र तिनीहरूको प्रयोग अस्वीकार गर्न।</li>
                <li>माथिका प्रयोगका उद्देश्यहरूसँग सम्बन्धित उद्देश्यहरूका लागि।</li>
            </ul>
            
            <h2>धारा ४ (प्रयोगको उद्देश्यमा परिवर्तन)</h2>
            <p>
                सचिवालयले व्यक्तिगत जानकारीको प्रयोगको उद्देश्यमा परिवर्तन गर्नेछ यदि परिवर्तन अघिको उद्देश्यसँग तर्कसंगत रूपमा सम्बन्धित छ भने मात्र। परिवर्तन गरिएको खण्डमा, यस वेबसाइटमा सार्वजनिक गरिनेछ।
            </p>
            
            <h2>धारा ५ (तेस्रो पक्षलाई व्यक्तिगत जानकारी प्रदान गर्ने)</h2>
            <p>
                सचिवालयले निम्न अवस्थामा बाहेक प्रयोगकर्ताको पूर्व सहमति बिना तेस्रो पक्षलाई व्यक्तिगत जानकारी प्रदान गर्ने छैन। तर, व्यक्तिगत जानकारी संरक्षण ऐन वा अन्य कानुनले अनुमति दिएका अवस्थाहरूमा यो लागू हुने छैन।
            </p>
            <ul>
                <li>व्यक्तिको जीवन, शरीर वा सम्पत्तिको सुरक्षाको लागि आवश्यक परेको बेला र व्यक्तिको सहमति प्राप्त गर्न गाह्रो भएको अवस्थामा।</li>
                <li>जनस्वास्थ्यको सुधार वा बालबालिकाको स्वस्थ विकासको प्रवर्द्धनका लागि विशेष रूपमा आवश्यक परेको बेला र व्यक्तिको सहमति प्राप्त गर्न गाह्रो भएको अवस्थामा।</li>
                <li>राष्ट्रिय निकाय वा स्थानीय सार्वजनिक निकाय वा तिनीहरूबाट नियुक्त व्यक्तिले कानुनद्वारा निर्धारित मामिलाहरू पूरा गर्न सहयोग गर्नुपर्ने अवस्थामा र व्यक्तिको सहमतिले उक्त कार्य सम्पादनमा बाधा पुर्‍याउने जोखिम भएको अवस्थामा।</li>
            </ul>
            
            <h2>धारा ६ (व्यक्तिगत जानकारीको खुलासा, सुधार, र प्रयोग रोक्ने)</h2>
            <p>
                यदि प्रयोगकर्ता आफैंले व्यक्तिगत जानकारीको खुलासा, सुधार, थप, मेटाउने वा प्रयोग रोक्न अनुरोध गरेमा, हामी ढिलाइ नगरी पहिचान प्रमाणीकरण गरी यसको सम्बोधन गर्नेछौँ।
            </p>
            
            <h2>धारा ७ (पहुँच विश्लेषण उपकरणको बारेमा)</h2>
            <p>
                यस सेवाले Google द्वारा प्रदान गरिएको पहुँच विश्लेषण उपकरण "Google Analytics" प्रयोग गर्दछ। Google Analytics ले ट्राफिक डाटा सङ्कलन गर्न कुकीहरू (Cookies) प्रयोग गर्दछ। यो ट्राफिक डाटा अज्ञात रूपमा सङ्कलन गरिन्छ र यसले व्यक्तिगत पहिचान गर्दैन।
            </p>
            
            <h2>धारा ८ (अस्वीकरण - Disclaimer)</h2>
            <p>
                यस सेवाबाट लिंक वा ब्यानर आदि मार्फत अन्य साइटमा जाँदा, गन्तव्य साइटमा प्रदान गरिएको जानकारी, सेवा आदिमा हामी कुनै पनि जिम्मेवारी लिने छैनौँ। साथै, यस सेवाको सामग्री र जानकारीको सन्दर्भमा सम्भव भएसम्म सही जानकारी पोस्ट गर्ने प्रयास गरिएको छ, तर गलत जानकारी समावेश हुन सक्छ वा जानकारी पुरानो हुन सक्छ। यस सेवामा पोस्ट गरिएका सामग्रीहरूबाट हुने कुनै पनि क्षतिको लागि हामी जिम्मेवार हुने छैनौँ।
            </p>
            
            <h2>धारा ९ (सम्पर्क विन्दु)</h2>
            <div class="privacy-policy-contact">
                <h3>सम्पर्क विन्दु</h3>
                <p><strong>सञ्चालक:</strong> रोजगार सहायता सेवा सचिवालय</p>
                <p><strong>सम्पर्क ठेगाना:</strong><a href="mailto:info@hamro-life-japan.com" class="text-blue-600 hover:text-blue-800 underline">info@hamro-life-japan.com</a></p>
            </div>
            
            <div class="privacy-policy-date">
                制定日：2026年1月3日
            </div>
        </div>
    </div>
</div>

<script>
    function switchLanguage(lang) {
        const titleJapanese = document.querySelector('.title-japanese');
        const titleNepali = document.querySelector('.title-nepali');
        const contentJapanese = document.querySelector('.content-japanese');
        const contentNepali = document.querySelector('.content-nepali');
        const btnJa = document.getElementById('btn-ja');
        const btnNe = document.getElementById('btn-ne');
        
        if (lang === 'ja') {
            // タイトルの切り替え
            titleJapanese.classList.remove('hide');
            titleJapanese.style.display = 'block';
            titleNepali.classList.remove('show');
            titleNepali.style.display = 'none';
            // コンテンツの切り替え
            contentJapanese.classList.remove('hide');
            contentJapanese.style.display = 'block';
            contentNepali.classList.remove('show');
            contentNepali.style.display = 'none';
            // ボタンの切り替え
            btnJa.classList.add('active');
            btnNe.classList.remove('active');
        } else {
            // タイトルの切り替え
            titleJapanese.classList.add('hide');
            titleJapanese.style.display = 'none';
            titleNepali.classList.add('show');
            titleNepali.style.display = 'block';
            // コンテンツの切り替え
            contentJapanese.classList.add('hide');
            contentJapanese.style.display = 'none';
            contentNepali.classList.add('show');
            contentNepali.style.display = 'block';
            // ボタンの切り替え
            btnJa.classList.remove('active');
            btnNe.classList.add('active');
        }
    }
</script>
@endsection

