<?php

include('./hyper_api.php');

if (isset($_POST)) {
    $orders_id = explode(',', $_POST['selled_id']);
    foreach ($orders_id as $order_id) {
        $ban = "UPDATE data_selled SET ban=1 WHERE selled_id = {$order_id}";
        $hyper->connect->query($ban);
    }
}
