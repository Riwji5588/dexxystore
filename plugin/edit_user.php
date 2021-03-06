<?php

include("hyper_api.php");
$errorMSG = "";

if (isset($_POST['user_id'])) {

    if ($_POST['point'] == null || $_POST['point'] < 0) {
        $errorMSG = "กรุณากรอก Points";
    } else {

        if (empty($_POST['email'])) {
            $errorMSG = "กรุณากรอก E-mail";
        } else {

            if (empty($_POST['role'])) {
                $errorMSG = "กรุณาเลือก ระดับผู้ใช้งาน";
            } else {

                $uid = $_POST['user_id'];
                $point = $_POST['point'];
                $email = $_POST['email'];
                $role = $_POST['role'];

                $banbuy = $_POST['banbuy'];
                $banclaim = $_POST['banclaim'];
                $banclaim_first = $_POST['banclaimfirst'];

                $ban_select = "SELECT * FROM user_ban WHERE ac_id = '$uid'";
                $row = $hyper->connect->query($ban_select)->num_rows;

                if ($row == 0) {
                    $ban_insert = "INSERT INTO user_ban (ac_id, buy, claim, claim_first) VALUES ('$uid', '$banbuy', '$banclaim', '$banclaim_first')";
                    $ban_query = $hyper->connect->query($ban_insert);
                } else {
                    $ban_update = "UPDATE user_ban SET buy = '$banbuy', claim = '$banclaim', claim_first = '$banclaim_first' WHERE ac_id = '$uid'";
                    $ban_query = $hyper->connect->query($ban_update);
                }

                if (isset($_POST['banorders'])) {
                    $banlist = $_POST['banorders'];

                    $orders = explode(",", $banlist);
                    if ($hyper->connect->query("UPDATE data_selled SET ban=0 WHERE ac_id='$uid'")) {

                        if (count($orders) > 0) {
                            foreach ($orders as $order) {
                                $sql = "UPDATE data_selled SET ban=1 WHERE selled_id='$order'";
                                $order_query = $hyper->connect->query($sql);
                            }
                        }
                    }
                }

                $update_data_sql = "UPDATE accounts SET points = '" . $point . "', email = '" . $email . "', role = '" . $role . "' WHERE ac_id = $uid";
                $query_data_update = $hyper->connect->query($update_data_sql);
                if (!$query_data_update || !$ban_query || isset($order_query) && !$order_query) {
                    $errorMSG = "อัพเดทข้อมูลไม่สำเร็จ";
                }
            }
        }
    }

    /* result */
    if (empty($errorMSG)) {
        echo json_encode(['code' => 200,]);
    } else {
        echo json_encode(['code' => 500, 'msg' => $errorMSG]);
    }
} else {
    header("Location: 403.php");
}
