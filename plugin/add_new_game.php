<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['nametxtgamenew'])){
   
    if(empty($_POST['nametxtgamenew'])){
        $errorMSG = "กรุณากรอก ชื่อเกม";
    }else{

        /* image empty */
        if($_FILES["imggamelogonew"]["error"] != 0){
            $errorMSG = "กรุณาเพิ่มรูปเกม";
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
            
            $gamename = $_POST['nametxtgamenew'];
            $fileimg = Upload($_FILES["imggamelogonew"]);

            if($fileimg == false){
                $errorMSG = "เพิ่มรูปภาพไม่สำเร็จ";
            }else{
                $add_new_game = "INSERT INTO game_type (game_name, game_image) VALUES ('$gamename','$fileimg')";
                $result = $hyper->connect->query($add_new_game);
                if(!$result){
                    $errorMSG = "เพิ่มเกมไม่สำเร็จ";
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