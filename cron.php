<?php
// ロリポップ PHP8.4 の正確なパス
$phpPath = '/usr/local/php/8.4/bin/php';
$artisanPath = '/home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan';

// PHP_BINARY 環境変数を書き換えて、Laravel内部の誤認を強制修正する
putenv("PHP_BINARY={$phpPath}");

// 直接 artisan を叩くのではなく、phpコマンドの引数として渡す
$command = "{$phpPath} {$artisanPath} fetch:nepal-news 2>&1";

exec($command, $output);

echo "--- 実行ログ ---<br>";
print_r($output);