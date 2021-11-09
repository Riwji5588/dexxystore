<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $id = $_POST['id'];

    $del_card_sql = "DELETE FROM game_card WHERE card_id = $id";
    $del_card_query = $hyper->connect->query($del_card_sql);
    if(!$del_card_query){
        $errorMSG = "ลบไม่สำเร็จ";
    }else{

        $image_sql ="SELECT * FROM card_image WHERE card_id = $id";
        $data_query = $hyper->connect->query($image_sql);
        $data = mysqli_fetch_array($data_query);
        do{
            unlink('../assets/img/item/'.$data['image_name'].'');
        }while($data = mysqli_fetch_array($data_query));

        $del_data_sql = "DELETE FROM game_data WHERE card_id = $id AND selled = 0";
        $del_data_query = $hyper->connect->query($del_data_sql);
        if(!$del_data_query){
            $errorMSG = "ลบไม่สำเร็จ";
        }else{

            $del_image_sql = "DELETE FROM card_image WHERE card_id = $id";
            $del_image_query = $hyper->connect->query($del_image_sql);
            if(!$del_image_query){
                $errorMSG = "ลบไม่สำเร็จ";
            }

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