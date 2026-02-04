<?php
// ロリポップ cron 用：Google サーチ用 sitemap.xml を更新するスクリプト
// ブラウザまたはロリポップの cron（URL 指定）で呼び出し可能
// このファイルは public/ に置く。プロジェクトルートは __DIR__ の親なのでサーバーごとのパス不要。

$projectRoot = dirname(__DIR__);
$artisanPath = $projectRoot . DIRECTORY_SEPARATOR . 'artisan';

// Web/Cron 実行時は PATH に php が無いことが多いため、絶対パスを使う（ロリポップ: PHP 8.4）
// 別パスなら先頭の値を書き換えるか、サーバーで PHP_BINARY を設定
$phpPath = getenv('PHP_BINARY') ?: (php_sapi_name() === 'cli' ? 'php' : '/usr/local/php/8.4/bin/php');

chdir($projectRoot);
exec(sprintf('%s %s sitemap:generate 2>&1', escapeshellarg($phpPath), escapeshellarg($artisanPath)), $output);

header('Content-Type: text/html; charset=UTF-8');
echo "--- サイトマップ更新ログ ---<br>\n";
echo nl2br(htmlspecialchars(implode("\n", $output), ENT_QUOTES, 'UTF-8'));
