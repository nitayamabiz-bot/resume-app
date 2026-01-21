<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class RecaptchaHelper
{
    /**
     * reCAPTCHAを検証
     */
    public static function verify(string $token): bool
    {
        $secretKey = config('recaptcha.secret_key');

        if (empty($secretKey)) {
            // 開発環境などでキーが設定されていない場合は検証をスキップ
            return true;
        }

        $response = Http::asForm()->post(config('recaptcha.verify_url'), [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();

        return isset($result['success']) && $result['success'] === true;
    }
}
