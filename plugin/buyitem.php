<?php

include("hyper_api.php");
$errorMSG = "";

if(isset($_POST['id'])){

    $sid = $_COOKIE['USER_SID'];
    $var = "SELECT * FROM accounts WHERE sid = '".$sid."' ";
    $user_query = $hyper->connect->query($var);
    $total_user = mysqli_num_rows($user_query);
    if($total_user == 1){

    $data_user = $hyper->connect->query($var)->fetch_array();

    $id = $_POST['id'];
    $uid = $data_user['ac_id'];

    $card_sql = "SELECT * FROM game_card WHERE card_id = $id";
    $card = $hyper->connect->query($card_sql)->fetch_array();

    $p = $data_user['points'] - $card['card_price'];

    if($p < 0){
        $errorMSG = "Points ไม่พอซื้อสินค้า";
    }else{

        $updateuser = "UPDATE accounts SET points = '".$p."' WHERE ac_id = $uid";
        $updateuser_query = $hyper->connect->query($updateuser);
        if($updateuser_query){

            date_default_timezone_set("Asia/Bangkok");
            $date = date("Y-m-d H:i:s");

            $data_sql = "SELECT * FROM game_data WHERE card_id = $id AND selled = 0 LIMIT 1";
            $data = $hyper->connect->query($data_sql)->fetch_array();

            $data_id = $data['data_id'];

            $updatedata = "UPDATE game_data SET selled = 1 WHERE data_id = $data_id";
            $updatedata_query = $hyper->connect->query($updatedata);
            if($updatedata_query){

                $selled_sql = "INSERT INTO data_selled (data_id, ac_id, selled_date) VALUE ('$data_id', '$uid', '$date')";
                $selled_query = $hyper->connect->query($selled_sql);
                if(!$selled_query){
                    $errorMSG = 'ซื้อสินค้า ไม่สำเร็จ!';
                }

            }else{
                $errorMSG = 'ซื้อสินค้า ไม่สำเร็จ!';
            }


        }else{
            $errorMSG = 'ซื้อสินค้า ไม่สำเร็จ!';
        }
    
    }

    }else{
        $errorMSG = "ซื้อสินค้า ไม่สำเร็จ!";
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