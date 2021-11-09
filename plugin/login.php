<?php

session_start();
include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['username'])){
    /* username empty */
    if(empty($_POST['username'])){
        $errorMSG = "กรุณากรอก ชื่อผู้ใช้งาน";
    }else{
        /* password empty */
        if(empty($_POST['password'])){
            $errorMSG = "กรุณากรอก รหัสผ่าน!";
        }else{

            $username = $_POST['username'];
            $password = $_POST['password'];
            $login = $hyper->user->Login($username,$password);
            if($login === true){
                $errorMSG = "";
            }else{
                $errorMSG = $login;
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