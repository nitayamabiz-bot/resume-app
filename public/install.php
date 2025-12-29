<?php
echo "Starting installation with PATH fix...<br>";

// 1. PHP 8.4 へのパスを一時的に環境変数 PATH に追加
$phpDir = '/usr/local/php/8.4/bin';
putenv("PATH=" . $phpDir . ":" . getenv("PATH"));

// 2. 実行
$composerPath = '/usr/local/bin/composer';
exec("{$composerPath} install 2>&1", $output, $return_var);

echo "<pre>" . implode("\n", $output) . "</pre>";
if ($return_var === 0) {
    echo "Installation successful!";
} else {
    echo "Installation failed with code: " . $return_var;
}