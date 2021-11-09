<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['name'])){
   
    if(empty($_POST['name'])){
        $errorMSG = "กรุณากรอก ชื่อเว็บไซต์";
    }else{

        if(empty($_POST['facebook'])){
            $errorMSG = "กรุณากรอก Facebook";
        }else{

            if(empty($_POST['open'])){
                $errorMSG = "กรุณาเลือก สถานะเว็บไซต์";
            }else{

                if(empty($_POST['detail'])){
                    $_POST['detail'] = "";
                }

                $name = $_POST['name'];
                $facebook = $_POST['facebook'];
                $open = $_POST['open'];
                $detail = $_POST['detail'];
    
                /* image empty */
                if(empty($_FILES["img"]) || $_FILES["img"]["error"] != 0){
    
                    $update_web_sql = "UPDATE web_config SET name = '".$name."', facebook = '".$facebook."', opened = '".$open."', detail = '".$detail."' WHERE con_id = 1";
                    $query_web_update = $hyper->connect->query($update_web_sql);
                    if(!$query_web_update){
                        $errorMSG = "อัพเดทเว็บไซต์ไม่สำเร็จ";
                    }
    
                }else{

                    $sql = "SELECT * FROM web_config WHERE con_id = 1";
                    $query = $hyper->connect->query($sql);
                    $row = mysqli_fetch_array($query);

                    $old_image = $row['image'];
                    
                    $namea = bin2hex(random_bytes(16)).'_logo.png';
                    function Upload($file,$path="../assets/img/"){
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
    
                        $update_web_sql = "UPDATE web_config SET name = '".$name."', facebook = '".$facebook."', opened = '".$open."', detail = '".$detail."', image = '".$fileimg."' WHERE con_id = 1";
                        $query_web_update = $hyper->connect->query($update_web_sql);
                        if(!$query_web_update){
                            $errorMSG = "อัพเดทเว็บไซต์ไม่สำเร็จ";
                        }else{
                            unlink('../assets/img/'.$old_image.'');
                            $errorMSG = "";
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