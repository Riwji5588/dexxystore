<?php
include('./hyper_api.php');
date_default_timezone_set("Asia/Bangkok");
$errormsg = "";

if (isset($_POST)) {

    if (!isset($_POST['action']) || $_POST['action'] == "") {
        $errormsg = "Invalid Request";
    } else {
        define('action', $_POST['action']);

        if (isset($_POST['id']) && isset($_POST['table'])) {
            $id = $_POST['id'];
            $id = explode(",", $id);
            $table = $_POST['table'];
            if (action == 'restore') {
                if ($table == 'game_data') {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $update = "UPDATE game_data SET isDelete = 0 WHERE id = $Id";
                        $del_data_query = $hyper->connect->query($del_data_sql);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                } else if ($table == 'data_selled') {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $update = "UPDATE data_selled SET isDelete = 0 WHERE selled_id = $Id";
                        $del_data_query = $hyper->connect->query($update);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                } else {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $update = "UPDATE {$table} SET isDelete = 0 WHERE id = $Id";
                        $del_data_query = $hyper->connect->query($update);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                }
            } else if (action == 'delete') {
                if ($table == 'game_data') {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $delete = "DELETE FROM game_data WHERE id = $Id";
                        $del_data_query = $hyper->connect->query($delete);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                } else if ($table == 'data_selled') {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $delete = "DELETE FROM data_selled WHERE selled_id = $Id";
                        $del_data_query = $hyper->connect->query($delete);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                } else {
                    for ($i = 0; $i < count($id); $i++) {
                        $Id = intval($id[$i]);
                        $delete = "DELETE FROM {$table} WHERE id = $Id";
                        $del_data_query = $hyper->connect->query($delete);
                        if (!$del_data_query) {
                            $errorMSG = "ลบไม่สำเร็จ";
                        }
                    }
                }
            } else {
                $errormsg = "Invalid Request";
            }
        } else {
            $errormsg = "Do not have id or table";
        }
    }

    if (!$errormsg) {
        echo json_encode([
            'code' => 200
        ]);
    } else {
        echo json_encode([
            'code' => 500,
            'message' => $errormsg,
        ]);
    }
}
