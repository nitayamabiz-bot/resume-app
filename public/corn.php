<?php
// ロリポップ PHP8.4 の正確なパス
$phpPath = '/usr/local/php/8.4/bin/php';
$artisanPath = '/home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan';

// 実行
exec("{$phpPath} {$artisanPath} fetch:nepal-news 2>&1", $output);

print_r($output);