<?php
// ロリポップ cron 用：Google サーチ用 sitemap.xml を更新するスクリプト
// ロリポップの cron（URL 指定 or サーバー cron）でこのファイルを呼び出す

$phpPath = '/usr/local/php/8.4/bin/php';
$artisanPath = '/home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan';

putenv("PHP_BINARY={$phpPath}");

$command = "{$phpPath} {$artisanPath} sitemap:generate 2>&1";

exec($command, $output);

echo "--- サイトマップ更新ログ ---<br>";
print_r($output);
