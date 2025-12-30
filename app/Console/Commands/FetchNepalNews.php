<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FetchNepalNews extends Command
{
    // 実行する時のコマンド名
    protected $signature = 'fetch:nepal-news';

    // コマンドの説明
    protected $description = 'NewsAPIからネパール関連のニュースを取得してSQLiteに保存します';

    public function handle()
    {
        $apiKey = '5a23152ae66f4f7383ce9ff36e3b6204';
        
        // --- 1. Googleニュース (RSS) から取得（国内用） ---
        // 日本語で「ネパール料理 開店」などのキーワードを指定
        $googleNewsUrl = "https://news.google.com/rss/search?q=" . urlencode('ネパール料理 開店 OR オープン') . "&hl=ja&gl=JP&ceid=JP:ja";
        $xml = simplexml_load_file($googleNewsUrl);
        
        if ($xml) {
            foreach ($xml->channel->item as $item) {
                DB::table('news')->updateOrInsert(
                    ['external_url' => (string)$item->link],
                    [
                        'title'          => (string)$item->title,
                        'image_url'      => null, // RSSからは画像取得が難しいため
                        'category'       => 'domestic',
                        'is_published'   => true,
                        'display_order'  => 0,
                        'published_date' => Carbon::parse((string)$item->pubDate)->format('Y-m-d'),
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]
                );
            }
        }
    
        // --- 2. NewsAPI から取得（国外用・補足用） ---
        $targets = [
            'international' => "https://newsapi.org/v2/everything?q=Nepal&language=en&sortBy=publishedAt&apiKey={$apiKey}"
        ];
    
        foreach ($targets as $category => $url) {
            $response = Http::get($url);
            if ($response->successful()) {
                $articles = $response->json()['articles'] ?? [];
                foreach ($articles as $article) {
                    DB::table('news')->updateOrInsert(
                        ['external_url' => $article['url']],
                        [
                            'title'          => $article['title'],
                            'image_url'      => $article['urlToImage'] ?? null,
                            'category'       => $category,
                            'is_published'   => true,
                            'display_order'  => 0,
                            'published_date' => Carbon::parse($article['publishedAt'])->format('Y-m-d'),
                            'created_at'     => now(),
                            'updated_at'     => now(),
                        ]
                    );
                }
            }
        }
    
        $this->info('国内（Googleニュース）と国外（NewsAPI）から取得を完了しました。');
    }
}