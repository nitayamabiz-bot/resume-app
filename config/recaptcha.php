<?php

return [
    'site_key' => (function () {
        $iniPath = config_path('api_keys.ini');
        if (function_exists('parse_ini_file') && file_exists($iniPath)) {
            $ini = @parse_ini_file($iniPath, true);
            if ($ini !== false && isset($ini['recaptcha']['site_key']) && ! empty($ini['recaptcha']['site_key'])) {
                return $ini['recaptcha']['site_key'];
            }
        }
        return '';
    })(),
    'secret_key' => (function () {
        $iniPath = config_path('api_keys.ini');
        if (function_exists('parse_ini_file') && file_exists($iniPath)) {
            $ini = @parse_ini_file($iniPath, true);
            if ($ini !== false && isset($ini['recaptcha']['secret_key']) && ! empty($ini['recaptcha']['secret_key'])) {
                return $ini['recaptcha']['secret_key'];
            }
        }
        return '';
    })(),
    'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
];
