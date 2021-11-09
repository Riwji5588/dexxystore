<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $id = $_POST['id'];

    $select_sql = "SELECT * FROM image_slide WHERE slide_id = $id";
    $query_sql = $hyper->connect->query($select_sql);
    $result_image = mysqli_fetch_array($query_sql);

    $old_image = $result_image['image_name'];

    $del_image_sql = "DELETE FROM image_slide WHERE slide_id = $id";
    $del_image_query = $hyper->connect->query($del_image_sql);
    if(!$del_image_query){
        $errorMSG = "ลบไม่สำเร็จ";
    }else{
        unlink('../assets/img/slide/'.$old_image.'');
        $errorMSG = "";
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