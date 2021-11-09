<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){
   
    $gid = $_POST['id'];

    $select_sql = "SELECT * FROM game_type WHERE game_id = $gid";
    $query_sql = $hyper->connect->query($select_sql);
    $result_game = mysqli_fetch_array($query_sql);

    $old_image = $result_game['game_image'];

    $del_game_sql = "DELETE FROM game_type WHERE game_id = $gid";
    $del_game_query = $hyper->connect->query($del_game_sql);
    if(!$del_game_query){
        $errorMSG = "ลบไม่สำเร็จ";
    }else{
        unlink('../assets/img/game/'.$old_image.'');

        $card_sql ="SELECT * FROM game_card WHERE game_id = $gid";
        $data_query = $hyper->connect->query($card_sql);
        $data = mysqli_fetch_array($data_query);
        $data_row = mysqli_num_rows($data_query);
        if($data_row > 0){
    
        do{
    
            $id = $data['card_id'];
    
            $del_card_sql = "DELETE FROM game_card WHERE card_id = $id";
            $del_card_query = $hyper->connect->query($del_card_sql);
            if(!$del_card_query){
                $errorMSG = "ลบไม่สำเร็จ";
            }else{
        
                $image_sql ="SELECT * FROM card_image WHERE card_id = $id";
                $data_img_query = $hyper->connect->query($image_sql);
                $data_img = mysqli_fetch_array($data_img_query);
                do{
                    unlink('../assets/img/item/'.$data_img['image_name'].'');
                }while($data_img = mysqli_fetch_array($data_img_query));
        
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
        }while($data = mysqli_fetch_array($data_query));
    
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