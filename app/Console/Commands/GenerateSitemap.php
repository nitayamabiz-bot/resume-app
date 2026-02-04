<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for Google Search Console';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $baseUrl = rtrim((string) config('sitemap.base_url'), '/');
        // 本番インデックス用：localhost が含まれる場合は本番URLに固定（Cron・サーバー環境に依存しない）
        if ($baseUrl === '' || str_contains($baseUrl, 'localhost')) {
            $baseUrl = 'https://hamro-life-japan.com';
        }

        $now = now()->toAtomString();

        // 公開ページのみを含める（404やリダイレクトするページは除外）
        $routes = [
            ['name' => 'home', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['name' => 'admin-procedures.index', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['name' => 'resume.index', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'career-history.index', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'job', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['name' => 'parttime', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['name' => 'rental', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'internet', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'sim', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'campaign', 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['name' => 'remittance', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'contact.create', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['name' => 'advertisement.create', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['name' => 'privacy-policy', 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        $urls = [];
        foreach ($routes as $r) {
            $path = parse_url(route($r['name']), PHP_URL_PATH) ?? '/';
            // パスの先頭スラッシュを確保し、末尾スラッシュは削除（トップページ以外）
            $path = $path === '/' ? '/' : rtrim($path, '/');
            $loc = $baseUrl.$path;
            $urls[] = ['loc' => $loc, 'priority' => $r['priority'], 'changefreq' => $r['changefreq']];
        }

        // XMLの生成（余計な空白や改行を避け、正しい形式で出力）
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>'."\n";
            $xml .= '    <lastmod>'.$now.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
            $xml .= '    <xhtml:link rel="alternate" hreflang="ja" href="'.htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'" />'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>'."\n";

        $path = public_path('sitemap.xml');
        File::put($path, $xml);

        $this->info('Sitemap generated successfully at: '.$path);

        return Command::SUCCESS;
    }
}
