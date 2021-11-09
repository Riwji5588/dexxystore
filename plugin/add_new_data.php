<?php

include("hyper_api.php");
$errorMSG = "";

if (isset($_POST['gameidnew'])) {

    if (empty($_POST['stockId'])) {
        $errorMSG = "กรุณากรอก ชื่อผู้ใช้งาน";
    } else {
        if (empty($_POST['cardnew']) || $_POST['cardnew'] == 0) {
            $errorMSG = "กรุณาเลือก ที่อยู่ข้อมูล";
        } else {

            if (empty($_POST['detailnew'])) {
                $_POST['detailnew'] = "";
            }

            $gid = $_POST['gameidnew'];
            $allId = $_POST['stockId'];
            $cid = $_POST['cardnew'];
            $detail = $_POST['detailnew'];
            
            $arr = explode("\n", $allId);
            $arr_ = array();
            $obj = array();
            foreach ($arr as $val) {
                $user = substr($val, 0, strpos($val, ':'));
                $passbetweendisplay = substr($val, strpos($val, ':') + 1);
                $pass = base64_encode(substr($passbetweendisplay, 0, strpos($passbetweendisplay, ':')));
                $display = substr($passbetweendisplay, strpos($passbetweendisplay, ':') + 1);
                $add_new_data = "INSERT INTO game_data (game_id, card_id, username, password, display, detail) VALUES ('$gid','$cid','$user','$pass','$display','$detail')";
                $result = $hyper->connect->query($add_new_data);
            }
            if (!$result) {
                $errorMSG = "เพิ่มข้อมูลไม่สำเร็จ";
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
