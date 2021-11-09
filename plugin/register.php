<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['username'])){
    /* username empty */
    if(empty($_POST['username']) || strlen($_POST['username']) > 16 || strlen($_POST['username']) < 6){
        $errorMSG = "ชื่อผู้ใช้งานต้องมากกว่า 6 และน้อยกว่า 16 ตัวอักษร";
    }else{
        /* password empty */
        if(empty($_POST['password']) || strlen($_POST['password']) > 16 || strlen($_POST['password']) < 6){
            $errorMSG = "รหัสผ่านต้องมากกว่า 6 และน้อยกว่า 16 ตัวอักษร";
        }else{
            /* cpassword empty */
            if(empty($_POST['cpassword'])){
                $errorMSG = "กรุณา ยืนยันรหัสผ่าน";
            }elseif($_POST['cpassword'] != $_POST['password']){
                $errorMSG = "กรุณากรอก รหัสผ่าน ให้ตรงกัน";
            }else{

                if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $errorMSG = "กรุณากรอก อีเมล";
                }else{
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $register = $hyper->user->Register($username,$password,$email);
                    if($register === true){

                    }else{
                        $errorMSG = $register;
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