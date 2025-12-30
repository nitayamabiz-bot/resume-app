<?php
// ロリポップ PHP8.4 の正確なパスを指定
$phpPath = '/usr/local/php/8.4/bin/php';
$artisanPath = '/home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan';
$command = "{$phpPath} {$artisanPath} fetch:nepal-news 2>&1";

exec($command, $output, $returnVar);

echo "実行結果:<br>";
print_r($output);
echo "<br>終了ステータス: " . $returnVar;