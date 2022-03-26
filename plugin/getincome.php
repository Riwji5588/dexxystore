<?php
include("hyper_api.php");
$data = [];
$errormsg = "";

if (isset($_POST)) {
    if ($_POST['action'] == 'getincome') {
        $sql_select_pay = "SELECT username, link, amount, date, isadmin FROM history_pay";
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
        if (isset($_POST['start']) && isset($_POST['end'])) {
            $start = $_POST['start'];
            $end = $_POST['end'];
            if ($start != "" && $end != "") {
                $sql_select_pay = "SELECT username, link, amount, date, isadmin FROM history_pay WHERE date BETWEEN '" . $start . " 00:00:00" . "' AND '" . $end . " 23:59:59" . "' ORDER BY pay_id ASC";
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
                $errormsg = "Income data is empty";
            }
        } else {
            $errormsg = "Invalid income data Request";
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
