<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['cid'])){
   
    if(empty($_POST['title'])){
        $errorMSG = "กรุณากรอก ชื่อสินค้า";
    }else{

        if(empty($_POST['price']) || !filter_var($_POST['price'], FILTER_VALIDATE_INT) || $_POST['price'] <= 0){
            $errorMSG = "กรุณากรอก ราคาสินค้า";
        }else{

            if(empty($_POST['detail'])){
                $_POST['detail'] = "";
            }

            $cid = $_POST['cid'];
            $cardtitle = $_POST['title'];
            $price = $_POST['price'];
            $detail = $_POST['detail'];

            /* image empty */
            if(empty($_FILES["img"]) || $_FILES["img"]["error"] != 0){

                $update_game_sql = "UPDATE game_card SET card_title = '".$cardtitle."', card_price = '".$price."', card_detail = '".$detail."' WHERE card_id = $cid";
                $query_game_update = $hyper->connect->query($update_game_sql);
                if(!$query_game_update){
                    $errorMSG = "อัพเดทการ์ดแสดงสินค้าไม่สำเร็จ";
                }

            }else{
                
                $namea = bin2hex(random_bytes(16)).'_item.jpg';
                function Upload($file,$path="../assets/img/item/"){
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

                    $card_id = $cid;
                    $add_new_card_image = "INSERT INTO card_image (card_id, image_name) VALUES ('$card_id','$fileimg')";
                    $result = $hyper->connect->query($add_new_card_image);
                    if(!$result){
                        $errorMSG = "อัพเดทการ์ดแสดงสินค้าไม่สำเร็จ";
                    }

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