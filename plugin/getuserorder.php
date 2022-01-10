<?php
include('./hyper_api.php');
$orders = [];

date_default_timezone_set("Asia/Bangkok");

if (isset($_POST)) {
    $ac_id = $_POST['ac_id'];
    $sellect_order = "SELECT * FROM data_claim WHERE ac_id={$ac_id}";
    $order = $hyper->connect->query($sellect_order)->fetch_assoc();
    $now = strtotime(date('Y-m-d H:i:s'));
}
