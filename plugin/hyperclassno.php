<?php

/**
 * HYPER STUDIO API TrueWallet Gift Class
 *
 * @package   api-truewallet-gift-class
 * @author    Hyper Studio <https://www.facebook.com/pagehyperstudio>
 * @copyright Copyright (c) 2020-2021
 * @link      https://github.com/sharpaddroot/api-truewallet-gift-class
 * @version   1.0.1 (Beta)
 *
 **/

class Hyper
{

    public $license = '5dLe3xOOpA4dDvYKZuI_LOOyHzvy0DjTXU4qhKnPEdw';
    public $phone = '0633401979'; //นำ เบอร์โทรศัพท์ มาใส่ที่นี่
    // public $phone = '0915594555'; //นำ เบอร์โทรศัพท์ มาใส่ที่นี่
    public $startpoint = 'http://hypergift.tk/plugin/hyperclassnolimit.php';

    function hyperRequest($giftlink)
    {

        $linklist = explode('?v=', $giftlink);
        if (count($linklist) != 2) {
            $data['code'] = 500;
            $data['msg'] = "ลิ้งซองของขวัญไม่ถูกต้อง";
        } else {
            $link = $linklist[1];
            $check = $this->vocherwalletcheck($link);
            if ($check['code'] == 200) {
                $send = $this->vocherwalletsend($link);
                if ($send['code'] == 200) {
                    $data['code'] = $send['code'];
                    $data['amount'] = $check['amount'];
                    $data['link'] = $link;
                } else {
                    $data['code'] = $send['code'];
                    $data['msg'] = $send['msg'];
                }
            } else {
                $data['code'] = $check['code'];
                $data['msg'] = $check['message'];
            }
        }
        return $data;
    }

    function vocherwalletcheck($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gift.truemoney.com/campaign/vouchers/" . $url . "/verify?mobile=" . $this->phone,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        if ($response['status']['code'] == "VOUCHER_OUT_OF_STOCK") {
            $message['code'] = 500;
            $message['message'] = "ลิงค์ซองของขวัญถูกใช้งานแล้ว";
        } else if ($response['status']['code'] == "INVALID_LINK" || $response['status']['code'] == "VOUCHER_NOT_FOUND") {
            $message['code'] = 500;
            $message['message'] = "ลิงค์ซองของขวัญไม่ถูกต้อง";
        } else if ($response['status']['code'] == "CANNOT_GET_OWN_VOUCHER") {
            $message['code'] = 500;
            $message['message'] = "ไม่สามารถใช้ code ตัวเองได้";
        } else if ($response['status']['code'] == "SUCCESS") {
            if ($response['data']['voucher']['member'] != 1) {
                $message['code'] = 500;
                $message['message'] = "กรุณาเลือกให้รับซองได้เพียวคนเดียว";
            } else {
                $message['code'] = 200;
                $message["message"] = "สำเร็จ";
                $message["amount"] = str_replace(',', '', $response['data']['voucher']['amount_baht']);
            }
        } else {
            $message['code'] = 500;
            $message['message'] = "เกิดข้อผิดพลาดกรุณากรอกข้อมูลให้ถูกต้อง";
        }
        return $message;
    }

    function vocherwalletsend($url)
    {
        $curl = curl_init();
        $data = array("mobile" => $this->phone, "voucher_hash" => $url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gift.truemoney.com/campaign/vouchers/" . $url . "/redeem",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/json',
            ),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ));
        $redeemd = curl_exec($curl);
        $redeem = json_decode($redeemd, true);
        curl_close($curl);
        if ($redeem['status']['code'] == "SUCCESS" && $redeem['data']['redeemer_profile']['mobile_number'] == $this->phone) {
            $response['code'] = 200;
        } else {
            $response['code'] = 500;
            $response['message'] = "ลิงก์อ่างเปาไม่ถูกต้อง";
        }
        return $response;
    }
}
