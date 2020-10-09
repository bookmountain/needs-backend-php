<?php
require __DIR__ . '/parts/_db_connect.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

if (empty($_POST['sid'])) {
    $output['code'] = 405;
    $output['error'] = '沒有sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (mb_strlen($_POST['edit_order_number']) < 2) {
    $output['code'] = 410;
    $output['error'] = '姓名長度要大於 2';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "UPDATE `deposit_table` SET 
`order_number`=?,
`store_name`=?,
`campaign`=?,
`budget`=?,
`status`=?,
`campaign_style`=?,
`start_date`=?,
`end_date`=?
WHERE `sid` = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['edit_order_number'],
    $_POST['edit_store_name'],
    $_POST['edit_campaign'],
    $_POST['edit_budget'],
    $_POST['edit_status'],
    $_POST['edit_campaign_style'],
    $_POST['edit_create_date_start'],
    $_POST['edit_create_date_end'],
    $_POST['sid'],
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
