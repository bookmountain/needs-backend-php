<?php
require __DIR__ . '/parts/_db_connect.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

// if (mb_strlen($_POST['order_number']) < 9) {
//     $output['code'] = 410;
//     $output['error'] = '訂單編號長度要等於 9';
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

$sql = "INSERT INTO `deposit_table`(`order_number`, `store_name`, `campaign`, `budget`, `status`, `campaign_style`, `start_date`, `end_date` , `img`) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['order_number'],
    $_POST['store_name'],
    $_POST['campaign'],
    $_POST['budget'],
    $_POST['status'],
    $_POST['campaign_style'],
    $_POST['create_date_start'],
    $_POST['create_date_end'],
    $_POST['img']
]);

if ($stmt->rowCount()) {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
