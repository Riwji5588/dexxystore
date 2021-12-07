<?php
include '../../plugin/hyper_api.php';

if (isset($_GET)) {

    $code = $_GET['code'];
    $ac_id = $_GET['state'];
    $clientId = '6nHwLpJf2Dl1dTgwwvBrpN';
    $clientSecret = 'NejXjgHDnLwqQ07FwsBb1KXx5Xv6lT3lar18tIyVgLP';

    // print_r($_REQUEST);

    $data = "grant_type=authorization_code&code={$code}&redirect_uri={$hyper->url}/api/sendnoti&client_id={$clientId}&client_secret={$clientSecret}";
    
    // // $url = "https://notify-api.line.me/api/notify";
    $url = "https://notify-bot.line.me/oauth/token";
    // // $url = "http://localhost/dexxystore/sandbox/api/sendnoti/test.php";
    $headers = array(
        "Content-Type: application/x-www-form-urlencoded",
    );

    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($ch);
        curl_close($ch);

        $content = json_decode($content, true);
        $sql = "UPDATE `accounts` SET `line_token` = '{$content['access_token']}' WHERE `ac_id` = {$ac_id}";
        $updatedata = $hyper->connect->query($sql);
        print_r($content);

        header("Location: /profile");


    } catch (Exception $ex) {

        echo $ex;
    }
}
