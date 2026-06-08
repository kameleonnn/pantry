<?php
$db_user = getenv('DB_USER') ?: 'pantry_user';
$db_pass = getenv('DB_PASS') ?: 'pantry_secure_password'; 
$db_name = getenv('DB_NAME') ?: 'pantry_db';

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $db_host = '127.0.0.1';
} else {
    $db_host = 'db';
    $connection_check = @fsockopen('db', 3306, $errno, $errstr, 1);
    if (!$connection_check) {
        $db_host = '127.0.0.1';
    } else {
        fclose($connection_check);
    }
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {
    $fallback_host = ($db_host === 'db') ? '127.0.0.1' : 'db';
    $conn = new mysqli($fallback_host, $db_user, $db_pass, $db_name);
}
