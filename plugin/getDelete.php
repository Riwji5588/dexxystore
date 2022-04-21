<?php
include('./hyper_api.php');
date_default_timezone_set("Asia/Bangkok");
$errormsg = "";
$data = [];

if (isset($_GET)) {

    if (isset($_GET['type'])) {
        $type = $_GET['type'];

        if ($type == 'claim') {
            $sql_claim = "SELECT * FROM data_claim WHERE isDelete = 1 ORDER BY id DESC";
            $claim_result = $hyper->connect->query($sql_claim);

            if (!$claim_result) {
                $errormsg = "Error: " . $hyper->connect->error;
            }

            if ($claim_result->num_rows > 0) {
                $i = 0;
                do {
                    $claim_data = $claim_result->fetch_assoc();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT * FROM accounts WHERE ac_id={$claim_data['ac_id']}";
                    $username = $hyper->connect->query($select_user)->fetch_assoc();

                    $data_result = $hyper->connect->query($select_data)->fetch_assoc();

                    $select_selled_date = "SELECT selled_date FROM data_selled WHERE selled_id={$claim_data['claim_id']}";
                    $selled_date = $hyper->connect->query($select_selled_date)->fetch_assoc()['selled_date'] ?? 'Null';

                    $select_count_claim = "SELECT COUNT(*) AS count_claim FROM data_claim WHERE claim_id={$claim_data['claim_id']} AND confirm=1";
                    $count_claim = (int)$hyper->connect->query($select_count_claim)->fetch_assoc()['count_claim'];

                    array_push($data, [
                        // claim_data
                        'id' => $claim_data['id'],
                        'claim_data_id' => $claim_data['claim_id'],
                        'claim_data_confirm' => $claim_data['confirm'],
                        'claim_data_date' => $hyper->datethai->DateThai1($claim_data['claim_date']),
                        'claim_data_detail' => $claim_data['detail'],
                        'count_claim' => $count_claim,
                        // selled_data
                        'selled_date' => $hyper->datethai->DateThai1($selled_date),
                        // data_result
                        'data_result_username' => $data_result['username'] ?? "N/A",
                        'data_result_password' => $data_result['password'] ?? "N/A",
                        'data_result_display' => $data_result['display'] ?? "N/A",
                        // username
                        'username' => $username['username'],
                    ]);
                    $i++;
                } while ($i < $claim_result->num_rows);
            }
        } else if ($type == 'claim_first') {
            $sql_claim_first = "SELECT * FROM data_claim_first WHERE isDelete = 1 ORDER BY id DESC";
            $claim_result_first = $hyper->connect->query($sql_claim_first);

            if (!$claim_result_first) {
                $errormsg = "Error: " . $hyper->connect->error;
            }

            if ($claim_result_first->num_rows > 0) {
                $i = 0;
                do {
                    $claim_data = $claim_result_first->fetch_assoc();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT * FROM accounts WHERE ac_id={$claim_data['ac_id']}";
                    $username = $hyper->connect->query($select_user)->fetch_assoc();

                    $data_result = $hyper->connect->query($select_data)->fetch_assoc();

                    $select_selled_date = "SELECT selled_date FROM data_selled WHERE selled_id={$claim_data['claim_id']}";
                    $selled_date = $hyper->connect->query($select_selled_date)->fetch_assoc()['selled_date'] ?? "N/A";


                    array_push($data, [
                        // claim_data
                        'id' => $claim_data['id'],
                        'claim_data_id' => $claim_data['claim_id'],
                        'claim_data_confirm' => $claim_data['confirm'],
                        'claim_data_date' => $hyper->datethai->DateThai1($claim_data['claim_date']),
                        'claim_data_detail' => $claim_data['detail'],
                        // selled_data
                        'selled_date' => $selled_date == 'N/A' ? $selled_date : $hyper->datethai->DateThai1($selled_date),
                        // data_result
                        'data_result_username' => $data_result['username'] ?? "N/A",
                        'data_result_password' => $data_result['password'] ?? "N/A",
                        'data_result_display' => $data_result['display'] ?? "N/A",
                        // username
                        'username' => $username['username'],
                    ]);
                    $i++;
                } while ($i < $claim_result_first->num_rows);
            }
        } else if ($type == 'data_selled') {
            $sql_selled = "SELECT * FROM data_selled WHERE isDelete = 1 ORDER BY selled_id ASC";
            $selled_result = $hyper->connect->query($sql_selled);

            if (!$selled_result) {
                $errormsg = "Error: " . $hyper->connect->error;
            }

            if ($selled_result->num_rows > 0) {
                $i = 0;
                do {
                    $selled = mysqli_fetch_assoc($selled_result);
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
                } while ($i < $selled_result->num_rows);
            }
        }
    } else {
        $errormsg = "type is not set";
    }

    if (!$errormsg) {
        echo json_encode([
            'code' => 200,
            'data' => $data,
        ]);
    } else {
        echo json_encode([
            'code' => 500,
            'message' => $errormsg,
        ]);
    }
}
