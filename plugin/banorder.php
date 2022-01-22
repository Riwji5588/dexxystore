<?php

include('./hyper_api.php');
$error="";

if (isset($_POST)) {
    $orders_id = explode(',', $_POST['selled_id']);
    $order_count = count($orders_id);
    $count = 0;
    foreach ($orders_id as $order_id) {
        $ban = "UPDATE data_selled SET ban=1 WHERE selled_id = {$order_id}";
        $banned = $hyper->connect->query($ban);
        if ($banned) {
            $count++;
        } else {
            $error = "เกิดข้อผิดพลาดในการแบนไอดี " . $order_id;
            break;
        }
    }

    if ($count == $order_count) {
        echo json_encode(['msg' => 'ทำการแบนไอดีสำเร็จ']);
    } else {
        echo json_encode(['msg' => $error]);
    }
}
