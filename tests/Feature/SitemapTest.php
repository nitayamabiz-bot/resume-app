<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    config(['sitemap.base_url' => 'https://hamro-life-japan.com']);
});

it('generates sitemap.xml with base URL and all public pages', function () {
    Artisan::call('sitemap:generate');

    $path = public_path('sitemap.xml');
    expect(File::exists($path))->toBeTrue();

    $xml = File::get($path);
    expect($xml)
        ->toContain('https://hamro-life-japan.com')
        ->toContain('<urlset ')
        ->toContain('</urlset>')
        ->toContain('https://hamro-life-japan.com/')
        ->toContain('https://hamro-life-japan.com/admin-procedures')
        ->toContain('https://hamro-life-japan.com/resume')
        ->toContain('https://hamro-life-japan.com/contact')
        ->toContain('https://hamro-life-japan.com/privacy-policy')
        ->toContain('hreflang="ja"');
});

it('serves sitemap.xml with correct content type when file exists', function () {
    Artisan::call('sitemap:generate');

    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertSee('https://hamro-life-japan.com', false);
});

it('returns 404 when sitemap.xml does not exist', function () {
    $path = public_path('sitemap.xml');
    if (File::exists($path)) {
        File::delete($path);
    }

    $response = $this->get('/sitemap.xml');

    $response->assertNotFound();
});
