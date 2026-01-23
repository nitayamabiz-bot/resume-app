@extends('layouts.main')

@section('title', 'お問い合わせ - 就労支援サービス')

@section('description', '就労支援サービスへのお問い合わせページ。ご質問やご要望がございましたら、お気軽にお問い合わせください。日本語・ネパール語対応。')

@section('keywords', 'ネパール,お問い合わせ,問い合わせ,サポート,ヘルプ')

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
        margin: 0 auto 2em;
        text-align: left;
    }
    .page-text-nepali {
        display: block;
        margin-top: 12px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-align: left;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #222;
        font-size: 0.95rem;
    }
    .form-label-nepali {
        display: block;
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 4px;
        font-family: 'Noto Sans Devanagari', Arial, sans-serif;
    }
    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
        box-sizing: border-box;
        font-family: inherit;
    }
    .form-textarea {
        min-height: 200px;
        resize: vertical;
    }
    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: #1160E6;
        box-shadow: 0 0 0 3px rgba(17, 96, 230, 0.1);
    }
    .required {
        color: #ef4444;
        margin-left: 4px;
    }
    .submit-btn {
        width: 100%;
        background-color: #1160E6;
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 8px;
    }
    .submit-btn:hover {
        background-color: #0346b0;
    }
    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    .error-message {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    .user-info {
        background-color: #f0f4ff;
        border: 1px solid #cbd5e1;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 24px;
    }
    .user-info-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 4px;
    }
    .user-info-value {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
    }
    .warning-text {
        color: #ef4444;
        font-size: 0.9rem;
        margin-top: 0.5em;
    }
</style>
<div class="page-content">
    <h1 class="page-heading">
        お問い合わせ
        <span class="page-heading-nepali">सम्पर्क</span>
    </h1>
    <div class="page-text">
        @if($user)
        ご質問やご意見がございましたら、以下のフォームよりお気軽にお問い合わせください。<br>
        会員ログイン中のため、登録済みの情報でお問い合わせいたします。<br>
        会員ログイン中のお問い合わせは返信可能です。タイトルと内容は日本語・ネパール語どちらでも構いません。
        <span class="page-text-nepali">
            <br>यदि तपाईंको प्रश्न वा सुझावहरू छन् भने, कृपया तलको फारमबाट सम्पर्क गर्नुहोस्।<br>
            तपाईं सदस्य लगइनमा हुनुहुन्छ, रेजिस्टर गरिएको जानकारीबाट सम्पर्क गरिनेछ।<br>
            सदस्य लगइनमा रहेका सम्पर्कहरूका लागि जवाफ दिन सकिन्छ। शीर्षक र सामग्री जापानी वा नेपाली दुवै हुन सक्छ।
        </span>
        @else
        ご質問やご意見がございましたら、以下のフォームよりお気軽にお問い合わせください。<br>
        タイトルと本文は日本語・ネパール語どちらでもご記入いただけます。
        <span class="page-text-nepali">यदि तपाईंको प्रश्न वा सुझावहरू छन् भने, कृपया तलको फारमबाट सम्पर्क गर्नुहोस्। शीर्षक र मुख्य पाठ जापानी वा नेपाली दुवैमा लेख्न सकिन्छ।</span>
        @endif
        <div class="warning-text">
            ※ 不正なリクエスト、いたずら目的の送信は送信元を特定して開示請求など法的処置をとる場合があります。<span class="page-text-nepali" style="color: #ef4444; font-size: 0.9rem;"> ※ गलत अनुरोध, दुरुपयोगको लागि पठाउनेहरूको लागि पठाउने स्रोत पहिचान गरेर खुलासा अनुरोध लगायत कानुनी कारबाही गर्न सकिन्छ।</span>
        </div>
    </div>

    <div class="form-container">
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
                <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">सम्पर्क स्वीकार गरियो। धन्यवाद।</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($user)
        <div class="user-info">
            <div class="user-info-label">お名前 / नाम</div>
            <div class="user-info-value">{{ $user->name }}</div>
        </div>
        <div class="user-info">
            <div class="user-info-label">メールアドレス / इमेल ठेगाना</div>
            <div class="user-info-value">{{ $user->email }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            
            @if(!$user)
            <div class="form-group">
                <label class="form-label">
                    お名前<span class="required">*</span>
                    <span class="form-label-nepali">नाम</span>
                </label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    メールアドレス<span class="required">*</span>
                    <span class="form-label-nepali">इमेल ठेगाना</span>
                </label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">
                    タイトル<span class="required">*</span>
                    <span class="form-label-nepali">शीर्षक</span>
                </label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    内容<span class="required">*</span>
                    <span class="form-label-nepali">सामग्री</span>
                </label>
                <textarea name="message" class="form-textarea" required>{{ old('message') }}</textarea>
            </div>

            @if($recaptcha_site_key)
            <div class="form-group" style="display: flex; justify-content: center;">
                <div class="g-recaptcha" data-sitekey="{{ $recaptcha_site_key }}"></div>
            </div>
            @endif
            @error('g-recaptcha-response')
                <div class="text-red-500 text-sm mt-1 text-center">{{ $message }}</div>
            @enderror

            <button type="submit" class="submit-btn">
                送信する
                <span class="block text-sm mt-1" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif; opacity: 0.9;">पठाउनुहोस्</span>
            </button>
        </form>
    </div>
</div>
@if($recaptcha_site_key)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route("contact.store") }}"]');
    const recaptchaSiteKey = @json($recaptcha_site_key);
    
    if (form && recaptchaSiteKey) {
        form.addEventListener('submit', function(e) {
            const recaptchaResponse = document.querySelector('[name="g-recaptcha-response"]')?.value || '';
            
            if (!recaptchaResponse) {
                e.preventDefault();
                alert('セキュリティチェックを確認してください。 / सुरक्षा जाँच पुष्टि गर्नुहोस्।');
                return false;
            }
        });
    }
});
</script>
@endif
@endsection
