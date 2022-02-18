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
        $i = 0;
        do {
            $selled = mysqli_fetch_array($query_selled);
            $sid = $_COOKIE['USER_SID'];
            $var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
            $user_query = $hyper->connect->query($var);
            $total_user = mysqli_num_rows($user_query);
            $data_user = $hyper->connect->query($var)->fetch_array();

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
            $expire = strtotime($selled['exp_date']) - strtotime('today midnight');


            $select_noti = "SELECT * FROM notify_log WHERE _to={$data_user['ac_id']} AND data_id={$selled['selled_id']} ORDER BY id";
            $notify = $hyper->connect->query($select_noti);
            $noti_row = $notify->num_rows;
            $row = $notify->fetch_assoc();

            $exptime = strtotime($selled['exp_date']) - strtotime('today -3 day');


            if (strpos($selled['selled_id'], $word) !== false || strpos($str, $word) !== false || $_GET['search'] === 'ttt' && $exptime > 0) :
?>

                <div class='card col-10 col-md-3 color' style="width: 100%; background-color : white; border-color: black;">
                    <div class='card-body'>
                        <span>ออเดอร์ : <b style="color: #F55DA1;"><?= $selled['selled_id']; ?></b> </span> <br>
                        <input id="card_id<?= $selled['selled_id']; ?>" type="hidden" value="<?= $selled_card['card_id']; ?>">
                        <span id="price<?= $selled['selled_id']; ?>">สินค้า : <b><?php if ($selled_card['card_title'] == null) {
                                                                                        echo 'unknow';
                                                                                    } else {
                                                                                        echo $selled_card['card_title'] . " - " . $selled_card['card_price'];
                                                                                    } ?></b> </span><br>
                        <span>วันที่ซื้อสินค้า : <b><?= DateThai1($selled['selled_date']); ?></b></span><br>
                        <span>วันหมดประกัน : <b><?= DateThai1($selled['exp_date']); ?></b></span><br>
                        <?php
                        if ($row == null) {
                            $datetime = 0;
                            $date = date('Y-m-d H:i:s', strtotime("+ 0 day"));
                            $day_check = $datetime - strtotime($date);
                        } else {
                            // print_r(count($row));
                            $order_id = $row['data_id'];

                            // print_r($row);

                            if ($order_id == (int)$selled['selled_id']) {

                                $datetime = $row['datetime'] . ' +2 day';
                                $date = date('Y-m-d H:i:s', strtotime("+ 0 day"));
                                $day_check = strtotime($datetime) - strtotime($date);

                                if ($day_check > 0) {
                        ?>
                                    <span> สถานะ : <?php
                                                    if ($selled['claim'] == 1) {
                                                        echo '<span class="text-success">เคลมสำเร็จ</span>';
                                                    } else if ($selled['claim'] == 2) {
                                                        echo "<span  style='color: #E1B623;'>รอดำเนินการ</span>";
                                                    } else if ($selled['claim'] == 3) {
                                                        echo '<span class="text-danger">ถูกปฎิเสธ</span>';
                                                    } else {
                                                        echo '<span>-</span>';
                                                    }
                                                    ?></span>
                                    <?php
                                    if ($selled['claim'] == 3) {
                                    ?>
                                        <br> หมายเหตุ :<span style='color: #ff6b4a;'><br> <?= $selled['response'] ?> </span> <br>
                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        <p class="mt-1"><?php
                                        if ($expire < 1) {
                                            echo '<b class="text-danger">หมดอายุ</b>';
                                        } else if ($expire < 7) {
                                            echo '<b class="text-warning">ใกล้หมดอายุ</b>';
                                        } else {
                                            echo '<b class="text-primary">ยังไม่หมดอายุ</b>';
                                        }
                                        ?></p>
                        <div class="row justify-content-center float-center">
                            <button class='btn btn-sm mx-1' style="background-color: #363E64;color:white;" type='button' data-toggle='modal' data-target='#datamodal<?= $selled['selled_id']; ?>'>แสดงไอดี</button>
                            <button class='btn btn-sm mx-1' style="background-color: #FF3131;color:white;" type='button' data-toggle='modal' data-target='#claimmodal<?= $selled['selled_id']; ?>' style='color:black ;'><i class='fas fa-exclamation-triangle'></i> แจ้งปัญหา</button>
                        </div>
                    </div>
                </div>

                <!-- Data Modal -->
                <div class="modal fade" id="datamodal<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                            <div class="modal-header hyper-bg-dark">
                                <h5 class="modal-title"> ข้อมูลสินค้า</h5>
                                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php if ($expire > 0) : ?>
                                    <div class="row mb-3">
                                        <div class="input-group input-group-sm col-8" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text hyper-bg-dark border-dark">ชื่อผู้ใช้</span>
                                            </div>
                                            <input id="username<?= $selled['selled_id']; ?>1" type="text" value="<?= $selled_data['username']; ?>" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อผู้ใช้งาน" readonly autocomplete="off" style="background-color: #fff;">
                                        </div>
                                        <div class="input-group input-group-sm col-4">
                                            <button style="margin-left: -25px;" id="username<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"><i class='far fa-copy'></i> คัดลอก</button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="input-group input-group-sm col-8">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text hyper-bg-dark border-dark">รหัสผ่าน</span>
                                            </div>
                                            <input id="password<?= $selled['selled_id']; ?>1" type="text" value="<?= base64_decode($selled_data['password']); ?>" class="form-control form-control-sm hyper-form-control" placeholder="รหัสผ่าน" readonly autocomplete="off" style="background-color: #fff;">
                                        </div>
                                        <div class="input-group input-group-sm col-4">
                                            <button style="margin-left: -25px;" id="password<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"><i class='far fa-copy'></i> คัดลอก</button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="input-group input-group-sm col-8">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text hyper-bg-dark border-dark">จอ</span>
                                            </div>
                                            <input id="display<?= $selled['selled_id']; ?>1" type="text" value="<?= $selled_data['display']; ?>" class="form-control form-control-sm hyper-form-control" placeholder="จอ" readonly autocomplete="off" style="background-color: #fff;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="row mb-3">
                                    <div class="input-group input-group-sm col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text hyper-bg-dark border-dark">วันหมดประกัน</span>
                                        </div>
                                        <?php
                                        $expire = strtotime($selled['exp_date']) - strtotime('today midnight');
                                        if ($expire > 0) :
                                        ?>
                                            <input id="expire<?= $selled['selled_id']; ?>1" type="text" value="<?= $hyper->datethai->DateThai1($selled['exp_date']) ?>" class="form-control form-control-sm hyper-form-control" readonly placeholder="วันหมดประกัน" required autocomplete="off" style="background-color: #fff;">
                                        <?php else : ?>
                                            <input id="expire<?= $selled['selled_id']; ?>1" type="text" value="หมดอายุแล้ว" class="form-control form-control-sm hyper-form-control" placeholder="วันหมดประกัน" readonly autocomplete="off" style="background-color: #fff;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <a class="btn btn-success btn-sm w-100 text-light" onclick="renew(<?= $selled['selled_id']; ?>)" style="color: #1a00db;">ต่อวันประกัน +30 วัน คลิกที่นี่!</a>
                                    </div>
                                </div>
                                <span style="color: #ff0022;" align="center"><br><b>อ่านก่อนเข้าจอ</b> <br></span>
                                <ol>
                                    <li style="color: #ff0022;">ห้ามเปลี่ยนชื่อจอ รูปจอ</li>
                                    <li style="color: #ff0022;">ห้ามล๊อคจอ / ตั้ง Pin จอ </li>
                                    <li style="color: #ff0022;">ห้ามแชร์รหัสให้ผู้อื่น ใช้งาน 1 คนเท่านั้น </li>
                                    <li style="color: #ff0022;">ภาษาของเมนูเป็นภาษาอังกฤษเท่านั้น ไม่สามารถเปลี่ยนได้</li>
                                </ol>

                                <div class="modal-footer p-2 border-0">
                                    <button type="button" class="btn btn-secondary  btn-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Data Modal -->

                <!-- Claim Modal -->
                <div class="modal fade" id="claimmodal<?= $selled['selled_id']; ?>">
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
                                        <a class="nav-link active" data-toggle="tab" href="#claim<?= $selled['selled_id']; ?>">หน้า เคลมสินค้า</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#other<?= $selled['selled_id']; ?>">หน้าที่ 2 ติดต่อQ&A</a>
                                    </li>
                                </ul>
                                <!--conternt !-->
                                <div class="tab-content">
                                    <!-- claim tab -->
                                    <div id="claim<?= $selled['selled_id']; ?>" class="tab-pane active">
                                        <br>
                                        <div class="form-group">
                                            <p for="detail<?= $selled['selled_id']; ?>">
                                            <h5>ตัวอย่างสาเหตุปัญหา</h5>
                                            </p>
                                            <ol>
                                                <li>รหัสผ่านไม่ถูกต้อง / ไม่สามารถเข้าไอดีได้</li>
                                                <li>ไอดีหมดอายุ ขึ้นให้จ่าย / Update Payment</li>
                                                <li>จอซ้อน / หน้าจอเต็ม</li>
                                            </ol>
                                            <div class="container mb-3">
                                                <fieldset align="center" style="border-radius: 3px;">
                                                    <h5>อัพโหลดรูปภาพ</h5>
                                                    <form method="POST" enctype="multipart/form-data">
                                                        <input type="file" id="files<?= $selled['selled_id']; ?>" name="files[]" multiple="multiple" accept="image/*" onchange="uploadfile(this, <?= $selled['selled_id']; ?>)">
                                                    </form>
                                                    <div class="mt-3" id="warpimg<?= $selled['selled_id']; ?>" style="display: none;" align="start">
                                                        <span>ไฟล์ที่อัพโหลด</span>
                                                        <ul id="imglist<?= $selled['selled_id']; ?>" style="list-style-type: none;"></ul>
                                                    </div>
                                                    <div class="form-group mt-4" align="center">
                                                        <textarea id="detail<?= $selled['selled_id']; ?>" class="form-control" style="width: 88%;min-height: 100px" placeholder="ระบุปัญหาและรายละเอียด" autofocus></textarea>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <span style="color: green;" align="center"><b>การเคลมสินค้ามีปัญหา ไอดีใหม่จะแสดงแทนที่อันเดิมใน </b><br align="center"><b>" ออเดอร์ที่แจ้งปัญหา "</b></span>
                                            <span style="color: red;">

                                                <b><br><br>*หมายเหตุ </b>
                                                <ol style="color: black;">
                                                    <li>แจ้งปัญหาผ่านเว็บ<u></u> หลังทางร้านตรวจสอบ จะได้รับ<br>ไอดีใหม่ในออเดอร์ที่แจ้ง</li>
                                                    <li>ในกรณี<u> ถูกปฏิเสธ</u> โปรดติดต่อไลน์ร้านเพื่อแก้ไขปัญหา</li>

                                                </ol>
                                            </span>

                                        </div>
                                        <div class="modal-footer p-2 border-0 form-group">
                                            <button id="claimbtn<?= $selled['selled_id']; ?>" type="button" class="btn btn-success" onclick="dosomething(<?= $selled['selled_id']; ?>)"><i class="fas fa-check-circle"></i> ส่งเคลม</button>
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
                                            <h5 style="color: green;margin-top: 0px;">สแกน QR CODE เพื่อติดต่อร้าน</h5>
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
            $i++;
        } while ($i < $total_selled_row);
    }
}

?>