<?php
$server = isset($_SERVER['HTTP_HOST']) ? isset($_SERVER['HTTP_HOST']) : "";
$reqFunction = isset($_POST['fn']) ? $_POST['fn'] : "";
$raw  =  isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA  : " POST_DATA  is  null  ";

try {
    switch ($reqFunction) {
        case 'login';
            $result['status'] = true;
            $result['message'] = "login success" . " Message : " . $_POST['message'];
            break;
        default;
            $result['status'] = false;
            $result['message'] = " Unknow command " . $reqFunction . $raw;
            break;
    }
} catch (Exception $ex) {
    $result['status'] = false;
    $result['message'] = "exception: " . $ex;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
