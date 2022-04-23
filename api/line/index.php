<?php
// send line notify
if (isset($_GET['token']) && isset($_GET['message'])) {
    // $line_token = $_GET['token'];
    // $line_message = $_GET['message'];
    // $line_url = 'https://notify-api.line.me/api/notify';
    // $line_headers = array(
    //     'Content-Type: application/x-www-form-urlencoded',
    //     'Authorization: Bearer ' . $line_token
    // );
    // $line_data = array(
    //     'message' => $line_message
    // );
    // $line_options = array(
    //     'http' => array(
    //         'method' => 'POST',
    //         'header' => implode("\r\n", $line_headers),
    //         'content' => http_build_query($line_data)
    //     )
    // );
    // $line_context = stream_context_create($line_options);
    // $line_result = file_get_contents($line_url, false, $line_context);
    // $line_result = json_decode($line_result);
    // if ($line_result->status == 200) {
    //     echo 'Line notify success';
    // } else {
    //     echo 'Line notify failed';
    // }

    $token = $_GET['token']; // ใส่โทเคน
    $str = $_GET['message']; // ใส่ข้อความที่ต้องการ
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://notify-api.line.me/api/notify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "message=" . $str,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $token,
            "Cache-Control: no-cache",
            "Content-type: application/x-www-form-urlencoded"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $str . "<br>";
        print_r(json_decode($response, true));
    }
} else {
    echo 'Not found token or message';
}
