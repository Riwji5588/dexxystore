<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['ref'])){

    if(!empty($_POST['ref'])){

        include('hyperclassno.php');
        $useapi = new Hyper();

        $value = $_POST['ref']; //ค่าลิ้งซองของขวัญ

        $mygiftlink = str_replace(' ','',$value);
        $result = $useapi->hyperRequest($mygiftlink);

        if($result['code'] == '200'){ //ทำรายการสำเร็จ
            
            $link =  $result['link']; //ลิ้งที่ใช้ในการเติมเงิน
            $money =  $result['amount']; //จำนวนเงินที่เติม

            $sid = $_COOKIE['USER_SID'];
            
            $user = "SELECT * FROM accounts WHERE sid = '".$sid."' ";
            $user_query = $hyper->connect->query($user);
            if(mysqli_num_rows($user_query) == 1){

                $data_user = $hyper->connect->query($user)->fetch_array();
                $mysid = $data_user['sid'];
                $mypoint = $data_user['points'] + $money;
                $username = $data_user['username'];

                $update_user_sql = "UPDATE accounts SET points = $mypoint WHERE sid = '".$sid."' ";
                $update_user_query = $hyper->connect->query($update_user_sql);
                if($update_user_query){

                    date_default_timezone_set("Asia/Bangkok");
                    $date = date("Y-m-d H:i:s");

                    $sql_log = "INSERT INTO history_pay (username, link, amount, date) VALUES ('$username', '$link', '$money', '$date')";
                    $log_query = $hyper->connect->query($sql_log);

                }else{ $errorMSG = 'ระบบเติมเงินมีปัญหา ติดต่อแอดมิน'; }

            }else{ $errorMSG = 'ไม่สามารถทำรายการได้'; }
        }

    }else{
        $errorMSG = 'กรุณากรอก ลิ้งซองของขวัญ';
    }

/* result */
if(empty($errorMSG)){
    echo json_encode($result);
}else{
    echo json_encode(['code'=>500, 'msg'=>$errorMSG]);
}
}else{
    header("Location: 403.php");
}
?>