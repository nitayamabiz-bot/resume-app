<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Chrome/Chromium Path
    |--------------------------------------------------------------------------
    |
    | Browsershotで使用するChrome/Chromiumのパスを指定します。
    | 環境変数 BROWSERSHOT_CHROME_PATH で設定することもできます。
    |
    | Windows例: 'C:\Program Files\Google\Chrome\Application\chrome.exe'
    | Linux例: '/usr/bin/google-chrome' または '/usr/bin/chromium-browser'
    | macOS例: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'
    |
    */
    'chrome_path' => env('BROWSERSHOT_CHROME_PATH', null),
];

