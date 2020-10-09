<?php 
require __DIR__ . '/parts/_db_connect.php';

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'data-list.php';

if(empty($_GET['sid'])){
    header('Location:' . $referer);
    exit;
}
$sid = intval($_GET['sid']) ?? 0;

$pdo->query("DELETE FROM `deposit_table` WHERE sid = $sid");
header('Location: ' . $referer);

if(!isset($_SESSION)){
    session_start();
}



