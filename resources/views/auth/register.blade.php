<x-guest-layout title="新規登録 / दर्ता - 就労支援サービス">
    <!-- 戻るボタン -->
    <div class="mb-4">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            戻る / फिर्ता
        </a>
    </div>

    <!-- 説明文 -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-gray-700" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">
            सदस्यता दर्ता सजिलो र निःशुल्क छ। लगइन गरेपछि, तपाईंको बायोडाटा र कामको अनुभवको जानकारीहरू सेभ गर्न सकिन्छ र जुनसुकै समयमा सम्पादन गर्न सकिन्छ।
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name">
                お名前 / नाम
            </x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email">
                メールアドレス / इमेल ठेगाना
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password">
                パスワード / पासवर्ड
            </x-input-label>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation">
                パスワード確認 / पासवर्ड पुष्टि
            </x-input-label>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        @if($recaptcha_site_key ?? false)
        <div class="mt-4 flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ $recaptcha_site_key }}"></div>
        </div>
        <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                既に登録済みですか？<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">पहिले नै दर्ता भएको छ?</span>
            </a>

            <x-primary-button class="ms-4" id="register-button">
                登録 / दर्ता
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const registerButton = document.getElementById('register-button');
            let isSubmitting = false;

            // フォーム送信をインターセプトして二重送信を防止
            form.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }

                isSubmitting = true;
                registerButton.disabled = true;
                registerButton.innerHTML = '登録中... / दर्ता गर्दै...';

                // フォームが正常に送信されなかった場合（エラーなど）にボタンを再有効化
                setTimeout(function() {
                    if (isSubmitting) {
                        isSubmitting = false;
                        registerButton.disabled = false;
                        registerButton.innerHTML = '登録 / दर्ता';
                    }
                }, 5000);
            });
        });
    </script>
    @if($recaptcha_site_key ?? false)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</x-guest-layout>
