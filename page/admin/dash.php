<?php
    date_default_timezone_set("Asia/Bangkok");

    $game_type = "SELECT count(game_id) AS 'totalgame' FROM game_type";
    $game_type_row = $hyper->connect->query($game_type)->fetch_array();

    $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE selled = 0";
    $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

    $data_selled = "SELECT count(data_id) AS 'totalselled' FROM game_data WHERE selled = 1";
    $selled_row = $hyper->connect->query($data_selled)->fetch_array();

    $account = "SELECT count(ac_id) AS 'totalaccount' FROM accounts";
    $account_row = $hyper->connect->query($account)->fetch_array();

    $date = date("Y-m");
    $sdate = $date.'-01 00:00:01';
    $edate = $date.'-31 23:59:59';
    $pay = "SELECT SUM(amount) AS 'totalpay' FROM history_pay WHERE date BETWEEN '$sdate' AND '$edate'";
    $pay_row = $hyper->connect->query($pay)->fetch_array();

?>

<!-- Dashboard -->

 <h3 class="text-center mt-4">--- เมนูการจัดการเว็บไซต์ ---</h3>

<!-- Menu Bar -->
<div class="row no-gutters mt-4">

    <div class="col-6 col-lg-4 p-2">
        <a href="gametype"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-gamepad"></i></h1>
            <h1 class="mt-0 mb-0"><?= number_format($game_type_row['totalgame'],0); ?></h1>
            <font class="text-muted">เกมทั้งหมดในระบบ</font>
        </div></a>
    </div>
    
    <div class="col-6 col-lg-4 p-2">
      <a href="gameselect"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-check-circle"></i></h1>
            <h1 class="mt-0 mb-0"><?= number_format($ready_selled_row['totaldata'],0); ?></h1>
            <font class="text-muted">ไอดีพร้อมจำหน่าย</font>
        </div></a>
    </div>
    
    <div class="col-6 col-lg-4 p-2">
      <a href="dataowner"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-box-full"></i></h1>
            <h1 class="mt-0 mb-0"><?= number_format($selled_row['totalselled'],0); ?></h1>
            <font class="text-muted">ไอดีถูกจำหน่ายแล้ว</font>
        </div></a>
    </div>

    <div class="col-6 col-lg-4 p-2">
      <a href="datauser"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-users"></i></h1>
            <h1 class="mt-0 mb-0"><?= number_format($account_row['totalaccount'],0); ?></h1>
            <font class="text-muted">ผู้ใช้งานในระบบ</font>
        </div></a>
    </div>

    <div class="col-6 col-lg-4 p-2">
      <a href="datapay"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-coins"></i></h1>
            <h1 class="mt-0 mb-0"><?= number_format($pay_row['totalpay'],0); ?></h1>
            <font class="text-muted">รายได้ในเดือนนี้</font>
        </div></a>
    </div>

    <div class="col-6 col-lg-4 p-2">
      <a href="websetting"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-cogs"></i></h1>
            <h1 class="mt-0 mb-0">ตั้งค่า</h1>
            <font class="text-muted">ตั้งค่าเว็บไซต์</font>
        </div></a>
    </div>
    <div class="col-6 col-lg-4 p-2">
      <a href="report"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
            <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fas fa-exclamation-triangle"></i></h1>
            <h1 class="mt-0 mb-0">จำนวนการแจ้งเตือน</h1>
            <font class="text-muted">แจ้งปัญหาการใช้งาน</font>
        </div></a>
    </div>

</div>
<!-- End Menu Bar -->

<!-- End Dashboard -->