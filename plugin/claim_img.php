<?php
include('./hyper_api.php');
$errorMSG = "";
$successMSG = '';
$data = [];

$url = "../assets/img/claim_img/";
$url_access = $hyper->url . "/assets/img/claim_img/";

date_default_timezone_set("Asia/Bangkok");

if ($_POST) {
    if ($_POST['action'] == 'getimg') {
        $claim_id = $_POST['claim_id'];
        $type = $_POST['type'];
        $sql = "SELECT id, image_name FROM claim_image WHERE claim_id = '$claim_id' AND type = '$type'";
        $query = $hyper->connect->query($sql);
        $row = mysqli_num_rows($query);
        if ($row > 0) {
            $i = 0;
            do {
                $img = $query->fetch_assoc();
                $image_name = $img['image_name'];
                $id = $img['id'];
                array_push($data, array(
                    'id' => (int)$id,
                    'image_name' => $url_access . $image_name
                ));

                $i++;
            } while ($i < $row);
        }
        $successMSG = 'GET_IMG_SUCCESS';
    } else if ($_POST['action'] == 'addimg') {
        $claim_id = $_POST['claim_id'];
        $type = 0;
        $file = $_FILES['files'];
        $exp_date = date('Y-m-d H:i:s', strtotime('+7 day'));
        foreach ($file['tmp_name'] as $key => $val) {
            $exlodename = explode('.', $file['name'][$key]);
            if (count($exlodename) == 2) {
                $file_name = bin2hex(random_bytes(16));
                $typeoffile = $exlodename[1];
                $image_name = $file_name . '.' . $typeoffile;
                $file_tmp = $file['tmp_name'][$key];
                move_uploaded_file($file_tmp, $url . $image_name);

                $sql_insert_img = "INSERT INTO claim_image (claim_id, type, image_name, exp_date) VALUES ('$claim_id', '$type', '$image_name', '$exp_date')";
                $query_insert_img = $hyper->connect->query($sql_insert_img);
                if (!$query_insert_img) {
                    $errorMSG = 'ไม่สารมารถเพิ่มรูปภาพได้';
                    break;
                }
                $sql = "SELECT id FROM claim_image WHERE claim_id = '$claim_id' AND image_name = '$image_name'";
                $id = $hyper->connect->query($sql)->fetch_assoc()['id'];

                array_push($data, array('id' => (int)$id, 'image_name' => $image_name, 'url' => $url_access . $image_name));
            } else {
                $errorMSG = 'กรุณาอย่าใช้ " . " ในการตั้งชื่อไฟล์';
                break;
            }
        }
        if (empty($errorMSG)) {
            $successMSG = 'ADD_IMG_SUCCESS';
        }
    } else if ($_POST['action'] == 'autodel') {
        $sql = "SELECT id FROM claim_image WHERE exp_date < NOW()";
        $query = $hyper->connect->query($sql);
        $row = mysqli_num_rows($query);
        $i = 0;
        if ($row > 0) {
            do {
                $id = $query->fetch_assoc()['id'];
                $sql_delete_img = "DELETE FROM claim_image WHERE id = '$id'";
                $query_delete_img = $hyper->connect->query($sql_delete_img);
                if (!$query_delete_img) {
                    $errorMSG = 'ไม่สารมารถลบรูปภาพได้ (อัตโนมัติ)';
                    break;
                }
                $i++;
            } while ($i < $row);
            if (empty($errorMSG)) {
                $successMSG = 'AUTO_DEL_IMG_SUCCESS';
            }
        }
    } else if ($_POST['action'] == 'delimg') {
        $id = $_POST['id'];
        $image_name = $_POST['image_name'];
        $sql_del_img = "DELETE FROM claim_image WHERE id = '$id'";
        $query_del_img = $hyper->connect->query($sql_del_img);
        if (!$query_del_img) {
            $errorMSG = 'ไม่สารมารถลบรูปภาพได้';
        } {

            unlink($url . $image_name);
            $successMSG = 'DELETE_IMG_SUCCESS';
        }
    } else if ($_POST['action'] == 'test') {
    } else {
        $errorMSG = "ACTION ERROR";
    }
} else {
    $errorMSG = "METHOD_NOT_ALLOWED";
}

if (empty($errorMSG)) {
    echo json_encode(['code' => 200, 'message' => $successMSG, 'data' => $data]);
} else {
    echo json_encode(['code' => 500, 'message' => $errorMSG]);
}
