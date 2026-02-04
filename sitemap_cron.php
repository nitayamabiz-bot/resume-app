<?php
// ロリポップ cron 用：Google サーチ用 sitemap.xml を更新するスクリプト
// このファイルはプロジェクトルートに置く。CLI で php sitemap_cron.php のように実行する想定。
// ブラウザで叩く場合は public/sitemap_cron.php を利用すること。

$projectRoot = __DIR__;
$artisanPath = $projectRoot . DIRECTORY_SEPARATOR . 'artisan';
$phpPath = getenv('PHP_BINARY') ?: 'php';

chdir($projectRoot);
exec(sprintf('%s %s sitemap:generate 2>&1', escapeshellarg($phpPath), escapeshellarg($artisanPath)), $output);

echo "--- サイトマップ更新ログ ---\n";
echo implode("\n", $output);
