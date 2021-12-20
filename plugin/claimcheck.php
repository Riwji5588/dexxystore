<?php

include("hyper_api.php");
include("../api/sendnoti/sendmsg.php");
$errorMSG = "";
$successMSG = "";

/* 

    type == 1 -> Back to stock
    type == 2 -> do nothing

    confirm == 0 -> request
    confirm == 1 -> Back to stock
    confirm == 2 -> do nothing

*/

if (isset($_POST['id'])) {

    $sid = $_COOKIE['USER_SID'] ?? $_REQUEST['sid'];
    $var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
    $user_query = $hyper->connect->query($var);
    $total_user = mysqli_num_rows($user_query);
    if ($total_user == 1) {

        $data_user = $hyper->connect->query($var)->fetch_array();

        $id = $_POST['id'];
        $uid = $data_user['ac_id'];

        $data_selled = "SELECT * FROM data_selled WHERE selled_id = $id";


        $selled = $hyper->connect->query($data_selled)->fetch_array();

        $sql = "SELECT * FROM game_data WHERE data_id = {$selled['data_id']}";
        $card_id = $hyper->connect->query($sql)->fetch_array();

        // admin confirmed or reject

        if ($_POST['type'] == 1) { // Go to stock

            $update_table = "UPDATE data_claim_first SET confirm=1 WHERE claim_id={$selled['selled_id']}";

            $update_id = "UPDATE game_data SET selled=0 WHERE data_id={$selled['data_id']}"; // back to sell

            if ($hyper->connect->query($update_table) && $hyper->connect->query($update_id)) {
                $select_admin = "SELECT * FROM accounts WHERE role=779";
                $admin_query = $hyper->connect->query($select_admin);
                $admin_num = mysqli_num_rows($admin_query);
                for ($i = 0; $i < $admin_num; $i++) {
                    $admin = $admin_query->fetch_array();
                    $message = "\n‼️ ถึงแอดมิน ‼️ \n";
                    $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "\n";
                    $message .= "สถานะ : นำกลับไปจำหน่อย \n";
                    $message .= "โดย : " . $data_user['username'] . "\n";
                    if ($admin['line_token'] != NULL) {

                        $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                    }
                }
                $successMSG = "นำกลับไปจำหน่อย สำเร็จ!";
            } else {
                $errorMSG = "นำกลับไปจำหน่อยไม่สำเร็จ... กรุณาติดต่อผู้ดูแลระบบ";
            }
        } else { // do nothing

            $update_table = "UPDATE data_claim_first SET confirm=2 WHERE claim_id={$selled['selled_id']}";

            if ($hyper->connect->query($update_table)) {
                $select_admin = "SELECT * FROM accounts WHERE role=779";
                $admin_query = $hyper->connect->query($select_admin);
                $admin_num = mysqli_num_rows($admin_query);
                for ($i = 0; $i < $admin_num; $i++) {
                    $admin = $admin_query->fetch_array();
                    $message = "\n‼️ ถึงแอดมิน ‼️ \n";
                    $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "\n";
                    $message .= "สถานะ : ตรวจสอบแล้ว \n";
                    $message .= "โดย : " . $data_user['username'] . "\n";
                    if ($admin['line_token'] != NULL) {

                        $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                    }
                }
                $successMSG = "ตรวจสอบสำเร็จ!";
            } else {
                $errorMSG = "เกิดข้อผิดพลาด... กรุณาติดต่อผู้ดูแลระบบ (1)";
            }
        }
    }
} else {
    $errorMSG = "เกิดข้อผิดพลาด... กรุณาติดต่อผู้ดูแลระบบ";
}


/* result */
if (empty($errorMSG)) {
    echo json_encode(['code' => 200, 'msg' => $successMSG]);
} else {
    echo json_encode(['code' => 500, 'msg' => $errorMSG]);
}
