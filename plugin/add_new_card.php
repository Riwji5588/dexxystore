<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['gameid'])){
   
    if(empty($_POST['title'])){
        $errorMSG = "กรุณากรอก ชื่อสินค้า";
    }else{

        if(empty($_POST['price']) || !filter_var($_POST['price'], FILTER_VALIDATE_INT) || $_POST['price'] <= 0){
            $errorMSG = "กรุณากรอก ราคาสินค้า";
        }else{

            if(empty($_POST['detail'])){
                $_POST['detail'] = "";
            }

            /* image empty */
            if(empty($_FILES["imggamecardnew"]) || $_FILES["imggamecardnew"]["error"] != 0){
                $errorMSG = "กรุณาเพิ่มรูปสินค้า";
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
                
                $cardtitle = $_POST['title'];
                $price = $_POST['price'];
                $detail = $_POST['detail'];
                $gameid = $_POST['gameid'];
                $fileimg = Upload($_FILES["imggamecardnew"]);

                if($fileimg == false){
                    $errorMSG = "เพิ่มรูปภาพไม่สำเร็จ";
                }else{
                    $add_new_card = "INSERT INTO game_card (game_id, card_title, card_price, card_detail) VALUES ('$gameid','$cardtitle','$price','$detail')";
                    $result = $hyper->connect->query($add_new_card);
                    if(!$result){
                        $errorMSG = "เพิ่มสินค้าไม่สำเร็จ";
                    }else{

                        $card_id = mysqli_insert_id($hyper->connect);
                        $add_new_card_image = "INSERT INTO card_image (card_id, image_name) VALUES ('$card_id','$fileimg')";
                        $result = $hyper->connect->query($add_new_card_image);
                        if(!$result){
                            $errorMSG = "เพิ่มสินค้าไม่สำเร็จ";
                        }

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