<?php
include("hyper_api.php");
$data = [];
$errormsg = "";

if ($_POST) {
    if ($_POST['action'] == 'getdataowner') {
        $exp = $_POST['exp'];
        if ($exp == 1) {
            $sql_select_selled = "SELECT * FROM data_selled WHERE exp_date < CURDATE()";
        } else {
            $sql_select_selled = "SELECT * FROM data_selled WHERE exp_date > CURDATE()";
        }
        $query_selled = $hyper->connect->query($sql_select_selled);
        $total_selled_row = mysqli_num_rows($query_selled);
        $i = 0;

        if ($total_selled_row > 0) {
            do {

                $selled = mysqli_fetch_assoc($query_selled);
                $selled_data_id = $selled['data_id'];
                $selled_account_id = $selled['ac_id'];
                $selled_id = $selled['selled_id'];

                $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$selled_data_id'";
                $query_selled_data = $hyper->connect->query($sql_select_selled_data);
                $selled_data = mysqli_fetch_assoc($query_selled_data);

                $selled_card_id = $selled_data['card_id'];

                $sql_select_type_card = "SELECT * FROM game_card WHERE card_id = '$selled_card_id'";
                $query_type_card = $hyper->connect->query($sql_select_type_card);
                $cardtype = mysqli_fetch_assoc($query_type_card);

                $sql_select_selled_account = "SELECT username FROM accounts WHERE ac_id = '$selled_account_id'";
                $query_selled_account = $hyper->connect->query($sql_select_selled_account);
                $selled_account = mysqli_fetch_assoc($query_selled_account);

                $expire = strtotime($selled['exp_date']) - strtotime('today midnight');

                $sql_select_claim_count = "SELECT COUNT(*) AS claim_count FROM data_claim WHERE claim_id = '$selled_id'";
                $query_claim_count = $hyper->connect->query($sql_select_claim_count);
                $claim_count = (int)mysqli_fetch_assoc($query_claim_count)['claim_count'];

                $sql_select_claim_count = "SELECT COUNT(*) AS claim_count FROM data_claim_first WHERE claim_id = '$selled_id'";
                $query_claim_count = $hyper->connect->query($sql_select_claim_count);
                $claim_first_count = (int)mysqli_fetch_assoc($query_claim_count)['claim_count'];



                array_push($data, [
                    // selled
                    'selled_id' => $selled['selled_id'],
                    'selled_date' => $hyper->datethai->DateThai1($selled['selled_date']),
                    // selled_data
                    'selled_data_username' => $selled_data['username'],
                    'selled_data_id' => $selled_data['data_id'],
                    // 'selled_data_password' => $selled_data['password'],
                    // 'selled_data_display' => $selled_data['display'],
                    // 'selled_data_detail' => $selled_data['detail'],
                    // selled_account
                    'account_username' => $selled_account['username'],
                    // cardtype
                    'card_id' => $cardtype['card_id'],
                    'card_title' => $cardtype['card_title'],
                    'card_price' => $cardtype['card_price'],
                    //
                    'claim_count' => $claim_count + $claim_first_count,
                    'expire' => $expire
                ]);

                $i++;
            } while ($i < $total_selled_row);
        } else {
            $errormsg = "Something wrong";
        }

        if (empty($errormsg)) {
            echo json_encode(['code' => 200, 'messaeg' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['code' => 500, 'message' => $errormsg]);
        }
    } else if ($_POST['action'] == 'getmodal') {
        $dataid = $_POST['dataid'];

        $sql_select_selled = 'SELECT selled_id, exp_date FROM data_selled WHERE data_id = "' . $dataid . '"';
        $query_selled = $hyper->connect->query($sql_select_selled);
        $selled = $query_selled->fetch_assoc();
        $selled_id = $selled['selled_id'];
        $exp = $selled['exp_date'];

        $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$dataid'";
        $query_selled_data = $hyper->connect->query($sql_select_selled_data);
        $selled_data = mysqli_fetch_assoc($query_selled_data);

        $selled_game_id = $selled_data['card_id'];

        $sql_select_type_card = "SELECT * FROM game_card WHERE card_id = '$selled_game_id'";
        $query_type_card = $hyper->connect->query($sql_select_type_card);
        $cardtype = mysqli_fetch_assoc($query_type_card);

        $cardid = $cardtype['card_id'];

        $select_img = "SELECT image_name FROM card_image WHERE card_id = '$cardid'";
        $query_img = $hyper->connect->query($select_img);
        $img = mysqli_fetch_assoc($query_img)['image_name'];

        array_push($data, [
            // selled
            'selled_id' => $selled_id,
            // selled_data
            'selled_data_username' => $selled_data['username'],
            'selled_data_id' => $selled_data['data_id'],
            'selled_data_password' => $selled_data['password'],
            'selled_data_display' => $selled_data['display'],
            // 'selled_data_detail' => $selled_data['detail'],
            // cardtype
            'card_id' => $cardtype['card_id'],
            'card_title' => $cardtype['card_title'],
            'card_price' => $cardtype['card_price'],
            'card_img' => $img,
            //
            'expire' => $hyper->datethai->dateThai1($exp)
        ]);

        echo json_encode(['code' => 200, 'messaeg' => 'success', 'data' => $data]);
    } else {
        $errormsg = 'Not found action';
    }
} else {
    echo json_encode(['code' => 405, 'message' => 'Method Not Allowed']);
}
