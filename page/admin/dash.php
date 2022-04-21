<?php
date_default_timezone_set("Asia/Bangkok");

$game_type = "SELECT count(game_id) AS 'totalgame' FROM game_type";
$game_type_row = $hyper->connect->query($game_type)->fetch_array();

$data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE selled = 0";
$ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

$data_selled = "SELECT count(data_id) AS 'totalselled' FROM data_selled";
$selled_row = $hyper->connect->query($data_selled)->fetch_array();

$account = "SELECT count(ac_id) AS 'totalaccount' FROM accounts";
$account_row = $hyper->connect->query($account)->fetch_array();

$today = date("Y-m-d", strtotime("today"));
$sdate = $today . ' 00:00:00';
$edate = $today . ' 23:59:59';
$pay = "SELECT SUM(amount) AS 'totalpay' FROM history_pay WHERE date BETWEEN '$sdate' AND '$edate'";
$pay_row = $hyper->connect->query($pay)->fetch_array();

$alert = "SELECT count(id) AS 'totalalert' FROM data_claim WHERE confirm = 0";
$alert_row = $hyper->connect->query($alert)->fetch_array();

$ftalert = "SELECT count(id) AS 'totalfirstalert' FROM data_claim_first WHERE confirm = 0";
$ftalert_row = $hyper->connect->query($ftalert)->fetch_array();

$plusdate = $hyper->datethai->DateThai2(date("Y-m-d", strtotime("+30 day")));
?>

<!-- Dashboard -->

<h3 class="text-center mt-4" style="color: white;">--- เมนูการจัดการเว็บไซต์ ---</h3>

<div class="col-12 col-md-12 d-flex justify-content-end ">
    <div class="form-group">
        <div id="modalbackdrop" class="btn btn-secondary px-3 py-2 w-100" data-toggle="modal" data-target="#gentext">
            <i class="fas fa-keyboard"></i> ฟอร์มคัดลอก
        </div>
    </div>
</div>

<!-- Menu Bar -->
<div class="row no-gutters mt-1">

    <div class="col-6 col-lg-4 p-2">
        <a href="gametype">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-gamepad"></i></h1>
                <h1 class="mt-0 mb-0"><?= number_format($game_type_row['totalgame'], 0); ?></h1>
                <font class="text-muted">Netflixทั้งหมดในระบบ</font>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-4 p-2">
        <a href="gameselect">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-check-circle"></i></h1>
                <h1 class="mt-0 mb-0"><?= number_format($ready_selled_row['totaldata'], 0); ?></h1>
                <font class="text-muted">Netflixพร้อมจำหน่าย</font>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-4 p-2">
        <a href="dataowner">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-box-full"></i></h1>
                <h1 class="mt-0 mb-0"><?= number_format($selled_row['totalselled'], 0); ?></h1>
                <font class="text-muted">Netflixถูกจำหน่ายแล้ว</font>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-4 p-2">
        <a href="datauser">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-users"></i></h1>
                <h1 class="mt-0 mb-0"><?= number_format($account_row['totalaccount'], 0); ?></h1>
                <font class="text-muted">ผู้ใช้งานในระบบ</font>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-4 p-2">
        <a href="datapay">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-coins"></i></h1>
                <h1 class="mt-0 mb-0"><?= number_format($pay_row['totalpay'], 0); ?></h1>
                <font class="text-muted">รายได้ในวันนี้</font>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-4 p-2">
        <a href="websetting">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-cogs"></i></h1>
                <h1 class="mt-0 mb-0">ตั้งค่า</h1>
                <font class="text-muted">ตั้งค่าเว็บไซต์</font>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 p-2">
        <a href="report">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fas fa-exclamation-triangle"></i></h1>
                <h1 class="mt-0 mb-0"><?= $alert_row['totalalert'] ?></h1>
                <font class="text-muted">รออนุมัติการเคลม</font>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 p-2">
        <a href="reportfirst">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fas fa-exclamation-triangle"></i></h1>
                <h1 class="mt-0 mb-0"><?= $ftalert_row['totalfirstalert'] ?></h1>
                <font class="text-muted">การเคลมครั้งแรก</font>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 p-2">
        <a href="dellog">
            <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="far fa-trash-alt"></i></h1>
                <h1 class="mt-0 mb-0">ถังขยะ</h1>
                <font class="text-muted">ประการลบ</font>
            </div>
        </a>
    </div>
