<?php
// ロリポップ上でcomposer installを実行するスクリプト
echo "Starting installation...<br>";
exec("composer install 2>&1", $output, $return_var);
echo "<pre>" . implode("\n", $output) . "</pre>";
if ($return_var === 0) {
    echo "Installation successful!";
} else {
    echo "Installation failed with code: " . $return_var;
}