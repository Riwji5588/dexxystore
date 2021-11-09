<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $id = $_POST['id'];

    $del_data_sql = "DELETE FROM game_data WHERE data_id = $id";
    $del_data_query = $hyper->connect->query($del_data_sql);
    if(!$del_data_query){
        $errorMSG = "ลบไม่สำเร็จ";
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