</div>
<!-- End Menu Bar -->

<!-- End Dashboard -->

<!-- Gen text -->
<div class="modal fade" id="gentext" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="col-12 p-0">
                                <input type="text" class="form-control" id="genid" placeholder="email:password:display">
                                <textarea id="result"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="btn-copy">ฟอร์มส่งลูกค้า</label>
                            <div class="col-12 p-0">
                                <button id="btn-copy" class="btn btn-dark btn-sm w-100" type="button" onclick="gen(1)"><i class='far fa-copy'></i> คัดลอก</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="btn-copy">ฟอร์มเคลม</label>
                            <div class="col-12 p-0">
                                <button id="btn-copy2" class="btn btn-dark btn-sm w-100" type="button" onclick="gen(2)"><i class='far fa-copy'></i> คัดลอก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="closebackdrop" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> ปิด</button>
            </div>
        </div>
    </div>
</div>
<div class="backdroppp"></div>
<style>
    body {
        background-color: #131315;
    }

    .backdroppp {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1030;
    }

    @media screen and (max-width: 576px) {
        .backdroppp {
            display: block;
        }
    }
</style>

<script>
    $(document).ready(() => {
        $('#result').hide();
        $('.backdroppp').hide();
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            // true for mobile device
            $('#modalbackdrop').on('click', () => {
                $('.backdroppp').show();
            });

            $('#closebackdrop').on('click', () => {
                $('.backdroppp').hide();
            });
        }

    })

    function gen(type) {
        let datalist = $('#genid').val().split(':');
        if (datalist.length == 3) {
            text1 = `Email: ${datalist[0]}

Pass: ${datalist[1]}

🪔 จอ : ${datalist[2]}

🚨 หากทำผิดกฎ 
🚨 การประกันจะถูกยกเลิกนะครับ

▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀▄▀

ประกันสินค้า :  <?= $plusdate ?> 
(ต่อเดือนถัดไป แจ้งก่อน 3 วันนะครับ)


กฎการใช้งาน Ⓜ

1. สามารถเปลี่ยนได้เพียงซับและเสียงพากย์ตอนเล่นคลิปเท่านั้น

2. ห้ามเปลี่ยนข้อมูลอื่นๆ เช่น
❌ ชื่อจอ
❌ รูปจอ
❌ ภาษาของเมนู
❌ หรือล๊อคจอ

3.ห้ามแชร์รหัสให้ผู้อื่นใช้งานร่วมทุกกรณี ใช้เพียง 1 คนเท่านั้น

4.ในคอมแนะนำดูผ่าน แอพNetflix จาก Microsoft store ครับ

⫘⫘⫘⫘⫘⫘⫘⫘⫘⫘

ในบางช่วงอาจมีการตอบช้า - เร็ว 
นะครับเนื่องจากอ่านหนังสือ
คุณลูกค้าสามารถรีวิวเพื่อเป็นกำลังใจให้พ่อค้าได้ที่ #reviewdex`

            text2 = `Mail: ${datalist[0]}

Pass: ${datalist[1]}

จอ: ${datalist[2]}`;
            $('#result').val(type == 1 ? text1 : text2);
            copyToClipboard(type);
        } else {
            alert('รูปแบบข้อมูลไม่ถูกต้อง');
        }
    }

    function copyToClipboard(type) {
        let copytext = document.getElementById('result');
        let input = document.getElementById(type == 1 ? 'btn-copy' : 'btn-copy2');
        copytext.style.display = "block";
        copytext.select();
        copytext.setSelectionRange(0, 99999)
        document.execCommand("copy");
        copytext.style.display = "none";
        input.innerHTML = "<i class='far fa-copy'></i> คัดลอกแล้ว";
        input.className = "btn btn-success btn-sm w-100";
        setTimeout(function() {
            input.innerHTML = "<i class='far fa-copy'></i> คัดลอก";
            input.className = "btn btn-dark btn-sm w-100";
        }, 2000);
        $('#genid').val("");
        $('#result').val("");
    }
</script>