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
        $baseUrl = rtrim(config('sitemap.base_url'), '/');

        $now = now()->toAtomString();

        $routes = [
            ['name' => 'home', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['name' => 'admin-procedures.index', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['name' => 'resume.index', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'resume.create', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'career-history.index', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'career-history.create', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['name' => 'job', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['name' => 'parttime', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['name' => 'rental', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'internet', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'sim', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['name' => 'campaign', 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['name' => 'privacy-policy', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['name' => 'contact.create', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['name' => 'advertisement.create', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['name' => 'coming-soon', 'priority' => '0.4', 'changefreq' => 'monthly'],
            ['name' => 'work-permit', 'priority' => '0.4', 'changefreq' => 'monthly'],
        ];

        $urls = [];
        foreach ($routes as $r) {
            $path = parse_url(route($r['name']), PHP_URL_PATH) ?? '/';
            $loc = $baseUrl.$path;
            $urls[] = ['loc' => $loc, 'priority' => $r['priority'], 'changefreq' => $r['changefreq']];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($url['loc']).'</loc>'."\n";
            $xml .= '    <lastmod>'.$now.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
            $xml .= '    <xhtml:link rel="alternate" hreflang="ja" href="'.htmlspecialchars($url['loc']).'" />'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        $path = public_path('sitemap.xml');
        File::put($path, $xml);

        $this->info('Sitemap generated successfully at: '.$path);

        return Command::SUCCESS;
    }
}
