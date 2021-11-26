<?php
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/hyper_class.php';

$hyper = (object) array(
    "user" => new User,
    "connect" => mysqli_connect($db_cofig['db_host'], $db_cofig['db_user'], $db_cofig['db_pass'], $db_cofig['db_name']),
);


function sendNotify($from, $to, $type, $orderid)
{
    // claim    -> status = 0
    // confirm  -> status = 1
    // reject   -> status = 2

    global $hyper;
    date_default_timezone_set("Asia/Bangkok");
    $datetime = date("Y-m-d H:i:s");
    $admin = 1;

    if (is_string($to)) {
        if ($to == 'admin') {
            $to_user = "SELECT * FROM accounts WHERE role=779";
        }
    } else {
        $to_user = "SELECT * FROM accounts WHERE ac_id='$to'";
    }
    $from_user = "SELECT * FROM accounts WHERE ac_id='$from'";
    $from_user_data = $hyper->connect->query($from_user)->fetch_array();
    $to_user_data = mysqli_fetch_all($hyper->connect->query($to_user));
    $row = mysqli_num_rows($hyper->connect->query($to_user));

    // print_r($to_user_data);

    if ($type == "claim") { //when user send claim then admin will recept it
        for ($i = 0; $i < $row; $i++) {
            $msg = "<b>{$from_user_data['username']}</b> ทำการขอเคลมสินค้าออเดอร์ที่<b> {$orderid}</b> " ; // to admin
            $encode = base64_encode($msg);
            $sql = "INSERT INTO notify_log(_from, _to, message, isadmin, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[$i][0]}, '{$encode}', $admin, '{$datetime}')";
            $hyper->connect->query($sql);
        }
        // echo $hyper->connect->error;
    } else if ($type == "confirm") { //when admin confirm claim then user will recept it
        $msg = "ออเดอร์ <b>{$orderid}</b> ของคุณได้รับการอนุมัติแล้ว! "; // to user
        $encode = base64_encode($msg);
        $sql = "INSERT INTO notify_log(_from, _to, message, status, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[0][0]}, '{$encode}', 1, '{$datetime}')";
        $hyper->connect->query($sql);
    }
    else if ($type == "reject") { //when admin confirm claim then user will recept it
        $msg = "ออเดอร์ <b>{$orderid}</b> ของคุณได้ถูกปฏิเสธ! "; // to user
        $encode = base64_encode($msg);
        $sql = "INSERT INTO notify_log(_from, _to, message, status, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[0][0]}, '{$encode}', 2, '{$datetime}')";
        $hyper->connect->query($sql);
    }
}
