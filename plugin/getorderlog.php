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

            // present owner
            $sql = "SELECT selled_id, data_id, ac_id, selled_date, exp_date, ban FROM data_selled WHERE selled_id = '$orderid'";
            $query_present = $hyper->connect->query($sql);
            $result_present = $query_present->fetch_assoc();

            $data_id = $result_present['data_id'];

            $sql = "SELECT card_id, username, password, display FROM game_data WHERE data_id = '$data_id'";
            $query_data = $hyper->connect->query($sql);
            $result_data = $query_data->fetch_assoc();

            $result_present += [
                'username' => $result_data['username'],
                'password' => $result_data['password'],
                'display' => $result_data['display'],
            ];

            // Owner
            $sql = "SELECT username FROM accounts WHERE ac_id = '" . $result_present['ac_id'] . "'";
            $query_owner = $hyper->connect->query($sql);
            $result_owner = $query_owner->fetch_assoc();

            $result_present += [
                'owner' => $result_owner['username'],
            ];

            $card_id = $result_data['card_id'];

            $sql = "SELECT card_title, card_price FROM game_card WHERE card_id = '$card_id'";
            $query_card = $hyper->connect->query($sql);
            $card = $query_card->fetch_assoc();

            $result_present += [
                'card_title' => $card['card_title'],
                'card_price' => $card['card_price']
            ];

            $select_img = "SELECT image_name FROM card_image WHERE card_id = '$card_id'";
            $query_img = $hyper->connect->query($select_img);
            $img = mysqli_fetch_assoc($query_img)['image_name'];

            $result_present += [
                'image_name' => $img
            ];

            // get claim log
            $sql_select_claim = "SELECT data_id, claim_date, confirm FROM data_claim WHERE claim_id = '" . $orderid . "' ORDER BY id ASC";
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
            $sql_select_claim_first = "SELECT data_id, claim_date, confirm FROM data_claim_first WHERE claim_id = '" . $orderid . "' ORDER BY id ASC";
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

if (count($claim) == 0) $claim = null;
if (count($claim_first) == 0) $claim_first = null;
if (count($renew) == 0) $renew = null;
if ($claim == null && $claim_first == null && $renew == null) {
    $errorMSG = "ไม่พบข้อมูลย้อนหลัง";
} else {
    $data = array([
        'present' => $result_present,
        'claim' => $claim,
        'claim_first' => $claim_first,
        'renew' => $renew
    ]);
}
if (empty($errorMSG)) {
    echo json_encode(['code' => 200, 'data' => $data]);
} else {
    echo json_encode(['code' => 500, 'present' => $result_present, 'message' => $errorMSG]);
}
