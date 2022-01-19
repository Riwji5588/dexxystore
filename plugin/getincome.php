<?php
include("hyper_api.php");
$data = [];

if (isset($_POST)) {
    if ($_POST['action'] == 'getincome') {
        $sql_select_pay = "SELECT username, link, amount, date FROM history_pay";
        $query_pay = $hyper->connect->query($sql_select_pay);
        $total_pay_row = mysqli_num_rows($query_pay);
        $i = 0;

        if ($total_pay_row > 0) {
            do {
                $pay = $query_pay->fetch_assoc();
                $data[] = $pay;
                $i++;
            } while ($i < $total_pay_row);
        }

        if ($total_pay_row == count($data)) {
            echo json_encode(['code' => 200, 'data' => $data]);
        } else {
            echo json_encode(['code' => 500, 'data' => 'Error']);
        }
    } else if ($_POST['action'] == 'todayincome') {
        $today = date("Y-m-d", strtotime("today"));
        $sdate = $today . ' 00:00:00';
        $edate = $today . ' 23:59:59';
        $sql_select_pay = "SELECT username, link, amount, date FROM history_pay WHERE date BETWEEN '" . $sdate . "' AND '" . $edate . "'";
        $query_pay = $hyper->connect->query($sql_select_pay);
        $total_pay_row = mysqli_num_rows($query_pay);
        $i = 0;
        if ($total_pay_row > 0) {
            do {
                $pay = $query_pay->fetch_assoc();
                $data[] = $pay;
                $i++;
            } while ($i < $total_pay_row);
        }

        if ($total_pay_row == count($data)) {
            echo json_encode(['code' => 200, 'data' => $data]);
        } else {
            echo json_encode(['code' => 500, 'data' => 'Error']);
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
