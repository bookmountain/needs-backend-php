<!DOCTYPE html>

<body>
    <?php

    // 定義資料庫資訊
    $DB_NAME = "eshop";
    $DB_USER = "elivia";
    $DB_PASS = "elivia_sql";
    $DB_HOST = "122.116.38.12";

    // 連接 MySQL 資料庫伺服器
    $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
    if (empty($con)) {
        print mysqli_error($con);
        die("資料庫連接失敗！");
        exit;
    }

    // 選取資料庫
    if (!mysqli_select_db($con, $DB_NAME)) {
        die("選取資料庫失敗！");
    }

    // 設定連線編碼
    mysqli_query($con, "SET NAMES 'UTF-8'");

    // 顯示表頭
    echo "
    <div class='table-container'>
    <table class='table table-hover'>
    <thead>
        <tr style='text-align: center;'>
            <th scope='col'>訂單編號</th>
            <th scope='col'>店鋪</th>
            <th scope='col'>廣告名稱</th>
            <th scope='col'>預算</th>
            <th scope='col'>狀態</th>
            <th scope='col'>樣式</th>
            <!-- <th scope='col'>點擊率</th>
            <th scope='col'>觸及率</th>
            <th scope='col'>CTR</th>
            <th scope='col'>CPC</th>
            <th scope='col'>總成本</th> -->
            <th scope='col'>起始時間</th>
            <th scope='col'>結束時間</th>
            <th scope='col'>活動天數</th>
            <th scope='col'>修改</th>
            <th scope='col'>刪除</th>
            <th scope='col'>廣告素材</th>
        </tr>
    </thead>";
    $perPage = 5;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if (isset($_GET['s'])) { // 如果有搜尋文字顯示搜尋結果
        $s = mysqli_real_escape_string($con, $_GET['s']);
        $sql = "SELECT * FROM deposit_table WHERE order_number LIKE '%" . $s . "%' OR store_name LIKE '%" . $s . "%' OR campaign LIKE '%" . $s . "%'" . sprintf("LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        $result = mysqli_query($con, $sql);

        // SQL 搜尋錯誤訊息
        if (!$result) {
            echo ("錯誤：" . mysqli_error($con));
            exit();
        }

        // 搜尋無資料時顯示「查無資料」
        if (mysqli_num_rows($result) <= 0) {
            echo "<tr><td colspan='4'>查無資料</td></tr>";
        }

        // 搜尋有資料時顯示搜尋結果
        while ($row = mysqli_fetch_array($result)) {
            $index = $row['sid'];
            echo "<tr style='text-align: center;'>";
            // echo "<td>" . $row['sid'] . "</td>";
            echo "<td>" . $row['order_number'] . "</td>";
            echo "<td>" . $row['store_name'] . "</td>";
            echo "<td>" . $row['campaign'] . "</td>";
            echo "<td>" . $row['budget'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['campaign_style'] . "</td>";
            echo "<td>" . $row['start_date'] . "</td>";
            echo "<td>" . $row['end_date'] . "</td>";
            echo "<td>" . date_diff(date_create($row['start_date']), date_create($row['end_date']))->format('%a') . "/ days" . "</td>";
            echo "<td>" . "<a id='edit_modal_link' href='#' data-toggle='modal' data-target='#edit_modal' data-sid='$index' " . "<i class='fas fa-edit'></i></a>" . "</td>";
            echo "<td>" . "<a href='javascript:delete_it($index)'>" . "<i class='fas fa-trash-alt my-trash-i'></i></a>" . "</td>";
            $display_img = $row['img'];
            echo "<td>" . "<img style='width: 300px; height: 300px' src='uploads/$display_img' alt=''>" . "</td>";
            echo "</tr>";
        }
    } else { // 如果沒有搜尋文字顯示所有資料
        $sql = sprintf("SELECT * FROM deposit_table ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo ("錯誤：" . mysqli_error($con));
            exit();
        }

        while ($row = mysqli_fetch_array($result)) {
            $index = $row['sid'];
            echo "<tr style='text-align: center;'>";
            // echo "<td>" . $row['sid'] . "</td>";
            echo "<td>" . $row['order_number'] . "</td>";
            echo "<td>" . $row['store_name'] . "</td>";
            echo "<td>" . $row['campaign'] . "</td>";
            echo "<td>" . $row['budget'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['campaign_style'] . "</td>";
            echo "<td>" . $row['start_date'] . "</td>";
            echo "<td>" . $row['end_date'] . "</td>";
            echo "<td>" . date_diff(date_create($row['start_date']), date_create($row['end_date']))->format('%a') . " / days" . "</td>";
            echo "<td>" . "<a id='edit_modal_link' href='#' data-toggle='modal' data-target='#edit_modal' data-sid='$index' " . "<i class='fas fa-edit'></i></a>" . "</td>";
            echo "<td>" . "<a href='javascript:delete_it($index)'>" . "<i class='fas fa-trash-alt my-trash-i'></i></a>" . "</td>";
            $display_img = $row['img'];
            echo "<td>" . "<img style='width: 300px; height: 300px' src='uploads/$display_img' alt=''>" . "</td>";
            echo "</tr>";
        }
    }


    echo "</table>";


    while ($row = mysqli_fetch_array($result)) {
        $display_img = $row['img'];
        echo "<img style='width: 300px; height: 300px' src='uploads/$display_img' alt=''>";
    }


    mysqli_close($con); // 連線結束

    ?>

</body>

</html>