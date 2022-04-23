<?php

include("hyper_api.php");
include("../api/sendnoti/sendmsg.php");
$errorMSG = "";
$successMSG = "";
$token = [];
$line_data = [];

/* 
    line data = {
        {'message': string},
        {'line_token': []}
    }
*/

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
    confirm == 9 -> claim for first time
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

        $select_ban = "SELECT * FROM user_ban WHERE ac_id = '$uid'";
        $ban = $hyper->connect->query($select_ban)->fetch_assoc();

        $selled = $hyper->connect->query($data_selled)->fetch_array();

        $sql = "SELECT * FROM game_data WHERE data_id = {$selled['data_id']}";
        $card_id = $hyper->connect->query($sql)->fetch_array();

        if ($_POST['type'] == 1) { // send claim

            $detail = $_POST['detail'];
            $exp = strtotime($selled['exp_date']);
            $now = strtotime(date("Y-m-d"));
            if (($exp - $now) > 0) {
                if (!empty($detail)) {
                    if ($ban['claim'] == 1 || $selled['ban'] == 1) {
                        if ($ban['claim'] == 1) {
                            $errorMSG = "คุณถูกแบล็กลิสต์ไว้... โปรดติดต่อร้าน";
                        } else {
                            $errorMSG = "ไอดีนี้ถูกแบล็กลิสต์ไว้... โปรดติดต่อร้าน";
                        }
                    } else {
                        $Select_Exist = "SELECT id FROM data_claim WHERE claim_id = {$selled['selled_id']} AND data_id = {$selled['data_id']} AND ac_id = {$selled['ac_id']} AND confirm = 0 AND isSend = 1";
                        $Select_Exist1 = "SELECT id FROM data_claim_first WHERE claim_id = {$selled['selled_id']} AND data_id = {$selled['data_id']} AND ac_id = {$selled['ac_id']} AND confirm = 0 AND isSend = 1";
                        $query2 = $hyper->connect->query($Select_Exist);
                        $query3 = $hyper->connect->query($Select_Exist1);
                        $Exist_rows = mysqli_num_rows($query2);
                        $Exist_rows1 = mysqli_num_rows($query3);

                        if ($Exist_rows < 1 && $Exist_rows1 < 1) {

                            if ($selled['claim'] == 0 && $ban['claim_first'] == 0) { // send first time
                                date_default_timezone_set("Asia/Bangkok");
                                $selcetWeb = "SELECT timerange, isenable FROM web_config WHERE con_id = 1";
                                $web = $hyper->connect->query($selcetWeb)->fetch_assoc();

                                $isenable = $web['isenable'];
                                $timerange = $web['timerange'];
                                $rage = explode('-', $timerange);
                                $start = $rage[0];
                                $end = $rage[1];
                                $now = explode(':', date("H:i"));
                                $now = $now[0] * 60 + $now[1];

                                if ($isenable == '1' && $now >= $start && $now <= $end) {

                                    $data_game = "SELECT * FROM game_data WHERE selled=0 AND card_id={$card_id['card_id']} LIMIT 1";
                                    $row = $hyper->connect->query($data_game);
                                    $game = $row->fetch_array();
                                    if (mysqli_num_rows($row) == 1) {
                                        $claim_date = date("Y-m-d H:i:s");
                                        $sendClaim_first = "INSERT INTO data_claim_first(claim_id, data_id, ac_id, detail, claim_date, confirm) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$detail', '$claim_date', 0)";
                                        if ($hyper->connect->query($sendClaim_first)) {
                                            $data_selled_update = "UPDATE data_selled SET claim = 1, data_id = {$game['data_id']} WHERE selled_id = {$selled['selled_id']}";
                                            $data_game_update = "UPDATE game_data SET selled = 1 WHERE data_id = {$game['data_id']}";
                                            $select_claim_id = "SELECT id FROM data_claim_first ORDER BY id DESC LIMIT 1";
                                            $claim_id = $hyper->connect->query($select_claim_id)->fetch_assoc()['id'];
                                            if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
                                                $img_id = $_POST['img_id'];
                                                $img_list = explode(',', $img_id);

                                                foreach ($img_list as $key => $value) {
                                                    $sql = "UPDATE claim_image SET type=1, claim_id=$claim_id WHERE id = $value";
                                                    $Update_type = $hyper->connect->query($sql);
                                                }
                                            } else {
                                                $Update_type = true;
                                            }
                                            if ($hyper->connect->query($data_selled_update) && $hyper->connect->query($data_game_update) && $Update_type) {
                                                $select_admin = "SELECT * FROM accounts WHERE line_token != ''";
                                                $admin_query = $hyper->connect->query($select_admin);
                                                $admin_num = mysqli_num_rows($admin_query);

                                                // msg
                                                $message = "%0A=== ระบบเคลมอัตโนมัติ ===%0A";
                                                $message .= "‼️ ถึงแอดมิน ‼️ %0A";
                                                $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "%0A";
                                                $message .= "สถานะ : ส่งเคลม (ครั้งแรก)%0A";
                                                $message .= "โดย : " . $data_user['username'] . "%0A";
                                                $message .= "เหตุผล : " . $detail . "%0A";
                                                $message .= "ไปที่เว็บ : " . $hyper->url . "/reportfirst" . "&" . "id={$selled['selled_id']}";

                                                array_push($line_data, [
                                                    'massage' => $message,
                                                ]);

                                                for ($i = 0; $i < $admin_num; $i++) {
                                                    $admin = $admin_query->fetch_array();
                                                    $hyper->notify->sendNotify($selled['ac_id'], $admin['ac_id'], 'claim', $selled['selled_id']);
                                                    if ($admin['line_token'] != NULL) {

                                                        array_push($token, $admin['line_token']);
                                                        // $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                                                    }
                                                }
                                                array_push($line_data, [
                                                    'token' => join(",", $token)
                                                ]);
                                                $successMSG = "ส่งเคลม สำเร็จ!";
                                            } else {
                                                $errorMSG = "เคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (2)";
                                            }
                                        } else {
                                            $errorMSG = "เคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (1)";
                                        }
                                    } else {
                                        $errorMSG = "ไม่เหลือไอดีในระบบ... กรุณาแจ้งแอดมิน";
                                    }
                                } else {
                                    date_default_timezone_set("Asia/Bangkok");
                                    $claim_date = date("Y-m-d H:i:s");
                                    $sendClaim = "INSERT INTO data_claim(claim_id, data_id, ac_id, detail, claim_date, isSend) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$detail', '$claim_date', 1)";
                                    if ($hyper->connect->query($sendClaim)) {
                                        $data_selled_update = "UPDATE data_selled SET claim = 2 WHERE selled_id = {$selled['selled_id']}"; // set claim 2 = send claim and waiting for confirm
                                        $select_claim_id = "SELECT id FROM data_claim ORDER BY id DESC LIMIT 1";
                                        $claim_id = $hyper->connect->query($select_claim_id)->fetch_assoc()['id'];
                                        if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
                                            $img_id = $_POST['img_id'];
                                            $img_list = explode(',', $img_id);

                                            foreach ($img_list as $key => $value) {
                                                $sql = "UPDATE claim_image SET type=2, claim_id=$claim_id WHERE id = $value";
                                                $Update_type = $hyper->connect->query($sql);
                                            }
                                        } else {
                                            $Update_type = true;
                                        }
                                        if ($hyper->connect->query($data_selled_update) && $Update_type) {
                                            $select_admin = "SELECT * FROM accounts WHERE line_token != ''";
                                            $admin_query = $hyper->connect->query($select_admin);
                                            $admin_num = mysqli_num_rows($admin_query);

                                            // msg
                                            if ($web['isenable'] == '0') {
                                                $message = "%0A=== ปิดระบบเคลมอัตโนมัติ ===%0A";
                                            } else {
                                                $message = "%0A=== ไม่อยู่ในช่วงเวลาที่กำหนด ===%0A";
                                            }
                                            $message .= "‼️ ถึงแอดมิน ‼️ %0A";
                                            $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "%0A";
                                            $message .= "สถานะ : ส่งเคลม (ครั้งแรก)%0A";
                                            $message .= "โดย : " . $data_user['username'] . "%0A";
                                            $message .= "เหตุผล : " . $detail . "%0A";
                                            $message .= "ไปที่เว็บ : " . $hyper->url . "/report" . "&" . "id={$selled['selled_id']}";

                                            array_push($line_data, [
                                                'massage' => $message,
                                            ]);

                                            for ($i = 0; $i < $admin_num; $i++) {
                                                $admin = $admin_query->fetch_array();
                                                $hyper->notify->sendNotify($selled['ac_id'], $admin['ac_id'], 'claim', $selled['selled_id']);
                                                if ($admin['line_token'] != NULL) {
                                                    array_push($token, $admin['line_token']);
                                                    // $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                                                }
                                            }
                                            array_push($line_data, [
                                                'token' => join(",", $token)
                                            ]);

                                            $successMSG = "ส่งเคลม สำเร็จ!";
                                        } else {
                                            $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (2)";
                                        }
                                    } else {
                                        $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (1)";
                                    }
                                }
                            } else { // send second time or more
                                date_default_timezone_set("Asia/Bangkok");
                                $claim_date = date("Y-m-d H:i:s");
                                $sendClaim = "INSERT INTO data_claim(claim_id, data_id, ac_id, detail, claim_date, isSend) VALUES ('{$selled['selled_id']}', '{$selled['data_id']}', '{$selled['ac_id']}', '$detail', '$claim_date', 1)";
                                if ($hyper->connect->query($sendClaim)) {
                                    $data_selled_update = "UPDATE data_selled SET claim = 2 WHERE selled_id = {$selled['selled_id']}"; // set claim 2 = send claim and waiting for confirm
                                    $select_claim_id = "SELECT id FROM data_claim ORDER BY id DESC LIMIT 1";
                                    $claim_id = $hyper->connect->query($select_claim_id)->fetch_assoc()['id'];
                                    if (isset($_POST['img_id']) && !empty($_POST['img_id'])) {
                                        $img_id = $_POST['img_id'];
                                        $img_list = explode(',', $img_id);

                                        foreach ($img_list as $key => $value) {
                                            $sql = "UPDATE claim_image SET type=2, claim_id=$claim_id WHERE id = $value";
                                            $Update_type = $hyper->connect->query($sql);
                                        }
                                    } else {
                                        $Update_type = true;
                                    }
                                    if ($hyper->connect->query($data_selled_update) && $Update_type) {
                                        $select_admin = "SELECT * FROM accounts WHERE line_token != ''";
                                        $admin_query = $hyper->connect->query($select_admin);
                                        $admin_num = mysqli_num_rows($admin_query);

                                        // msg
                                        $message = "%0A‼️ ถึงแอดมิน ‼️ %0A";
                                        $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "%0A";
                                        $message .= "สถานะ : ส่งเคลม %0A";
                                        $message .= "โดย : " . $data_user['username'] . "%0A";
                                        $message .= "เหตุผล : " . $detail . "%0A";
                                        $message .= "ไปที่เว็บ : " . $hyper->url . "/report" . "&" . "id={$selled['selled_id']}";

                                        array_push($line_data, [
                                            'massage' => $message,
                                        ]);

                                        for ($i = 0; $i < $admin_num; $i++) {
                                            $admin = $admin_query->fetch_array();
                                            $hyper->notify->sendNotify($selled['ac_id'], $admin['ac_id'], 'claim', $selled['selled_id']);
                                            if ($admin['line_token'] != NULL) {
                                                array_push($token, $admin['line_token']);
                                                // $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                                            }
                                        }
                                        array_push($line_data, [
                                            'token' => join(",", $token)
                                        ]);

                                        $successMSG = "ส่งเคลม สำเร็จ!";
                                    } else {
                                        $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (2)";
                                    }
                                } else {
                                    $errorMSG = "ส่งเคลมไม่สำเร็จ... กรุณาแจ้งแอดมิน (1)";
                                }
                            }
                        } else {
                            $select_to_del = "SELECT id FROM data_claim WHERE claim_id = {$selled['selled_id']} AND data_id = {$selled['data_id']} AND ac_id = {$selled['ac_id']} AND confirm = 0 AND isSend = 0";
                            $select_to_del1 = "SELECT id FROM data_claim_first WHERE claim_id = {$selled['selled_id']} AND data_id = {$selled['data_id']} AND ac_id = {$selled['ac_id']} AND confirm = 0 AND isSend = 0";
                            $to_del = $hyper->connect->query($select_to_del);
                            $to_del1 = $hyper->connect->query($select_to_del);
                            $row = mysqli_num_rows($to_del);
                            $row1 = mysqli_num_rows($to_del);
                            $i = 0;
                            $j = 0;

                            if ($row > 0) {
                                do {
                                    $id = $to_del->fetch_assoc()['id'];

                                    $sql = "DELETE FROM data_claim WHERE id = $id";
                                    $del = $hyper->connect->query($sql);

                                    $i++;
                                } while ($i < $row);
                            }

                            if ($row1 > 0) {
                                do {
                                    $id = $to_del->fetch_assoc()['id'];

                                    $sql = "DELETE FROM data_claim WHERE id = $id";
                                    $del = $hyper->connect->query($sql);

                                    $j++;
                                } while ($j < $row1);
                            }
                            $errorMSG = 'กำลังดำเนินการ... ไม่สามารถส่งเคลมซ้ำได้';
                        }
                    }
                } else {
                    $errorMSG = "กรุณากรอกเหตุผลการเคลม";
                }
            } else {
                $errorMSG = "ไอดีของคุณหมดประกันแล้ว";
            }
        } else {    // admin confirmed or reject

            if ($_POST['type'] == 2) { // admin confirmed
                $data_game = "SELECT * FROM game_data WHERE selled=0 AND card_id={$card_id['card_id']} LIMIT 1";
                $row = $hyper->connect->query($data_game);
                $game = $row->fetch_array();

                if (mysqli_num_rows($row) == 1) {

                    $confirm = "UPDATE data_claim SET confirm = 1, isSend = 0 WHERE claim_id={$selled['selled_id']} AND confirm=0 AND isSend = 1";
                    $data_selled_update = "UPDATE data_selled SET claim = 1, data_id = {$game['data_id']} WHERE selled_id = {$selled['selled_id']} AND claim=2";
                    $data_game_update = "UPDATE game_data SET selled = 1 WHERE data_id = {$game['data_id']}";

                    if ($hyper->connect->query($confirm) && $hyper->connect->query($data_selled_update) && $hyper->connect->query($data_game_update)) {
                        $select_admin = "SELECT * FROM accounts WHERE line_token != ''";
                        $admin_query = $hyper->connect->query($select_admin);
                        $admin_num = mysqli_num_rows($admin_query);

                        // msg
                        $message = "%0A‼️ ถึงแอดมิน ‼️ %0A";
                        $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "%0A";
                        $message .= "สถานะ : อนุมัติ %0A";
                        $message .= "โดย : " . $data_user['username'] . "%0A";
                        $message .= "ไปที่เว็บ : " . $hyper->url . "/report" . "&" . "id={$selled['selled_id']}";

                        array_push($line_data, [
                            'massage' => $message,
                        ]);

                        for ($i = 0; $i < $admin_num; $i++) {
                            $admin = $admin_query->fetch_array();
                            if ($admin['line_token'] != NULL) {
                                array_push($token, $admin['line_token']);
                                // $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                            }
                        }
                        array_push($line_data, [
                            'token' => join(",", $token)
                        ]);
                        $hyper->notify->sendNotify((int)$uid, (int)$selled['ac_id'], 'confirm', (int)$selled['selled_id']);
                        $delete_admin_notify = "DELETE FROM notify_log WHERE data_id={$selled['selled_id']} AND isadmin=1";
                        $hyper->connect->query($delete_admin_notify);
                        $successMSG = "อนุมัติ สำเร็จ!";
                    } else {
                        $errorMSG = "เคลมไม่สำเร็จ... กรุณาติดต่อผู้ดูแลระบบ";
                    }
                } else {
                    $errorMSG = "ไม่เหลือไอดีในระบบ... กรุณาเพิ่มข้อมูล";
                }
            } else { // admin reject
                if (isset($_POST['response'])) {
                    $response = $_POST['response'];
                    if (!empty($response)) {

                        $reject = "UPDATE data_claim SET confirm = 2, isSend = 0 WHERE claim_id={$selled['selled_id']} AND confirm=0 AND isSend = 1";
                        $reject_selled = "UPDATE data_selled SET claim = 3, response='$response' WHERE selled_id = {$selled['selled_id']} AND claim=2";
                        if ($hyper->connect->query($reject) && $hyper->connect->query($reject_selled)) {
                            $select_admin = "SELECT * FROM accounts WHERE line_token != ''";
                            $admin_query = $hyper->connect->query($select_admin);
                            $admin_num = mysqli_num_rows($admin_query);

                            // msg
                            $message = "%0A‼️ ถึงแอดมิน ‼️ %0A";
                            $message .= "ออเดอร์ที่ : " . $selled['selled_id'] . "%0A";
                            $message .= "สถานะ : ปฏิเสธ %0A";
                            $message .= "หมายเหตุ : " . $response . "%0A";
                            $message .= "โดย : " . $data_user['username'] . "%0A";
                            $message .= "ไปที่เว็บ : " . $hyper->url . "/report" . "&" . "id={$selled['selled_id']}";

                            array_push($line_data, [
                                'massage' => $message,
                            ]);

                            for ($i = 0; $i < $admin_num; $i++) {
                                $admin = $admin_query->fetch_array();
                                if ($admin['line_token'] != NULL) {
                                    array_push($token, $admin['line_token']);
                                    // $hyper->line->send($admin['line_token'], $message); // Send msg to admin Line
                                }
                            }
                            array_push($line_data, [
                                'token' => join(",", $token)
                            ]);
                            $hyper->notify->sendNotify((int)$uid, (int)$selled['ac_id'], 'reject', (int)$selled['selled_id']);
                            $delete_admin_notify = "DELETE FROM notify_log WHERE data_id={$selled['selled_id']} AND isadmin=1";
                            $hyper->connect->query($delete_admin_notify);
                            $successMSG = "ปฏิเสธ สำเร็จ!";
                        } else {
                            $errorMSG = "เกิดข้อผิดพลาด... กรุณาติดต่อผู้ดูแลระบบ";
                        }
                    } else {
                        $errorMSG = "กรุณากรอกหมายเหตุ";
                    }
                } else {
                    $errorMSG = "กรุณากรอกหมายเหตุ";
                }
            }
        }
    } else {
        $errorMSG = "เกิดปัญหาในการส่งเคลม";
    }



    /* result */
    if (empty($errorMSG)) {
        echo json_encode(['code' => 200, 'msg' => $successMSG, 'line' => $line_data]);
    } else {
        echo json_encode(['code' => 500, 'msg' => $errorMSG]);
    }
} else {
    header("Location: 403.php");
}
