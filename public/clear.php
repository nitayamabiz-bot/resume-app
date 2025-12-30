<?php
$phpPath = '/usr/local/php/8.4/bin/php';
$artisanPath = '/home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan';

// キャッシュをすべてクリアする
exec("{$phpPath} {$artisanPath} config:clear 2>&1", $out1);
exec("{$phpPath} {$artisanPath} cache:clear 2>&1", $out2);

print_r($out1);
print_r($out2);