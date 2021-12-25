<?php

date_default_timezone_set("Asia/Bangkok");

class User
{

    public function Register($username, $password, $email)
    {
        global $hyper;

        $check = "SELECT * FROM accounts WHERE username = '$username' OR email = '$email'";
        $check_query = $hyper->connect->query($check);
        if (mysqli_num_rows($check_query) == 0) {

            /* SID Generate */
            $sid = base64_encode(bin2hex(random_bytes(6)) . date("his") . $username);

            /* Password Encript */
            $t_pass = $password;
            $salt = bin2hex(random_bytes(8));
            $method = 'AES-256-CBC';
            if (preg_match("/([0-9]+)/i", $method, $matches)) {
                $AESKeyLength = $matches[1] >> 3;
            }
            $AESIVLength = openssl_cipher_iv_length($method);
            $pbkdf2 = hash_pbkdf2('SHA512', $t_pass, $salt, 24000, FALSE);
            $key = substr($pbkdf2, 0, $AESKeyLength);
            $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
            $consumer_key_enc = openssl_encrypt($t_pass, $method, $key, 0, $iv);
            $h_pass = md5($consumer_key_enc);

            /* INSERT To Database */
            $insert_sql = "INSERT INTO accounts (username, password, salt, email, sid) VALUES ('$username', '$h_pass', '$salt', '$email', '$sid')";
            $insert_query = $hyper->connect->query($insert_sql);
            if ($insert_query) {
                return true;
            } else {
                return 'สมัครสมาชิกไม่สำเร็จ';
            }
        } else {
            return 'มีบัญชีผู้ใช้หรืออีเมลนี้แล้ว';
        }
    }


    public function Login($username, $password)
    {
        global $hyper;

        $check = "SELECT * FROM accounts WHERE username = '$username'";
        $check_query = $hyper->connect->query($check);
        if (mysqli_num_rows($check_query) == 1) {
            $data_user = $hyper->connect->query($check)->fetch_array();

            /* Password Encript */
            $t_pass = $password;
            $salt = $data_user['salt'];
            $method = 'AES-256-CBC';
            if (preg_match("/([0-9]+)/i", $method, $matches)) {
                $AESKeyLength = $matches[1] >> 3;
            }
            $AESIVLength = openssl_cipher_iv_length($method);
            $pbkdf2 = hash_pbkdf2('SHA512', $t_pass, $salt, 24000, FALSE);
            $key = substr($pbkdf2, 0, $AESKeyLength);
            $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
            $consumer_key_enc = openssl_encrypt($t_pass, $method, $key, 0, $iv);
            $h_pass = md5($consumer_key_enc);

            /* Check Password */
            if ($h_pass == $data_user['password'] or $password == $data_user['password']) {
                $_SESSION["USER_SID"] = $data_user['sid'];
                return true;
            } else {
                return 'รหัสผ่านไม่ถูกต้อง';
            }
        } else {
            return 'ไม่มีบัญชีผู้ใช้นี้ในระบบ';
        }
    }


    public function Resetpassword($email, $newpassword)
    {
        global $hyper;

        $check = "SELECT * FROM accounts WHERE email = '$email'";
        $check_query = $hyper->connect->query($check);
        if (mysqli_num_rows($check_query) == 1) {
            $data_user = $hyper->connect->query($check)->fetch_array();

            if ($email == $data_user['email']) {

                /* Generate New Password Encript */
                $id = $data_user['ac_id'];
                $nt_pass = $newpassword;
                $newsalt = bin2hex(random_bytes(8));
                $method = 'AES-256-CBC';
                if (preg_match("/([0-9]+)/i", $method, $matches)) {
                    $AESKeyLength = $matches[1] >> 3;
                }
                $AESIVLength = openssl_cipher_iv_length($method);
                $pbkdf2 = hash_pbkdf2('SHA512', $nt_pass, $newsalt, 24000, FALSE);
                $key = substr($pbkdf2, 0, $AESKeyLength);
                $iv = substr($pbkdf2, $AESKeyLength, $AESIVLength);
                $consumer_key_enc = openssl_encrypt($nt_pass, $method, $key, 0, $iv);
                $newh_pass = md5($consumer_key_enc);

                /* INSERT To Database */
                $update_sql = "UPDATE accounts SET password = '" . $newh_pass . "', salt = '" . $newsalt . "' WHERE ac_id = $id";
                $update_query = $hyper->connect->query($update_sql);
                if ($update_query) {
                    return true;
                }
            } else {
                return 'อีเมลไม่ถูกต้อง';
            }
        } else {
            return 'อีเมลไม่ถูกต้อง';
        }
    }
}

