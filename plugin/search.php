<?php

include("hyper_api.php");
$errorMSG = "";

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strday = date("l", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strdayCut = array("", "วันจันทร์ที่", "วันอังคารที่", "วันพุธที่", "วันพฤหัสบดีที่", "วันศุกร์ที่", "วันเสาร์ที่", "วันอาทิตย์ที่");
    if ($strday == "Monday") {
        $strdayThai = $strdayCut[1];
    } elseif ($strday == "Tuesday") {
        $strdayThai = $strdayCut[2];
    } elseif ($strday == "Wednesday") {
        $strdayThai = $strdayCut[3];
    } elseif ($strday == "Thursday") {
        $strdayThai = $strdayCut[4];
    } elseif ($strday == "Friday") {
        $strdayThai = $strdayCut[5];
    } elseif ($strday == "Saturday") {
        $strdayThai = $strdayCut[6];
    } elseif ($strday == "Sunday") {
        $strdayThai = $strdayCut[7];
    }
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strdayThai $strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
}

function DateThai1($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strday = date("l", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strdayCut = array("", "วันจันทร์ที่", "วันอังคารที่", "วันพุธที่", "วันพฤหัสบดีที่", "วันศุกร์ที่", "วันเสาร์ที่", "วันอาทิตย์ที่");
    if ($strday == "Monday") {
        $strdayThai = $strdayCut[1];
    } elseif ($strday == "Tuesday") {
        $strdayThai = $strdayCut[2];
    } elseif ($strday == "Wednesday") {
        $strdayThai = $strdayCut[3];
    } elseif ($strday == "Thursday") {
        $strdayThai = $strdayCut[4];
    } elseif ($strday == "Friday") {
        $strdayThai = $strdayCut[5];
    } elseif ($strday == "Saturday") {
        $strdayThai = $strdayCut[6];
    } elseif ($strday == "Sunday") {
        $strdayThai = $strdayCut[7];
    }
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}


if (isset($_GET)) {

    $query_selled = $hyper->connect->query($_GET['sql']);
    $total_selled_row = mysqli_num_rows($query_selled);

    if ($total_selled_row > 0) {
        $selled = mysqli_fetch_array($query_selled);
        do {

            $selled_data_id = $selled['data_id'];

            $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$selled_data_id'";
            $query_selled_data = $hyper->connect->query($sql_select_selled_data);
            $selled_data = mysqli_fetch_array($query_selled_data);

            $selled_card_id = $selled_data['card_id'];

            $sql_select_selled_card = "SELECT * FROM game_card WHERE card_id = '$selled_card_id'";
            $query_selled_game = $hyper->connect->query($sql_select_selled_card);
            $selled_card = mysqli_fetch_array($query_selled_game);

            $word = strtolower($_GET['search']);
            $buy_date = DateThai1($selled['selled_date']);
            $str = strtolower("{$selled['selled_id']} {$selled_card['card_title']} - {$selled_card['card_price']} {$buy_date}");

            if (strpos($str, $word) !== false || strpos('เคลมสำเร็จ', $word) !== false || strpos('รอดำเนินการ', $word) !== false || strpos('ถูกปฏิเสธ', $word) !== false || strpos('ยังไม่หมดอายุ', $word) !== false || $_GET['search'] == 'ttt') :

?>
                <div class='card col-10 col-md-3 color' style="width: 100%; background-color : white; border-color: black;">
                    <div class='card-body'>
                        <span>ออเดอร์ : <b style="color: #F55DA1;"><?= $selled['selled_id']; ?></b> </span> <br>
                        <span>สินค้า : <b><?php if ($selled_card['card_title'] == null) {
                                                echo 'unknow';
                                            } else {
                                                echo $selled_card['card_title'] . " - " . $selled_card['card_price'];
                                            } ?></b> </span><br>
                        <span>วันที่ซื้อสินค้า : <b><?= DateThai1($selled['selled_date']); ?></b> </span>
                        <p> สถานะ : <?php
                                    if ($selled['claim'] == 1) {
                                        echo '<span class="text-success">เคลมสำเร็จ</span>';
                                    } else if ($selled['claim'] == 2) {
                                        echo "<span  style='color: #E1B623;'>รอดำเนินการ</span>";
                                    } else if ($selled['claim'] == 3) {
                                        echo '<span class="text-danger">ถูกปฏิเสธ</span>';
                                    } else if ((int)date_diff(date_create(date("Y-m-d H:i:s")), date_create($selled['exp_date']))->format('%a') > 0) {
                                        echo '<span class="text-primary">ยังไม่หมดอายุ</span>';
                                    } else {
                                        echo '<span class="text-danger">หมดอายุ</span>';
                                    }
                                    ?></p>
                        <button class='btn btn-sm' style="background-color: #363E64;color:white;" type='button' data-toggle='modal' data-target='#datamodal<?= $selled['selled_id']; ?>'>แสดงไอดี</button>
                        <button class='btn btn-sm' style="background-color: #FF3131;color:white;" type='button' data-toggle='modal' data-target='#datamodal1<?= $selled['selled_id']; ?>' style='color:black ;'><i class='fas fa-exclamation-triangle'></i> แจ้งปัญหา</button>
                    </div>
                </div>

                <!-- Data Modal -->
                <div class="modal fade" id="datamodal<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                            <div class="modal-header hyper-bg-dark">
                                <h5 class="modal-title"> ไอดีของคุณ</h5>
                                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                    <div class="col-4">
                                        <span>ชื่อผู้ใช้งาน</span>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="hyper-form-control" id="username<?= $selled['selled_id']; ?>1" value="<?= $selled_data['username']; ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                        <button id="username<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button>
                                        <!-- 'username<?= $selled['selled_id']; ?>' -->
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                    <div class="col-4">
                                        <span>รหัสผ่าน</span>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="hyper-form-control" id="password<?= $selled['selled_id']; ?>1" value="<?= base64_decode($selled_data['password']); ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                        <button id="password<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button>
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                    <div class="col-4">
                                        <span>จอ</span>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="hyper-form-control" value="<?= $selled_data['display']; ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                                    </div>
                                </div>
                                <div class="row" style="padding: 5px 2px 0px 2px;">
                                    <div class="col-4">
                                        <span>วันหมดอายุ</span>
                                    </div>
                                    <div class="col-8">
                                        <p><?= DateThai($selled['exp_date']) ?></p>
                                    </div>
                                </div>

                                <div class="modal-footer p-2 border-0">
                                    <button type="button" class="btn btn-secondary  btn-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Data Modal -->

                <!-- Claim Modal -->
                <div class="modal fade" id="datamodal1<?= $selled['selled_id']; ?>">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #FFBD59;">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> แจ้งปัญหาในการใช้งาน</h5>
                                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left" style="width: auto;">
                                <!-- tab control -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#claim<?= $selled['selled_id']; ?>">เคลมสินค้า</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#other<?= $selled['selled_id']; ?>">สอบถามปัญหาต่างๆ</a>
                                    </li>
                                </ul>
                                <!--conternt !-->
                                <div class="tab-content">
                                    <!-- claim tab -->
                                    <div id="claim<?= $selled['selled_id']; ?>" class="tab-pane active">
                                        <br>
                                        <div class="form-group">
                                            <p for="detail<?= $selled['selled_id']; ?>">ตัวอย่างสาเหตุปัญหา</p>
                                            <ol>
                                                <li>รหัสผ่านไม่ถูกต้อง / ไม่สามารถเข้าไอดีได้</li>
                                                <li>ไอดีหมดอายุ ขึ้นให้จ่าย / Update Payment</li>
                                                <li>จอซ้อน / หน้าจอเต็ม</li>
                                            </ol>
                                            <div class="form-group align-items-center">
                                                <table style="width: 100%;">
                                                    <tr align="center">
                                                        <td>
                                                            <span>วิธีการเพิ่มรูปภาพ</span>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addimg">คลิก</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="form-group" align="center">
                                                <textarea id="detail<?= $selled['selled_id']; ?>" class="form-control" style="width: 88%;min-height: 100px" autofocus></textarea>
                                            </div>
                                            <span style="color: red;">
                                                <b>*หมายเหตุ </b>
                                                <ol style="color: black;">
                                                    <li>หากเคลม<u>ครั้งแรก</u> จะได้รับไอดีใหม่ทันที</li>
                                                    <li>หากเคลม<u>ครั้งที่ 2 ขึ้นไป</u> จะต้องรอแอดมินมาอนุมัติ</li>
                                                    <li>ในกรณี<u>ถูกปฏิเสธ</u> โปรดติดต่อไลน์ร้านเพื่อแก้ไขปัญหา</li>
                                                </ol>
                                            </span>
                                        </div>
                                        <div class="modal-footer p-2 border-0 form-group">
                                            <button type="button" class="btn btn-success" onclick="claim(<?= $selled['selled_id']; ?>)"><i class="fas fa-check-circle"></i> ส่งเคลม</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                        </div>
                                    </div>
                                    <!-- other tab -->
                                    <div id="other<?= $selled['selled_id']; ?>" class="tab-pane">
                                        <br>
                                        <div class="form-group">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td>
                                                        <span>วิธีเปลี่ยนซับไทยและเสียงพากย์ไทย</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#sub">คลิก</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span>วิธีเปลี่ยนความชัดของวิดีโอ</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#video">คลิก</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="form-group mt-3 justify-content-center" align="center">
                                            <img src="assets/img/line1.jpg" style="width:auto; max-width: 200px;margin-bottom:0px">
                                            <h5 style="color: green;margin-top: 0px;">สอบถามเพิ่มเติม โดยตรงกับทางร้าน</h5>
                                        </div>
                                        <div class="modal-footer p-2 border-0 form-group">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Data Modal -->
<?php

            endif;
        } while ($selled = mysqli_fetch_array($query_selled));
    }
}

?>


<!-- TEMPLATE -->
<!-- <div class='card col-10 col-md-3'>
    <div class='card-body'>
      <span>Order : <b>111</b> </span>
      <span>สินค้า : <b>111</b> </span><br>
      <span>วันที่ซื้อสินค้า : <b>111</b> </span>
      <p> สถานะ : ยังไม่หมดอายุ</p>
      <button class='btn btn-success btn-sm' type='button' data-toggle='modal' data-target='#datamodal<?= $selled['selled_id']; ?>'>แสดงไอดี</button>
      <button class='btn btn-warning btn-sm' type='button' data-toggle='modal' data-target='#datamodal1<?= $selled['selled_id']; ?>' style='color: ;'><i class='fas fa-exclamation-triangle'></i> แจ้งปัญหา</button>
    </div>
  </div>
</div> -->