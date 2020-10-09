<?php $page_title = '商家加值服務'; ?>
<?php 
include __DIR__ . '/parts/_connect_db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
?>
<?php include __DIR__ . '/parts/_html_header.php';  ?>
<div class="container-fluid">
    <div class="row no-gutters">
        <?php include __DIR__ . '/parts/_sidebar.php' ?>
        <?php include __DIR__ . '/deposit_main_service.php' ?>
    </div>
</div>

<?php include __DIR__ . '/parts/_scripts.php' ?>