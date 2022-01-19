<?php
include("hyper_api.php");
$data = [];
$errormsg = "";

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

        if (!($total_pay_row == count($data))) {
            $errormsg = "Have error in query";
        }
    } else if ($_POST['action'] == 'todayincome') {
        if (isset($_POST['type'])) {
            $type = $_POST['type'];
            if ($type != "") {
                if ($type == 0 || $type == 1) {
                    $today = date("Y-m-d", strtotime("-{$type} day"));
                    $sdate = $today . ' 00:00:00';
                    $edate = $today . ' 23:59:59';
                } else {
                    $range = date("Y-m-d", strtotime("-{$type} day"));
                    $today = date("Y-m-d", strtotime("today"));
                    $sdate = $range . ' 00:00:00';
                    $edate = $today . ' 23:59:59';
                }
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

                if (!($total_pay_row == count($data))) {
                    $errormsg = "Have error in query";
                }
            } else {
                $errormsg = "Type is empty";
            }
        } else {
            $errormsg = "Invalid Type Request";
        }
    } else {
        $errormsg = "Invalid Request";
    }
} else {
    $errormsg = "Do not have any data";
}

if (empty($errormsg)) {
    echo json_encode(['code' => 200, 'data' => $data]);
} else {
    echo json_encode(['code' => 500, 'message' => $errormsg]);
}
