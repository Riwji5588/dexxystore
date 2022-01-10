<?php
include('./hyper_api.php');
$orders = [];

date_default_timezone_set("Asia/Bangkok");

if (isset($_POST)) {
    $ac_id = $_POST['ac_id'];
    $sellect_order = "SELECT selled_id, exp_date FROM data_selled WHERE ac_id={$ac_id}";
    $result = $hyper->connect->query($sellect_order);
    $row = mysqli_num_rows($result);
    $i = 0;
    do {
        $order = $result->fetch_assoc();
        $now = strtotime(date('Y-m-d H:i:s'));
        $order_date = strtotime(date($order['exp_date']));

        $expire = $order_date - $now;
        if ($expire > 0) {
            array_push($orders, (int)$order['selled_id']);
        }

        $i++;
    } while ($row > $i);

    echo json_encode($orders);
}
