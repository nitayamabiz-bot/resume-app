<?php
// パスを hamro-life-japan.com に合わせて修正
exec('/usr/local/bin/php /home/users/1/littlestar.jp-proud-takeo-0732/web/hamro-life-japan.com/artisan fetch:nepal-news 2>&1', $output);
print_r($output);