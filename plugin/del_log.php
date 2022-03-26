<?php

include("hyper_api.php");
$errorMSG = "";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $id = explode(",", $id);
    $table = $_POST['table'];

    if ($table == 'game_data') {
        for ($i = 0; $i < count($id); $i++) {
            $Id = intval($id[$i]);
            $del_data_sql = "DELETE FROM {$table} WHERE data_id = $Id";
            $del_data_query = $hyper->connect->query($del_data_sql);
            if (!$del_data_query) {
                $errorMSG = "ลบไม่สำเร็จ";
            }
        }
    } else if ($table == 'data_selled') {
        for ($i = 0; $i < count($id); $i++) {
            $Id = intval($id[$i]);
            $del_data_sql = "DELETE FROM {$table} WHERE selled_id = $Id";
            $del_data_query = $hyper->connect->query($del_data_sql);
            if (!$del_data_query) {
                $errorMSG = "ลบไม่สำเร็จ";
            }
        }
    } else {
        for ($i = 0; $i < count($id); $i++) {
            $Id = intval($id[$i]);
            $del_data_sql = "DELETE FROM {$table} WHERE id = $Id";
            $del_data_query = $hyper->connect->query($del_data_sql);
            if (!$del_data_query) {
                $errorMSG = "ลบไม่สำเร็จ";
            }
        }
    }

    /* result */
    if (empty($errorMSG)) {
        echo json_encode(['code' => 200, 'msg' => $del_data_sql]);
    } else {
        echo json_encode(['code' => 500, 'msg' => $errorMSG]);
    }
} else {
    header("Location: 403.php");
}
