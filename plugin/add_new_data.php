<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['gameidnew'])){
   
    if(empty($_POST['usernamenew'])){
        $errorMSG = "กรุณากรอก ชื่อผู้ใช้งาน";
    }else{

        if(empty($_POST['passwordnew'])){
            $errorMSG = "กรุณากรอก รหัสผ่าน";
        }else{
    
            if(empty($_POST['cardnew']) || $_POST['cardnew'] == 0){
                $errorMSG = "กรุณาเลือก ที่อยู่ข้อมูล";
            }else{
        
                if(empty($_POST['detailnew'])){
                    $_POST['detailnew'] = "";
                }

                $gid = $_POST['gameidnew'];
                $user = $_POST['usernamenew'];
                $pass = base64_encode($_POST['passwordnew']);
                $cid = $_POST['cardnew'];
                $detail = $_POST['detailnew'];

                $add_new_data = "INSERT INTO game_data (game_id, card_id, username, password, detail) VALUES ('$gid','$cid','$user','$pass','$detail')";
                $result = $hyper->connect->query($add_new_data);
                if(!$result){
                    $errorMSG = "เพิ่มข้อมูลไม่สำเร็จ";
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