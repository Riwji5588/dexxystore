<?php

date_default_timezone_set("Asia/Bangkok");

class User{

    public function Register($username,$password,$email){
        global $hyper;

        $check = "SELECT * FROM accounts WHERE username = '$username' OR email = '$email'";
        $check_query = $hyper->connect->query($check);
        if(mysqli_num_rows($check_query) == 0){

            /* SID Generate */
            $sid = base64_encode(bin2hex(random_bytes(6)).date("his").$username);

            /* Password Encript */
            $t_pass = $password;
            $salt = bin2hex(random_bytes(8));
            $method = 'AES-256-CBC';
            if (preg_match("/([0-9]+)/i", $method, $matches)) {
                $AESKeyLength = $matches[1] >> 3;
            }
            $AESIVLength = openssl_cipher_iv_length( $method );
            $pbkdf2 = hash_pbkdf2('SHA512', $t_pass , $salt, 24000, FALSE);
            $key = substr($pbkdf2, 0, $AESKeyLength);
            $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
            $consumer_key_enc = openssl_encrypt( $t_pass , $method , $key , 0 , $iv );
            $h_pass = md5($consumer_key_enc);

            /* INSERT To Database */
            $insert_sql = "INSERT INTO accounts (username, password, salt, email, sid) VALUES ('$username', '$h_pass', '$salt', '$email', '$sid')";
            $insert_query = $hyper->connect->query($insert_sql);
            if($insert_query){
                return true;
            }else{
                return 'สมัครสมาชิกไม่สำเร็จ';
            }

        }else{
            return 'มีบัญชีผู้ใช้หรืออีเมลนี้แล้ว';
        }
    }


    public function Login($username,$password){
        global $hyper;

        $check = "SELECT * FROM accounts WHERE username = '$username'";
        $check_query = $hyper->connect->query($check);
        if(mysqli_num_rows($check_query) == 1){
            $data_user = $hyper->connect->query($check)->fetch_array();

            /* Password Encript */
            $t_pass = $password;
            $salt = $data_user['salt'];
            $method = 'AES-256-CBC';
            if (preg_match("/([0-9]+)/i", $method, $matches)) {
                $AESKeyLength = $matches[1] >> 3;
            }
            $AESIVLength = openssl_cipher_iv_length( $method );
            $pbkdf2 = hash_pbkdf2('SHA512', $t_pass , $salt, 24000, FALSE);
            $key = substr($pbkdf2, 0, $AESKeyLength);
            $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
            $consumer_key_enc = openssl_encrypt( $t_pass , $method , $key , 0 , $iv );
            $h_pass = md5($consumer_key_enc);

            /* Check Password */
            if($h_pass == $data_user['password']){
                $_SESSION["USER_SID"] = $data_user['sid'];
                return true;
            }else{
                return 'รหัสผ่านไม่ถูกต้อง';
            }

        }else{
            return 'ไม่มีบัญชีผู้ใช้นี้ในระบบ';
        }

    }


    public function Resetpassword($email,$newpassword){
        global $hyper;

        $check = "SELECT * FROM accounts WHERE email = '$email'";
        $check_query = $hyper->connect->query($check);
        if(mysqli_num_rows($check_query) == 1){
            $data_user = $hyper->connect->query($check)->fetch_array();

            if($email == $data_user['email']){

                /* Generate New Password Encript */
                $id = $data_user['ac_id'];
                $nt_pass = $newpassword;
                $newsalt = bin2hex(random_bytes(8));
                $method = 'AES-256-CBC';
                if (preg_match("/([0-9]+)/i", $method, $matches)) {
                    $AESKeyLength = $matches[1] >> 3;
                }
                $AESIVLength = openssl_cipher_iv_length( $method );
                $pbkdf2 = hash_pbkdf2('SHA512', $nt_pass , $newsalt, 24000, FALSE);
                $key = substr($pbkdf2, 0, $AESKeyLength);
                $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
                $consumer_key_enc = openssl_encrypt( $nt_pass , $method , $key , 0 , $iv );
                $newh_pass = md5($consumer_key_enc);
                
                /* INSERT To Database */
                $update_sql = "UPDATE accounts SET password = '".$newh_pass."', salt = '".$newsalt."' WHERE ac_id = $id";
                $update_query = $hyper->connect->query($update_sql);
                if($update_query){
                    return true;
                }

            }else{
                return 'อีเมลไม่ถูกต้อง';
            }
        }else{ return 'อีเมลไม่ถูกต้อง'; }
    }
    
}

?>