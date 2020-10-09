<?php
$page_title = '編輯資料';
require __DIR__ . '/parts/_db_connect.php';


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: deposit_service.php');
    exit;
}
$sql = "SELECT * FROM `deposit_table` WHERE sid = $sid";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: deposit_service.php');
    exit;
}

?>
<?php require __DIR__ . '/parts/_html_header.php'; ?>
<div id="infobar" class="alert alert-success" role="alert" style="display: none">
    A simple success alert—check it out!
</div>
<form name="form2" onsubmit="editForm(); return false;" novalidate>
    <input type="hidden"" name="sid" value="<?= $row['sid'] ?>">
    <div class="form-group">
        <label for="edit_order_number">訂單編號</label>
        <input type="number" class="form-control" id="edit_order_number" name="edit_order_number" value="<?= htmlentities($row['order_number']) ?>">
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="edit_store_name">店鋪</label>
        <select class="form-control" name="edit_store_name" id="edit_store_name">
            <option value="<?= htmlentities($row['store_name']) ?>" selected ><?= htmlentities($row['store_name']) ?></option>
            <option value="小品雅集">小品雅集</option>
            <option value="小鹿文具所">小鹿文具所</option>
            <option value="直物生活文具">直物生活文具</option>
        </select>
        <small style=" color: red;"></small>
    </div>
    <div class="form-group">
        <label for="edit_campaign">廣告名稱</label>
        <input type="text" class="form-control" id="edit_campaign" name="edit_campaign" value="<?= htmlentities($row['campaign']) ?>">
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="edit_budget">預算</label>
        <input type="number" class="form-control" id="edit_budget" name="edit_budget" value="<?= htmlentities($row['budget']) ?>">
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="edit_status">狀態</label>
        <select class="form-control" name="edit_status" id="edit_status">
            <option value="<?= htmlentities($row['status']) ?>" selected ><?= htmlentities($row['status']) ?></option>
            <option value="啟用">啟用</option>
            <option value="暫停">暫停</option>
        </select>
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="edit_campaign_style">樣式</label>
        <select class="form-control" name="edit_campaign_style" id="edit_campaign_style">
            <option value="<?= htmlentities($row['campaign_style']) ?>" selected ><?= htmlentities($row['campaign_style']) ?></option>
            <option value="首頁輪播">首頁輪播</option>
            <option value="推薦商品">推薦商品</option>
        </select>
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="name">起始時間</label>
        <input type="date" class="form-control" id="edit_create_date_start" name="edit_create_date_start" style="margin-bottom: 1rem" value="<?= htmlentities($row['start_date']) ?>">
        <small style="color: red;"></small>
    </div>
    <div class="form-group">
        <label for="name">結束時間</label>
        <input type="date" class=" form-control" id="edit_create_date_end" name="edit_create_date_end" style="margin-bottom: 1rem" value="<?= htmlentities($row['end_date']) ?>">
        <small style="color: red;"></small>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    const $edit_order_number = document.querySelector('#edit_order_number');
    const $edit_store_name = document.querySelector('#edit_store_name');
    const $edit_campaign = document.querySelector('#edit_campaign');
    const $edit_budget = document.querySelector('#edit_budget');
    const $edit_status = document.querySelector('#edit_status');
    const $edit_campaign_style = document.querySelector('#edit_campaign_style');
    const $edit_create_date_start = document.querySelector('#edit_create_date_start');
    const $edit_create_date_end = document.querySelector('#edit_create_date_end');

    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');


    function editForm() {
        let isPass = true;

        if (isPass) {
            const fd = new FormData(document.form2);

            fetch('deposit_data_edit_api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '修改成功';
                        infobar.className = "alert alert-success";
                        setTimeout(() => {
                            location.href = '<?= $_SERVER['HTTP_REFERER'] ?? "deposit_service.php" ?>';
                        }, 3000)

                    } else {
                        infobar.innerHTML = obj.error || '資料沒有修改';
                        infobar.className = "alert alert-danger";
                        submitBtn.style.display = 'block';
                    }
                    infobar.style.display = 'block';
                });

        } else {
            submitBtn.style.display = 'block';
        }
    }
</script>