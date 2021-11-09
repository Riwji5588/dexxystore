<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['user_id'])){
   
    if($_POST['point'] == null || $_POST['point'] < 0){
        $errorMSG = "กรุณากรอก Points";
    }else{

        if(empty($_POST['email'])){
            $errorMSG = "กรุณากรอก E-mail";
        }else{
        
            if(empty($_POST['role'])){
                $errorMSG = "กรุณาเลือก ระดับผู้ใช้งาน";
            }else{

                $uid = $_POST['user_id'];
                $point = $_POST['point'];
                $email = $_POST['email'];
                $role = $_POST['role'];
    
                $update_data_sql = "UPDATE accounts SET points = '".$point."', email = '".$email."', role = '".$role."' WHERE ac_id = $uid";
                $query_data_update = $hyper->connect->query($update_data_sql);
                if(!$query_data_update){
                    $errorMSG = "อัพเดทข้อมูลไม่สำเร็จ";
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