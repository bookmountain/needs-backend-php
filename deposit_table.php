            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr style="text-align: center;">
                            <th scope="col">序號</th>
                            <th scope="col">訂單編號</th>
                            <th scope="col">店鋪</th>
                            <th scope="col">廣告名稱</th>
                            <th scope="col">預算</th>
                            <th scope="col">狀態</th>
                            <th scope="col">樣式</th>
                            <th scope="col">點擊率</th>
                            <th scope="col">觸及率</th>
                            <th scope="col">CTR</th>
                            <th scope="col">CPC</th>
                            <th scope="col">總成本</th>
                            <th scope="col">起始時間</th>
                            <th scope="col">結束時間</th>
                            <th scope="col">活動天數</th>
                            <th scope="col">修改</th>
                            <th scope="col">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr style="text-align: center;">
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['order_number'] ?></td>
                            <td><?= $r['store_name'] ?></td>
                            <td><?= $r['campaign'] ?></td>
                            <td><?= $r['budget'] ?></td>
                            <td><?= $r['status'] ?></td>
                            <td><?= $r['campaign_style'] ?></td>
                            <td><?= $r['clicks'] ?></td>
                            <td><?= $r['impression'] ?></td>
                            <td><?= round($r['clicks'] / $r['impression'], 2)  ?>%</td>
                            <td>$<?= $r['avg_cpc'] ?></td>
                            <td>$<?= $r['clicks'] *  $r['avg_cpc'] ?></td>
                            <td><?= $r['start_date'] ?></td>
                            <td><?= $r['end_date'] ?></td>
                            <td><?= date_diff(date_create($r['start_date']), date_create($r['end_date']))->format('%a') ?>
                                / days</td>
                            <td>
                                <a id="edit_modal_link" href="deposit_data_edit.php?sid=<?= $r['sid'] ?>"
                                    data-toggle="modal" data-target="#edit_modal" data-sid="<?= $r['sid'] ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascript:delete_it(<?= $r['sid'] ?>)">
                                    <i class="fas fa-trash-alt my-trash-i"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>