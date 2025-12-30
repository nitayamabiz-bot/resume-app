<?php
// フルパス指定版
exec('/usr/local/php/8.4/bin/php /home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan fetch:nepal-news 2>&1', $output);
print_r($output);