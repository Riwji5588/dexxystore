<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['bannerpass'])){
   
    /* image empty */
    if($_FILES["imgbannernew"]["error"] != 0){
        $errorMSG = "กรุณาเพิ่มรูปภาพ";
    }else{
            
    $namea = bin2hex(random_bytes(16)).'_slide.jpg';
    function Upload($file,$path="../assets/img/slide/"){
        global $namea;
        $newfilename= $namea.str_replace("", "", basename(''));
        if(@copy($file['tmp_name'],$path.$newfilename)){
            @chmod($path.$file,0777);
            return $newfilename;
        }else{
            return false;
        }
    }
    
    $fileimg = Upload($_FILES["imgbannernew"]);

    if($fileimg == false){
        $errorMSG = "เพิ่มรูปภาพไม่สำเร็จ";
    }else{
        $add_new_slide = "INSERT INTO image_slide (image_name) VALUES ('$fileimg')";
        $result = $hyper->connect->query($add_new_slide);
        if(!$result){
            $errorMSG = "เพิ่มรูปภาพไม่สำเร็จ";
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