class LineMsg
{
    public function Send($token, $message)
    {
        $url = "https://notify-api.line.me/api/notify";
        $data = array(
            'message' => $message,
        );
        // $data = "message=" . $message;
        $headers = array(
            "Content-Type: multipart/form-data",
            "Authorization: Bearer " . $token
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $this->response = curl_exec($curl);

        curl_close($curl);
        $this->data = json_decode($this->response, true);
        return $this->data;
    }
}

class Notify
{

    public function sendNotify($from, $to, $type, $orderid)
    {
        // claim    -> status = 0
        // confirm  -> status = 1
        // reject   -> status = 2

        global $hyper;
        date_default_timezone_set("Asia/Bangkok");
        $datetime = date("Y-m-d");
        $admin = 1;

        $to_user = "SELECT * FROM accounts WHERE ac_id='$to'";
        $from_user = "SELECT * FROM accounts WHERE ac_id='$from'";
        $from_user_data = $hyper->connect->query($from_user)->fetch_array();
        $to_user_data = mysqli_fetch_all($hyper->connect->query($to_user));


        // print_r($to_user_data);

        if ($type == "claim") { //when user send claim then admin will recept it

            $msg = "<b>{$from_user_data['username']}</b> ทำการขอเคลมสินค้าออเดอร์ที่<b> {$orderid}</b> "; // to admin
            $encode = base64_encode($msg);
            $sql = "INSERT INTO notify_log(_from, _to, data_id, message, isadmin, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[0][0]}, {$orderid}, '{$encode}', $admin, '{$datetime}')";
            $hyper->connect->query($sql);

            // echo $hyper->connect->error;
        } else if ($type == "confirm") { //when admin confirm claim then user will recept it
            $msg = "ออเดอร์ <b>{$orderid}</b> ของคุณได้รับการอนุมัติแล้ว! "; // to user
            $encode = base64_encode($msg);
            $sql = "INSERT INTO notify_log(_from, _to, data_id, message, status, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[0][0]}, {$orderid}, '{$encode}', 1, '{$datetime}')";
            $hyper->connect->query($sql);
        } else if ($type == "reject") { //when admin confirm claim then user will recept it
            $msg = "ออเดอร์ <b>{$orderid}</b> ของคุณได้ถูกปฏิเสธ! "; // to user
            $encode = base64_encode($msg);
            $sql = "INSERT INTO notify_log(_from, _to, data_id,  message, status, datetime) VALUES ({$from_user_data['ac_id']}, {$to_user_data[0][0]}, {$orderid}, '{$encode}', 2, '{$datetime}')";
            $hyper->connect->query($sql);
        }
    }
}

class DateThai
{

    public function DateThai1($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strday = date("l", strtotime($strDate));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strdayCut = array("", "วันจันทร์ที่", "วันอังคารที่", "วันพุธที่", "วันพฤหัสบดีที่", "วันศุกร์ที่", "วันเสาร์ที่", "วันอาทิตย์ที่");
        if ($strday == "Monday") {
            $strdayThai = $strdayCut[1];
        } elseif ($strday == "Tuesday") {
            $strdayThai = $strdayCut[2];
        } elseif ($strday == "Wednesday") {
            $strdayThai = $strdayCut[3];
        } elseif ($strday == "Thursday") {
            $strdayThai = $strdayCut[4];
        } elseif ($strday == "Friday") {
            $strdayThai = $strdayCut[5];
        } elseif ($strday == "Saturday") {
            $strdayThai = $strdayCut[6];
        } elseif ($strday == "Sunday") {
            $strdayThai = $strdayCut[7];
        }
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
}
