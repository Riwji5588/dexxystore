<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $id = $_POST['id'];

    $sql_select_selled = "SELECT * FROM data_selled WHERE selled_id = $id";
    $query_selled = $hyper->connect->query($sql_select_selled);
    $selled = mysqli_fetch_array($query_selled);

    $data_id = $selled['data_id'];

    $del_selled_sql = "DELETE FROM data_selled WHERE selled_id = $id";
    $del_selled_query = $hyper->connect->query($del_selled_sql);
    if(!$del_selled_query){
        $errorMSG = "ลบไม่สำเร็จ";
    }else{
        $del_data_sql = "DELETE FROM game_data WHERE data_id = $data_id";
        $del_data_query = $hyper->connect->query($del_data_sql);
        if(!$del_data_query){
            $errorMSG = "ลบไม่สำเร็จ";
        }
    }
    
    /* result */
    if(empty($errorMSG)){
        echo json_encode(['code'=>200,]);
    }else{
        echo json_encode(['code'=>500, 'msg'=>$errorMSG]);
    }

}else{
  header("Location: 403.php");
}

?>