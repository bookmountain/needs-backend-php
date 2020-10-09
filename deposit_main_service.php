<?php
// require __DIR__ . '/parts/_db_connect.php';


$perPage = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM `deposit_table`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);

$rows = [];
if ($totalRows > 0) {
    if ($page < 1) {
        header("Location: deposit_main_service.php");
        exit();
    };
    if ($page > $totalPages) {
        header('Location: deposit_main_service.php?page=' . $totalPages);
        exit();
    };

    $sql = sprintf("SELECT * FROM `deposit_table` ORDER BY `deposit_table`.`sid` DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
}

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT * FROM `deposit_table` WHERE sid = $sid";
$row = $pdo->query($sql)->fetch();

$sql = "SELECT * FROM `merchants` WHERE id BETWEEN 1 AND 10 ORDER BY id ASC";
$merchant_row = $pdo->query($sql)->fetchAll();
?>

<div class="main col-sm-9 offset-sm-3 col-md-10 offset-md-2">
    <div class="main-bg">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">主頁</a></li>
                <li class="breadcrumb-item active" aria-current="page">商家加值服務</li>
            </ol>
        </nav>
        <div class="order-check">
            <input type="text" name="search_text" id="search_text" placeholder="搜尋訂單編號、店舖 or 廣告名稱" class="form-control" />
        </div>
        <div class="insert-button d-flex justify-content-end my-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_modal">
                新增資料
            </button>
        </div>
        <div id="search_result"></div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <nav aria-label="Page navigation example" class="my-3">
                    <ul class="pagination">
                        <li class="page-item" <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-arrow-circle-left"></i>
                            </a>
                        </li>
                        <?php
                        for ($i = $page - 3; $i <= $page + 3; $i++) :
                            if ($i < 1) continue;
                            if ($i > $totalPages) break;
                        ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item" <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">新增資料</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="form1" onsubmit="checkForm(); return false" novalidate>
                            <div class="form-group">
                                <label for="order_number">訂單編號</label>
                                <input type="number" class="form-control" id="order_number" name="order_number">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="store_name">店鋪</label>
                                <!-- <input class="form-control" name="store_name" id="store_name"> -->
                                <select class="form-control" name="store_name" id="store_name">
                                    <option value="" disabled selected>--請選擇--</option>
                                    <?php foreach ($merchant_row as $mr) : ?>
                                        <option value="<?= $mr['name'] ?>"><?= $mr['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small style=" color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="campaign">廣告名稱</label>
                                <input type="text" class="form-control" id="campaign" name="campaign">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="budget">預算</label>
                                <input type="number" class="form-control" id="budget" name="budget">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="status">狀態</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" disabled selected>--請選擇--</option>
                                    <option value="啟用">啟用</option>
                                    <option value="暫停">暫停</option>
                                </select>
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="campaign_style">樣式</label>
                                <select class="form-control" name="campaign_style" id="campaign_style">
                                    <option value="" disabled selected>--請選擇--</option>
                                    <option value="首頁輪播">首頁輪播</option>
                                    <option value="推薦商品">推薦商品</option>
                                </select>
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="name">起始時間</label>
                                <input type="date" class="form-control" id="create_date_start" name="create_date_start" style="margin-bottom: 1rem">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="name">結束時間</label>
                                <input type="date" class=" form-control" id="create_date_end" name="create_date_end" style="margin-bottom: 1rem">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <button type="button" id="upload-btn" class="btn btn-primary" onclick="file_input.click()">上傳廣告素材</button>
                                <input type="hidden" id="img" name="img" data-sid="">
                                <img src="" alt="" id="myimg" width="250px">
                                <input type="file" id="file_input" style="display: none">
                            </div>
                            <div id="infobar" class="alert alert-success" role="alert" style="display: none;">
                                A simple success alert—check it out!
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">編輯資料</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="form2" onsubmit="editForm(); return false;" novalidate>
                            <input id="modal_sid_input" type="hidden" name="sid" value="">
                            <div class="form-group">
                                <label for="edit_order_number">訂單編號</label>
                                <input type="number" class="form-control" id="edit_order_number" name="edit_order_number" value="">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_store_name">店鋪</label>
                                <!-- <input type="text" class="form-control" id="edit_store_name" name="edit_store_name" value=""> -->
                                <select class="form-control" name="edit_store_name" id="edit_store_name">
                                    <?php foreach ($merchant_row as $mr) : ?>
                                        <option value="<?= $mr['name'] ?>"><?= $mr['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small style=" color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_campaign">廣告名稱</label>
                                <input type="text" class="form-control" id="edit_campaign" name="edit_campaign" value="">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_budget">預算</label>
                                <input type="number" class="form-control" id="edit_budget" name="edit_budget" value="">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_status">狀態</label>
                                <select class="form-control" name="edit_status" id="edit_status">
                                    <option value="啟用">啟用</option>
                                    <option value="暫停">暫停</option>
                                </select>
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_campaign_style">樣式</label>
                                <select class="form-control" name="edit_campaign_style" id="edit_campaign_style">
                                    <option value="首頁輪播">首頁輪播</option>
                                    <option value="推薦商品">推薦商品</option>
                                </select>
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_create_date_start">起始時間</label>
                                <input type="date" class="form-control" id="edit_create_date_start" name="edit_create_date_start" style="margin-bottom: 1rem" value="">
                                <small style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label for="edit_create_date_end">結束時間</label>
                                <input type="date" class=" form-control" id="edit_create_date_end" name="edit_create_date_end" style="margin-bottom: 1rem" value="">
                                <small style="color: red;"></small>
                            </div>
                            <!-- <div class="form-group">
                                <button type="button" id="upload-btn2" class="btn btn-primary" onclick="file_input2.click()">上傳廣告素材</button>
                                <input type="hidden" id="img2" name="img" data-sid="">
                                <img src="" alt="" id="myimg2" width="250px">
                                <input type="file" id="file_input2" style="display: none">
                                <div class="my-3" id="displayimg"></div>
                            </div> -->
                            <div id="infobar2" class="alert alert-success" role="alert" style="display: none;">
                                A simple success alert—check it out!
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary edit_btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/_scripts.php'; ?>
<script>
    const $order_number = document.querySelector('#order_number');
    const $store_name = document.querySelector('#store_name');
    const $campaign = document.querySelector('#campaign');
    const $budget = document.querySelector('#budget');
    const $status = document.querySelector('#status');
    const $campaign_style = document.querySelector('#campaign_style');
    const $create_date_start = document.querySelector('#create_date_start');
    const $create_date_end = document.querySelector('#create_date_end');
    const r_fields = [$order_number, $store_name, $campaign, $budget, $status, $campaign_style, $create_date_start,
        $create_date_end
    ];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        let isPass = true;

        r_fields.forEach(el => {
            el.style.borderColor = '#ccc';
            el.nextElementSibling.innerHTML = '';
        });
        if ($order_number.value.length < 9) {
            isPass = false;
            $order_number.style.borderColor = 'red';
            $order_number.nextElementSibling.innerHTML = '請輸入九位數訂單編號';
        }
        if ($budget.value < 500) {
            isPass = false;
            $budget.style.borderColor = 'red';
            $budget.nextElementSibling.innerHTML = '預算不夠就不要投廣告(至少五百)';
        }
        if ($create_date_end.value < $create_date_start.value) {
            isPass = false;
            $create_date_end.style.borderColor = 'red';
            $create_date_end.nextElementSibling.innerHTML = '你可以穿越時空？天能看太多？';
        }
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('deposit_data_insert_api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        infobar.innerHTML = '新增成功';
                        infobar.className = "alert alert-success";
                        setTimeout(() => {
                            location.href = 'deposit_service.php';
                        }, 3000)
                        submitBtn.style.display = 'none';
                    } else {
                        infobar.innerHTML = obj.error || '新增失敗';
                        infobar.className = "alert alert-danger";
                    }
                    infobar.style.display = 'block';
                });
        }
    }


    const trashes = document.querySelectorAll('.my-trash-i');
    const trashHandler = (event) => {
        const t = event.target;
        const tr = t.closest('tr');
        tr.style.backgroundColor = 'yellow';
        setTimeout(() => tr.style.backgroundColor = '', 300)
    }
    trashes.forEach(el => el.addEventListener('click', trashHandler));


    function delete_it(sid) {
        if (confirm(`是否要刪除編號為 ${sid} 的資料???`)) {
            location.href = 'deposit_data_delete.php?sid=' + sid;
        }
    }

    const $edit_order_number = document.querySelector('#edit_order_number');
    const $edit_store_name = document.querySelector('#edit_store_name');
    const $edit_campaign = document.querySelector('#edit_campaign');
    const $edit_budget = document.querySelector('#edit_budget');
    const $edit_status = document.querySelector('#edit_status');
    const $edit_campaign_style = document.querySelector('#edit_campaign_style');
    const $edit_create_date_start = document.querySelector('#edit_create_date_start');
    const $edit_create_date_end = document.querySelector('#edit_create_date_end');
    const r_fields2 = [$edit_order_number, $edit_store_name, $edit_campaign, $edit_budget, $edit_status,
        $edit_campaign_style, $edit_create_date_start,
        $edit_create_date_end
    ]

    const infobar2 = document.querySelector('#infobar2');
    const submitBtn2 = document.querySelector('.edit_btn');

    function editForm() {
        let isPass = true;

        r_fields2.forEach(el => {
            el.style.borderColor = '#ccc';
            el.nextElementSibling.innerHTML = '';
        });
        if ($edit_order_number.value.length < 9) {
            isPass = false;
            $edit_order_number.style.borderColor = 'red';
            $edit_order_number.nextElementSibling.innerHTML = '請輸入九位數訂單編號';
        }
        if ($edit_budget.value < 500) {
            isPass = false;
            $edit_budget.style.borderColor = 'red';
            $edit_budget.nextElementSibling.innerHTML = '預算不夠就不要投廣告(至少五百)';
        }
        if ($edit_create_date_end.value < $edit_create_date_start.value) {
            isPass = false;
            $edit_create_date_end.style.borderColor = 'red';
            $edit_create_date_end.nextElementSibling.innerHTML = '你可以穿越時空？天能看太多？';
        }
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
                        infobar2.innerHTML = '修改成功';
                        infobar2.className = "alert alert-success";
                        setTimeout(() => {
                            location.href = '<?= $_SERVER['
                            HTTP_REFERER '] ?? "deposit_service.php" ?>';
                        }, 3000)
                        submitBtn2.style.display = 'none';
                    } else {
                        infobar2.innerHTML = obj.error || '資料沒有修改';
                        infobar2.className = "alert alert-danger";
                        submitBtn2.style.display = 'block';
                    }
                    infobar2.style.display = 'block';
                });
        }
    }

    // function innerImg() {
    //     const displayimg = document.getElementById('displayimg');
    //     const img2 = document.getElementById('img2').value;
    //     console.log(img2)
    //     displayimg.innerHTML = img2;
    // }

    $(document).on('click', '#edit_modal_link', function() {
        $('#modal_sid_input').val($(this).data('sid'))
        $('#edit_order_number').val($(this).closest('tr').find('td').eq(0).text());
        $('#edit_store_name').val($(this).closest('tr').find('td').eq(1).text());
        $('#edit_campaign').val($(this).closest('tr').find('td').eq(2).text());
        $('#edit_budget').val($(this).closest('tr').find('td').eq(3).text());
        $('#edit_status').val($(this).closest('tr').find('td').eq(4).text());
        $('#edit_campaign_style').val($(this).closest('tr').find('td').eq(5).text());
        $('#edit_create_date_start').val($(this).closest('tr').find('td').eq(6).text());
        $('#edit_create_date_end').val($(this).closest('tr').find('td').eq(7).text());
        // $('#img2').val($(this).closest('tr').find('td').eq(11).html());
        // innerImg();
    })




    $(document).ready(function() {

        load_data();

        function load_data(query) {
            $.ajax({
                url: "deposit_search_api.php",
                method: "GET",
                data: {
                    s: query,
                    page: <?= $page ?>
                },
                success: function(data) {
                    $('#search_result').html(data);
                }
            });
        }
        $('#search_text').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
    // upload img
    const file_input = document.querySelector('#file_input');
    const img = document.querySelector('#img');
    // const file_input2 = document.querySelector('#file_input2');
    // const img2 = document.querySelector('#img2');

    file_input.addEventListener('change', function(event) {
        console.log(file_input.files)
        const fd = new FormData();
        fd.append('img', file_input.files[0]);

        fetch('deposit_upload_api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                img.value = obj.filename;
                document.querySelector('#myimg').src = './uploads/' + obj.filename;
                console.log(img.value)
            });
    });
    // file_input2.addEventListener('change', function(event) {
    //     console.log(file_input2.files)
    //     const fd = new FormData();
    //     fd.append('img', file_input2.files[0]);

    //     fetch('deposit_upload_api.php', {
    //             method: 'POST',
    //             body: fd
    //         })
    //         .then(r => r.json())
    //         .then(obj => {
    //             img.value.src = obj.filename;
    //             document.querySelector('#myimg2').src = './uploads/' + obj.filename;
    //             console.log(img.value)
    //         });
    // })
</script>