<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="table-responsive mt-3">
    <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th scope="col" style="width:120px;">อันดับที่</th>
                <th scope="col">ผู้เคลม</th>
                <th scope="col">วันที่เคลม</th>
                <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $select_claim = "SELECT * FROM data_claim ORDER BY claim_id";
            $claim_result = $hyper->connect->query($select_claim);
            if (mysqli_num_rows($claim_result) > 0) {
                for ($i = 0; $i < mysqli_num_rows($claim_result); $i++) {
                    $claim_data = $claim_result->fetch_array();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT username FROM accounts WHERE ac_id={$claim_data['ac_id']} LIMIT 1";
                    $ac_id = $hyper->connect->query($select_user)->fetch_all()[0][0];

                    $data_result = $hyper->connect->query($select_data)->fetch_array();
                    $data_result['password'] = base64_decode($data_result['password']);
            ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $ac_id ?></td>
                        <td><?= DateThai($claim_data['claim_date']) ?></td>
                        <td>
                            <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal<?= $i ?>"><i class="fal fa-edit mr-1"></i>แสดงไอดี</button>

                        </td>
                        <!-- aleart Data Modal -->
                        <div class="modal fade" id="editusermodal<?= $i ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                                    <div class="modal-header 1hyper-modal-header" style="   background-color: #ffc107;">
                                        <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i> ข้อมูลไอดีที่เคลม</h6>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <span><b>อีเมล</b></span>
                                            <div><?= $data_result['username'] ?></div>
                                        </div>
                                        <div class="form-group">
                                            <span><b>รหัสผ่าน</b></span>
                                            <div><?= $data_result['password'] ?></div>
                                        </div>
                                        <div class="form-group">
                                            <span><b>รายละเอียด</b></span>
                                            <div><?= $data_result['display'] ?></div>
                                        </div>
                                        <div class="modal-footer p-2 border-0">
                                            <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End accept Data Modal -->

                        </td>
                    </tr>
            <?php
                }
            } ?>

        </tbody>
    </table>
</div>
<style>
    input {
        border-radius: 15px;

    }

    input.expdate {
        width: 35%;
    }

    input.detail {
        width: auto;

    }

    input.pass {
        width: 45%;
    }

    input.user {
        width: 45%;
    }

    .drop {
        border-radius: 15px;
    }

    #detailnew {
        height: 70px;
        min-height: 70px;
        max-height: 120px;
        width: 300px;

    }
</style>