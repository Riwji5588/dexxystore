<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['email'])){
    /* password empty */
    if(empty($_POST['email'])  || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errorMSG = "กรุณากรอก อีเมล";
    }else{
        /* new_password empty */
        if(empty($_POST['new_password']) || strlen($_POST['new_password']) > 16 || strlen($_POST['new_password']) < 6){
            $errorMSG = "รหัสผ่าน-ใหม่ ต้องมากกว่า 6 และน้อยกว่า 16 ตัวอักษร";
        }else{
            /* cnew_password empty */
            if(empty($_POST['cnew_password'])){
                $errorMSG = "กรุณา ยืนยันรหัสผ่าน-ใหม่";
            }elseif($_POST['cnew_password'] != $_POST['new_password']){
                $errorMSG = "กรุณากรอก รหัสผ่าน-ใหม่ ให้ตรงกัน";
            }else{

                    $email = $_POST['email'];
                    $newpassword = $_POST['new_password'];
                    $resetpassword = $hyper->user->Resetpassword($email,$newpassword);
                    if($resetpassword === true){
                    }else{
                        $errorMSG = $resetpassword;
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