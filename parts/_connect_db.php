<?php

if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', '/eShop-backend');
}

$db_host = '122.116.38.12';
$db_name = 'eshop';
$db_user = 'elivia';
$db_pass = 'elivia_sql';

$dsn = "mysql:host={$db_host};dbname={$db_name}";
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
];


try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
    // echo "OK";
} catch (PDOException $e) {
    echo $e->getMessage();
    echo '<br />';
    echo iconv('big5', 'utf-8', $e->getMessage());
};
