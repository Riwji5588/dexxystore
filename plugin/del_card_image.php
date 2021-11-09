<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $id = $_POST['id'];

    $select_sql = "SELECT * FROM card_image WHERE image_id = $id";
    $query_sql = $hyper->connect->query($select_sql);
    $result_game = mysqli_fetch_array($query_sql);

    $old_image = $result_game['image_name'];
    $card_id = $result_game['card_id'];

    $select_sql_card = "SELECT * FROM card_image WHERE card_id = $card_id";
    $query_sql_card = $hyper->connect->query($select_sql_card);
    $total_image_row = mysqli_num_rows($query_sql_card);

    if($total_image_row < 2){
        $errorMSG = "ต้องเหลือรูปอย่างน้อย 1 รูป";
    }else{
        $del_game_sql = "DELETE FROM card_image WHERE image_id = $id";
        $del_game_query = $hyper->connect->query($del_game_sql);
        if(!$del_game_query){
            $errorMSG = "ลบไม่สำเร็จ";
        }else{
            unlink('../assets/img/item/'.$old_image.'');
            $errorMSG = "";
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