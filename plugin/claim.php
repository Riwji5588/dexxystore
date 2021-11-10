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

        $data_selled = "SELECT * FROM data_selled WHERE selled_id = $id";
        $selled = $hyper->connect->query($data_selled)->fetch_array();

        if ($selled['claim'] == 0) {

            $data_game = "SELECT * FROM game_data WHERE selled = 0 LIMIT 1";
            $row = $hyper->connect->query($data_game);
            $game = $row->fetch_array();

            if (mysqli_num_rows($row) == 1) {
                date_default_timezone_set("Asia/Bangkok");
                $claim_date = date("Y-m-d H:i:s");
                $sendClaim = "INSERT INTO data_claim(claim_id, data_id, ac_id, claim_date) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$claim_date')";
                if ($hyper->connect->query($sendClaim)) {
                    $data_selled_update = "UPDATE data_selled SET claim = 1, data_id = {$game['data_id']} WHERE selled_id = {$selled['selled_id']}";
                    $data_game_update = "UPDATE game_data SET selled = 1 WHERE data_id = {$game['data_id']}";

                    if ($hyper->connect->query($data_selled_update) && $hyper->connect->query($data_game_update)) {
                    } else {
                        $errorMSG = "เกิดข้อผิดพลาด";
                    }
                } else {
                    $errorMSG = "เคลมไม่สำเร็จกรุณาแจ้งแอดมิน (2)";
                }
            } else {
                $errorMSG = "เคลมไม่สำเร็จกรุณาแจ้งแอดมิน (1)";
            }
        } else {
            $errorMSG = "คุณเคยเคลมไอดีนี้ไปแล้ว";
        }
    } else {
        $errorMSG = "เกิดปัญหาในการส่งเคลม";
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
