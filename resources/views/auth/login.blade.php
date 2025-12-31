<x-guest-layout title="ログイン / लगइन - 就労支援サービス">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email">
                メールアドレス / इमेल ठेगाना
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
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
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">ログイン状態を保持する<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">लगइन अवस्था राख्नुहोस्</span></span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    パスワードを忘れた場合<span class="block text-xs" style="font-family: 'Noto Sans Devanagari', Arial, sans-serif;">पासवर्ड बिर्सनुभयो?</span>
                </a>
            @endif

            <x-primary-button class="ms-3">
                ログイン / लगइन
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
