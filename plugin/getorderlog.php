<?php
include('./hyper_api.php');
$errorMSG = "";
$claim = [];
$claim_first = [];
$renew = [];

if ($_POST) {
    if (isset($_POST['action']) && $_POST['action'] == 'getlog') {
        if (isset($_POST['orderid']) && !empty($_POST['orderid'])) {
            $orderid = $_POST['orderid'];
            // get claim log
            $sql_select_claim = "SELECT data_id, ac_id, claim_date, confirm FROM data_claim WHERE claim_id = '" . $orderid . "' ORDER BY id ASC";
            $query_claim = $hyper->connect->query($sql_select_claim);
            $row = mysqli_num_rows($query_claim);
            $i = 0;
            if ($row > 0) {
                do {
                    $claim1 = $query_claim->fetch_assoc();
                    array_push($claim, $claim1);
                    $i++;
                } while ($i < $row);
            }

            // get claim_first
            $sql_select_claim_first = "SELECT data_id, ac_id, claim_date, confirm FROM data_claim_first WHERE claim_id = '" . $orderid . "' ORDER BY id ASC";
            $query_claim_first = $hyper->connect->query($sql_select_claim_first);
            $row = mysqli_num_rows($query_claim_first);
            $i = 0;
            if ($row > 0) {
                do {
                    $claim_first1 = $query_claim_first->fetch_assoc();
                    array_push($claim_first, $claim_first1);
                    $i++;
                } while ($i < $row);
            }

            // get renew order 
            $sql_select_renew = "SELECT data_id, datetime FROM notify_log WHERE message = '" . $orderid . "' ORDER BY id ASC";
            $query_renew = $hyper->connect->query($sql_select_renew);
            $row = mysqli_num_rows($query_renew);
            $i = 0;
            if ($row > 0) {
                do {
                    $renew1 = $query_renew->fetch_assoc();
                    array_push($renew, $renew1);
                    $i++;
                } while ($i < $row);
            }

        } else {
            $errorMSG = "Order ID is empty";
        }
    } else {
        $errorMSG = "Invalid Request";
    }
} else {
    header("Location: 403.php");
}

if (empty($errorMSG)) {
    $data = array([
        'claim' => $claim,
        'claim_first' => $claim_first,
        'renew' => $renew
    ]);
    echo json_encode(['code' => 200, 'data' => $data]);
} else {
    echo json_encode(['code' => 500, 'message' => $errorMSG]);
}
