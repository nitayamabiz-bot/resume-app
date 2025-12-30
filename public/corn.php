<?php
// php8.4 を直接指定
exec('php8.4 /home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan fetch:nepal-news 2>&1', $output);
print_r($output);