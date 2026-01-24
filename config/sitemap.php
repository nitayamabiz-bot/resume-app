<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sitemap Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL used when generating sitemap.xml. Should match the
    | canonical production URL (e.g. https://hamro-life-japan.com).
    | Used by the sitemap:generate Artisan command.
    |
    */

    'base_url' => env('SITEMAP_BASE_URL') ?: 'https://hamro-life-japan.com',

];
