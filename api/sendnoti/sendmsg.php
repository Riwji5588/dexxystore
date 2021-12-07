<?php
// include '../../plugin/hyper_api.php';
function sendMSG($message, $hyper)
{
    $sql = "SELECT * FROM accounts WHERE line_token!=NULL";
    $res = $hyper->connect->query($sql);
    $row = mysqli_num_rows($res);
    for ($i = 0; $i < $row; $i++) {
        $result = $res->fetch_array();
        if ($result['role'] == 779) :

            $url = "https://notify-api.line.me/api/notify";
            $data = "message=" . $message;
            $headers = array(
                "Content-Type: application/x-www-form-urlencoded",
                "Authorization: Bearer " . $result['line_token']
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
                echo json_encode($content);
                curl_close($ch);
            } catch (Exception $ex) {

                echo $ex;
            }

        endif;
    }
}
