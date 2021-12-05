<?php

include("hyper_api.php");
$errorMSG = "";

if (isset($_POST['id'])) {

    $sid = $_COOKIE['USER_SID'];
    $var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
    $user_query = $hyper->connect->query($var);
    $total_user = mysqli_num_rows($user_query);
    if ($total_user == 1) {

        $data_user = $hyper->connect->query($var)->fetch_array();

        $id = $_POST['id'];
        $uid = $data_user['ac_id'];

        $card_sql = "SELECT * FROM game_card WHERE card_id = $id";
        $card = $hyper->connect->query($card_sql)->fetch_array();

        $p = $data_user['points'] - $card['card_price'];


        if ($p < 0) {
            $errorMSG = "เงินไม่เพียงพอ กรุณาเติมเงิน";
        } else {

            $updateuser = "UPDATE accounts SET points = '" . $p . "' WHERE ac_id = $uid";
            $updateuser_query = $hyper->connect->query($updateuser);
            if ($updateuser_query) {

                if ($_POST['type'] == 1) {
                    date_default_timezone_set("Asia/Bangkok");
                    $date = date("Y-m-d H:i:s");
                    $expire = date("Y-m-d H:i:s", strtotime("+30 day"));

                    $data_sql = "SELECT * FROM game_data WHERE card_id = $id AND selled = 0 LIMIT 1";
                    $data = $hyper->connect->query($data_sql)->fetch_array();

                    $data_id = $data['data_id'];

                    $updatedata = "UPDATE game_data SET selled = 1 WHERE data_id = $data_id";
                    $updatedata_query = $hyper->connect->query($updatedata);
                    if ($updatedata_query) {

                        $selled_sql = "INSERT INTO data_selled (data_id, ac_id, selled_date, exp_date) VALUE ('$data_id', '$uid', '$date', '$expire')";
                        $selled_query = $hyper->connect->query($selled_sql);

                        $selled_id_sql = "SELECT selled_id FROM data_selled WHERE data_id='$data_id'";
                        $selled_id_query = $hyper->connect->query($selled_id_sql);
                        $selled_id = $selled_id_query->fetch_array();

                        if (!$selled_query) {
                            $errorMSG = 'ซื้อสินค้า ไม่สำเร็จ!';
                        }
                    } else {
                        $errorMSG = 'ซื้อสินค้า ไม่สำเร็จ!';
                    }
                } else {
                    $id = $_POST['selled_id'];
                    $selled_sql = "SELECT * FROM data_selled WHERE selled_id = $id";
                    $selled_query = $hyper->connect->query($selled_sql);
                    $selled = $selled_query->fetch_array();
                    $expire = strtotime($selled['exp_date'] . '+30 day');
                    $new_expire = date("Y-m-d H:i:s", $expire);
                    $updatedata = "UPDATE data_selled SET exp_date = '$new_expire' WHERE selled_id = $id";
                    $updatedata_query = $hyper->connect->query($updatedata);

                    $selled_id_sql = "SELECT selled_id FROM data_selled WHERE selled_id='$id'";
                    $selled_id_query = $hyper->connect->query($selled_id_sql);
                    $selled_id = $selled_id_query->fetch_array();
                    if (!$updatedata_query) {
                        $errorMSG = 'ต่ออายุไม่สำเร็จ!';
                    }
                }
            } else {
                $errorMSG = 'เกิดข้อผิดพลาด...กรุณาติดต่อแอดมิน';
            }
        }
    } else {
        $errorMSG = "ไม่สำเร็จ!";
    }




    /* result */
    if (empty($errorMSG)) {
        echo json_encode(['code' => 200, 'order' => $selled_id['selled_id']]);
    } else {
        echo json_encode(['code' => 500, 'msg' => $errorMSG]);
    }
} else {
    header("Location: 403.php");
}
