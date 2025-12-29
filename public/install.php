<?php
echo "Starting installation...<br>";
// ロリポップのPHP8.xのフルパスを指定
$phpPath = '/usr/local/php/8.2/bin/php'; 
exec("{$phpPath} /usr/local/bin/composer install 2>&1", $output, $return_var);

echo "<pre>" . implode("\n", $output) . "</pre>";
if ($return_var === 0) {
    echo "Installation successful!";
} else {
    echo "Installation failed with code: " . $return_var;
}