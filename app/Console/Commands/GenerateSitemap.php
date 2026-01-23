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
    protected $description = 'Generate sitemap.xml for SEO';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $baseUrl = config('app.url');
        $now = now()->toAtomString();

        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('admin-procedures.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => route('resume.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('career-history.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('job'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('parttime'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['loc' => route('rental'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('internet'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('sim'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('campaign'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['loc' => route('contact.create'), 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => route('advertisement.create'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $now . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '    <xhtml:link rel="alternate" hreflang="ja" href="' . htmlspecialchars($url['loc']) . '" />' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        $path = public_path('sitemap.xml');
        File::put($path, $xml);

        $this->info('Sitemap generated successfully at: ' . $path);

        return Command::SUCCESS;
    }
}
