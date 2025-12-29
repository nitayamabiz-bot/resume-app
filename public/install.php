<?php
echo "Starting installation for PHP 8.4 (LiteSpeed)...<br>";

// ロリポップ PHP 8.4 (LiteSpeed版) のフルパス候補
$phpPath = '/usr/local/php/8.4-litespeed/bin/php';
$composerPath = '/usr/local/bin/composer';

// 実行
exec("{$phpPath} {$composerPath} install 2>&1", $output, $return_var);

echo "<pre>" . implode("\n", $output) . "</pre>";
if ($return_var === 0) {
    echo "Installation successful!";
} else {
    echo "Installation failed with code: " . $return_var;
}