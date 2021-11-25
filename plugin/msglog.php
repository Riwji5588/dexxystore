<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['gid'])){
   
    if(empty($_POST['name'])){
        $errorMSG = "กรุณากรอก ชื่อเกม";
    }else{

        $gamename = $_POST['name'];
        $id = $_POST['gid'];

        $select_sql = "SELECT * FROM game_type WHERE game_id = $id";
        $query_sql = $hyper->connect->query($select_sql);
        $result_game = mysqli_fetch_array($query_sql);
    
        $old_image = $result_game['game_image'];

        /* image empty */
        if(empty($_FILES["img"]) || $_FILES["img"]["error"] != 0){
            
            $update_game_sql = "UPDATE game_type SET game_name = '".$gamename."' WHERE game_id = $id";
            $query_game_update = $hyper->connect->query($update_game_sql);
            if(!$query_game_update){
                $errorMSG = "อัพเดทเกมไม่สำเร็จ";
            }

        }else{
            
            $namea = bin2hex(random_bytes(16)).'_game.jpg';
            function Upload($file,$path="../assets/img/game/"){
                global $namea;
                $newfilename= $namea.str_replace("", "", basename(''));
                if(@copy($file['tmp_name'],$path.$newfilename)){
                    @chmod($path.$file,0777);
                    return $newfilename;
                }else{
                    return false;
                }
            }
            
            $fileimg = Upload($_FILES["img"]);

            if($fileimg == false){
                $errorMSG = "อัพเดทรูปภาพไม่สำเร็จ";
            }else{
                $update_game_sql = "UPDATE game_type SET game_name = '".$gamename."', game_image = '".$fileimg."' WHERE game_id = $id";
                $query_game_update = $hyper->connect->query($update_game_sql);
                if(!$query_game_update){
                    $errorMSG = "อัพเดทเกมไม่สำเร็จ";
                }else{
                    unlink('../assets/img/game/'.$old_image.'');
                    $errorMSG = "";
                }
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