<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['data_id'])){
   
    if(empty($_POST['username'])){
        $errorMSG = "กรุณากรอก ชื่อผู้ใช้งาน";
    }else{

        if(empty($_POST['password'])){
            $errorMSG = "กรุณากรอก รหัสผ่าน";
        }else{
        
            if(empty($_POST['detail'])){
                $_POST['detail'] = "";
            }

            $did = $_POST['data_id'];
            $user = $_POST['username'];
            $pass = base64_encode($_POST['password']);
            $detail = $_POST['detail'];

            $update_data_sql = "UPDATE game_data SET username = '".$user."', password = '".$pass."', detail = '".$detail."' WHERE data_id = $did";
            $query_data_update = $hyper->connect->query($update_data_sql);
            if(!$query_data_update){
                $errorMSG = "อัพเดทข้อมูลไม่สำเร็จ";
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