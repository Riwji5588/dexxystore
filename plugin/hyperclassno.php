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

    public $license = '6w_lphPFQ2iNZZrswJDE2U42XpYNqanoYtXYnYG1P9c';
    public $phone = '0633401979'; //นำ เบอร์โทรศัพท์ มาใส่ที่นี่
    // public $phone = '0915594555'; //นำ เบอร์โทรศัพท์ มาใส่ที่นี่
    public $startpoint = 'http://hyperapigift.tk/plugin/hyperclassnolimit.php';
    public $dexyapi = 'https://dexystorewallet.herokuapp.com/wallet/';

    function hyperRequest($giftlink)
    {
        $code = explode('?v=', $giftlink)[1];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->startpoint . "?lic={$this->license}&l={$giftlink}&p={$this->phone}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $this->response = curl_exec($curl);

        curl_close($curl);
        $this->data = json_decode($this->response, true);
        return $this->data;

        // $linklist = explode('?v=', $giftlink);
        // if (count($linklist) != 2) {
        //     $data['code'] = 500;
        //     $data['msg'] = "ลิ้งซองของขวัญไม่ถูกต้อง";
        // } else {
        //     $link = $linklist[1];
        //     // $check = $this->vocherwalletcheck($link);
        //     $send = $this->giftcode($link);

        //     if ($send['code'] == 200) {
        //         $data['code'] = 200;
        //         $data['link'] = $link;
        //         $data['amount'] = $send['amount'];
        //     } else {
        //         $data['code'] = 500;
        //         $data['msg'] = $send['message'];
        //     }
        //     // $data = $link;
        //     // $data = $this->check($send);
        //     // $data['code'] = 200;
        

        //     // if ($check['code'] == 200) {
        //     //     $send = $this->vocherwalletsend($link);
        //     //     if ($send['code'] == 200) {
        //     //         $data['code'] = $send['code'];
        //     //         $data['amount'] = $check['amount'];
        //     //         $data['link'] = $link;
        //     //     } else {
        //     //         $data['code'] = $send['code'];
        //     //         $data['msg'] = $send['msg'];
        //     //     }
        //     // } else {
        //     //     $data['code'] = $check['code'];
        //     //     $data['msg'] = $check['message'];
        //     // }
        // }
        // return $data;
    }

    // enable
    function giftcode($hash = null)
    {
        if (is_null($hash)) return false;
        $ch = curl_init();
        $headers  = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $postData = [
            'mobile' => $this->phone,
            'voucher_hash' => $hash
        ];
        curl_setopt($ch, CURLOPT_URL, "https://gift.truemoney.com/campaign/vouchers/$hash/redeem");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSLVERSION, 7);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0");
        $res     = curl_exec($ch);
        $response = json_decode($res, true);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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
            $message['message'] = "เกิดข้อผิดพลาด";
        }
        return $message;
    }

    // diabled
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

    // diabled
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
                'Accept: application/json'
            ),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSLVERSION => 7,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36"
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

