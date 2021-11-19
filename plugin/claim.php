<?php

include("hyper_api.php");
$errorMSG = "";
$successMSG = "";

/* 
    claim == 0 -> not claim yet
    claim == 1 -> claim success or confirm by admin
    claim == 2 -> send claim request to admin
    claim == 3 -> claim fail or reject by admin

    type == 1 -> claim
    type == 2 -> confirm
    type == 3 -> reject

    confirm == 0 -> request
    confirm == 1 -> confirm
    confirm == 2 -> reject
*/

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

        if ($_POST['type'] == 1) { // send claim

            $detail = $_POST['detail'];

            if (!empty($detail)) {

                if ($selled['claim'] == 0) { // send first time

                    $data_game = "SELECT * FROM game_data WHERE selled = 0 LIMIT 1";
                    $row = $hyper->connect->query($data_game);
                    $game = $row->fetch_array();

                    if (mysqli_num_rows($row) == 1) {
                        date_default_timezone_set("Asia/Bangkok");
                        $claim_date = date("Y-m-d H:i:s");
                        $sendClaim = "INSERT INTO data_claim(claim_id, data_id, ac_id, detail, claim_date, confirm) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$detail', '$claim_date', 1)";
                        if ($hyper->connect->query($sendClaim)) {
                            $data_selled_update = "UPDATE data_selled SET claim = 1, data_id = {$game['data_id']} WHERE selled_id = {$selled['selled_id']}";
                            $data_game_update = "UPDATE game_data SET selled = 1 WHERE data_id = {$game['data_id']}";

                            if ($hyper->connect->query($data_selled_update) && $hyper->connect->query($data_game_update)) {
                                $successMSG = "เคลม สำเร็จ!";
                            } else {
                                $errorMSG = "เคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (2)";
                            }
                        } else {
                            $errorMSG = "เคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (1)";
                        }
                    } else {
                        $errorMSG = "ไม่เหลือไอดีในระบบ... กรุณาแจ้งแอดมิน";
                    }
                } else { // send second time or more
                    date_default_timezone_set("Asia/Bangkok");
                    $claim_date = date("Y-m-d H:i:s");
                    $sendClaim = "INSERT INTO data_claim(claim_id, data_id, ac_id, detail, claim_date) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$detail', '$claim_date')";
                    if ($hyper->connect->query($sendClaim)) {
                        $data_selled_update = "UPDATE data_selled SET claim = 2 WHERE selled_id = {$selled['selled_id']}"; // set claim 2 = send claim and waiting for confirm
                        if ($hyper->connect->query($data_selled_update)) {
                            $successMSG = "ส่งเคลม สำเร็จ!";
                        } else {
                            $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (2)";
                        }
                    } else {
                        $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (1)";
                    }
                }
            } else {
                $errorMSG = "กรุณากรอกเหตุผลการเคลม";
            }
        } else {    // admin confirmed or reject

            if ($_POST['type'] == 2) {

                date_default_timezone_set("Asia/Bangkok");
                $claim_date = date("Y-m-d H:i:s");

                $data_game = "SELECT * FROM game_data WHERE selled = 0 LIMIT 1";
                $row = $hyper->connect->query($data_game);
                $game = $row->fetch_array();

                if (mysqli_num_rows($row) == 1) {

                    $confirm = "UPDATE data_claim SET confirm = 1 WHERE claim_id={$selled['selled_id']} AND confirm=0";
                    $data_selled_update = "UPDATE data_selled SET claim = 1, data_id = {$game['data_id']}, exp_date = '$claim_date 'WHERE selled_id = {$selled['selled_id']} AND claim=2";
                    $data_game_update = "UPDATE game_data SET selled = 1 WHERE data_id = {$game['data_id']}";

                    if ($hyper->connect->query($confirm) && $hyper->connect->query($data_selled_update) && $hyper->connect->query($data_game_update)) {
                        $successMSG = "อนุมัติ สำเร็จ!";
                    } else {
                        $errorMSG = "เคลมไม่สำเร็จ... กรุณาติดต่อผู้ดูแลระบบ";
                    }
                } else {
                    $errorMSG = "ไม่เหลือไอดีในระบบ... กรุณาเพิ่มข้อมูล";
                }
            } else {
                $reject = "UPDATE data_claim SET confirm = 2 WHERE claim_id={$selled['selled_id']} AND confirm=0";
                $reject_selled = "UPDATE data_selled SET claim = 3 WHERE selled_id = {$selled['selled_id']}";
                if ($hyper->connect->query($reject) && $hyper->connect->query($reject_selled)) {
                    $successMSG = "ปฏิเสธ สำเร็จ!";
                } else {
                    $errorMSG = "เกิดข้อผิดพลาด... กรุณาติดต่อผู้ดูแลระบบ";
                }
            }
        }
    } else {
        $errorMSG = "เกิดปัญหาในการส่งเคลม";
    }



    /* result */
    if (empty($errorMSG)) {
        echo json_encode(['code' => 200, 'msg' => $successMSG]);
    } else {
        echo json_encode(['code' => 500, 'msg' => $errorMSG]);
    }
} else {
    header("Location: 403.php");
}
