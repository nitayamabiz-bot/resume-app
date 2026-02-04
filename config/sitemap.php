<?php

$baseUrl = env('SITEMAP_BASE_URL') ?: 'https://hamro-life-japan.com';
// 本番インデックス用：localhost が含まれる場合は本番URLに固定（Cron・キャッシュに依存しない）
if ($baseUrl === '' || str_contains((string) $baseUrl, 'localhost')) {
    $baseUrl = 'https://hamro-life-japan.com';
}

return [

    /*
    |--------------------------------------------------------------------------
    | Sitemap Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL used when generating sitemap.xml. Should match the
    | canonical production URL (e.g. https://hamro-life-japan.com).
    | Used by the sitemap:generate Artisan command.
    | localhost が含まれる場合は無視し、本番 URL を使用します（Google 登録用）。
    |
    */

    'base_url' => $baseUrl,

];
