<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="table-responsive mt-3">

    <div id="delAll" class="br-icon1 text-center btn btn-danger" style="display: none;" onclick="delAll()">
        <span>ลบที่เลือก</span>
    </div>

    <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
                <th>เลือก</th>
                <th scope="col" style="width:120px;">ลำดับการเคลม</th>
                <th scope="col">ผู้เคลม</th>
                <th scope="col">วันที่เคลม</th>
                <th scope="col">สถานะ</th>
                <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $select_claim = "SELECT * FROM data_claim ORDER BY id";
            $claim_result = $hyper->connect->query($select_claim);
            $i = 0;
            if (mysqli_num_rows($claim_result) > 0) {
                do {
                    $claim_data = $claim_result->fetch_array();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT * FROM accounts WHERE ac_id={$claim_data['ac_id']}";
                    $username = $hyper->connect->query($select_user)->fetch_array();

                    $data_result = $hyper->connect->query($select_data)->fetch_array();
                    $data_result['password'] = base64_decode($data_result['password']);
            ?>
                    <tr <?php if ($claim_data['confirm'] != 0) {
                            echo 'style="background-color: #DADDE2;"';
                        } else if (isset($_GET['id']) && $_GET['id'] == $claim_data['claim_id']) {
                            echo 'style="background-color: #E7B91F"';
                        }

                        ?>>
                        <td>
                            <?php
                            if ($claim_data['confirm'] != 0) {
                            ?>
                                <input type="checkbox" id="check<?= $claim_data['id'] ?>" name="check<?= $claim_data['id'] ?>" value="<?= $claim_data['id'] ?>" onclick="checkedL(this)">
                            <?php
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($claim_data['confirm'] != 0) {
                                echo $i + 1;
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                        <td><?= $username['username'] ?></td>
                        <td><?= DateThai($claim_data['claim_date']) ?></td>
                        <td><?php if (isset($_GET['id']) && $_GET['id'] == $claim_data['claim_id'] && $claim_data['confirm'] == 0) {
                                echo '<span style="color: #fff;">รอดำเนินการ</span>';
                            } else if ($claim_data['confirm'] == 0) {
                                echo '<span class="text-warning">รอดำเนินการ</span>';
                            } else if ($claim_data['confirm'] == 1) {
                                echo '<span class="text-success">อนุมัติ</span>';
                            } else if ($claim_data['confirm'] == 2) {
                                echo '<span class="text-danger">ปฏิเสธ</span>';
                            } ?></td>
                        <td>
                            <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal<?= $i ?>"><i class="fal fa-info-circle mr-1"></i> แสดงไอดี</button>
                            <?php if ($claim_data['confirm'] != 0) : ?>
                                <button onclick="DelLog(<?= $claim_data['id']; ?>);" value="<?= $claim_data['id']; ?>" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
                            <?php endif; ?>
                        </td>
                        <!-- aleart Data Modal -->
                        <div class="modal fade" id="editusermodal<?= $i ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                                    <div class="modal-header hyper-bg-dark">
                                        <h5 class="modal-title"><i class="fal fa-info-circle mr-1"></i> ข้อมูลไอดีที่เคลม</h5>
                                        <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <?php if ($claim_data['confirm'] == 0) : ?>
                                            <div class="row" style="position: absolute;right: 0px;padding-right: 30px;z-index:5;">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="submit(<?= $claim_data['claim_id']; ?>,2)">อนุมัติ</button>
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="submit(<?= $claim_data['claim_id']; ?>,3)">ปฏิเสธ</button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row" style="padding: 5px 2px 0px 2px;">
                                            <div class="col-3 col-md-4">
                                                <span>ชื่อผู้ใช้งาน</span>
                                            </div>
                                            <div class="col-9 col-md-8">
                                                <input type="text" id="username<?= $selled['selled_id']; ?>1" value="<?= $data_result['username'] ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                <!-- <button id="username<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button> -->
                                                <!-- 'username<?= $selled['selled_id']; ?>' -->
                                            </div>
                                        </div>
                                        <div class="row" style="padding: 5px 2px 0px 2px;">
                                            <div class="col-3 col-md-4">
                                                <span>รหัสผ่าน</span>
                                            </div>
                                            <div class="col-9 col-md-8">
                                                <input type="text" id="password<?= $selled['selled_id']; ?>1" value="<?= $data_result['password'] ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                                <!-- <button id="password<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button> -->
                                            </div>
                                        </div>
                                        <div class="row" style="padding: 5px 2px 0px 2px;">
                                            <div class="col-3 col-md-4">
                                                <span>จอ</span>
                                            </div>
                                            <div class="col-9 col-md-8">
                                                <input type="text" value="<?= $data_result['display'] ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                            </div>
                                        </div>
                                        <div class="row" style="padding: 5px 2px 0px 2px;">
                                            <div class="col-3 col-md-4">
                                                <span>สาเหตุในการเคลม</span>
                                            </div>
                                            <div class="col-9 col-md-8">
                                                <p><?= $claim_data['detail'] ?></p>
                                            </div>
                                        </div>

                                        <div class="modal-footer p-2 border-0">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End accept Data Modal -->

                        </td>
                    </tr>
            <?php
                    $i++;
                } while ($i < mysqli_num_rows($claim_result));
            } ?>

        </tbody>
    </table>
</div>
<input type="hidden" id="del" name="del" value="">
<style>
    .table-hover:hover {
        background-color: #ddd;
    }

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

    body {
        background-color: #131315;
    }

    label {
        color: white;
    }

    #datatable_info {
        color: white;
    }
</style>

<script>
    var total_del = [];

    function checkedL(data) {
        var value = data.value;
        var id = data.id
        var check = $('#' + id).is(':checked');
        if (check) {
            total_del.push(value);
            $('#delAll').show()
            document.getElementById('delAll').style.animation = "fadeIn 300ms";

        } else {
            index = total_del.indexOf(value);
            if (index > -1) {
                total_del.splice(index, 1);
            }

            if (total_del.length == 0) {
                document.getElementById('delAll').style.animation = "fadeOut 1s";
                $('#delAll').hide();
            }
        }
        // console.log(total_del);
    }

    function delAll() {
        document.getElementById('del').value = total_del.join(',');
        // console.log($('#del').val());
        let title = total_del.length > 1 ? 'คุณต้องการลบ ' + total_del.length + ' ข้อมูลนี้หรือไม่?' : 'คุณต้องการลบข้อมูลนี้หรือไม่?'
        DelLog($('#del').val(), title);

    }

    function DelLog(id, title = 'คุณต้องการลบข้อมูลนี้หรือไม่?') {
        swal({
                title: title,
                text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: 'ลบข้อมูล',
                        className: 'hyper-btn-notoutline-danger'
                    },
                    cancel: 'ยกเลิก'
                },
                closeOnClickOutside: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({

                        type: "POST",
                        url: "plugin/del_log.php",
                        dataType: "json",
                        data: {
                            id: id
                        },

                        beforeSend: function() {
                            swal("กำลังลบข้อมูล กรุณารอสักครู่...", {
                                button: false,
                                closeOnClickOutside: false,
                                timer: 500,
                            });

                        },

                        success: function(data) {
                            setTimeout(() => {
                                if (data.code == "200") {
                                    swal("ลบข้อมูล สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
                                        button: false,
                                        closeOnClickOutside: false,
                                    });
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                } else {
                                    swal(data.msg, "", "error", {
                                        button: {
                                            className: 'hyper-btn-notoutline-danger',
                                        },
                                        closeOnClickOutside: false,
                                    });
                                }
                            }, 600)
                        }

                    });
                }
            });
    }

    function submit(id, type) {
        // console.log(id);
        // console.log(type);
        $.ajax({

            type: "POST",
            url: "plugin/claim.php",
            dataType: "json",
            data: {
                id: id,
                type: type
            },

            beforeSend: function() {
                swal("กำลังดำเนินการ กรุณารอสักครู่...", {
                    button: false,
                    closeOnClickOutside: false,
                    timer: 500,
                });

            },

            success: function(data) {
                if (data.code == "200") {
                    swal(data.msg, '\n', "success", {
                        button: false,
                        closeOnClickOutside: false,
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    swal(data.msg, "\n", "error", {
                        button: {
                            className: 'hyper-btn-notoutline-danger',
                        },
                        closeOnClickOutside: false,
                    });
                }
            }

        });
    }
</script>