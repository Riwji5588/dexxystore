<?php

use function PHPSTORM_META\type;

include("hyper_api.php");
$data = [];

if ($_POST) {
    if ($_POST['action'] == 'getreport') {
        if ($_POST['type'] == 1) {
            $select_claim = "SELECT * FROM data_claim WHERE confirm!=9 ORDER BY id DESC LIMIT 100";
            $claim_result = $hyper->connect->query($select_claim);
            $i = 0;
            $row = mysqli_num_rows($claim_result);
            if ($row > 0) {
                do {
                    $claim_data = $claim_result->fetch_assoc();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT * FROM accounts WHERE ac_id={$claim_data['ac_id']}";
                    $username = $hyper->connect->query($select_user)->fetch_assoc();

                    $data_result = $hyper->connect->query($select_data)->fetch_assoc();

                    $select_selled_date = "SELECT selled_date FROM data_selled WHERE selled_id={$claim_data['claim_id']}";
                    $selled_date = $hyper->connect->query($select_selled_date)->fetch_assoc()['selled_date'];

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
                } while ($i < $row);
            }
            if ($row == count($data)) {
                echo json_encode(['code' => 200, 'data' => $data, 'row' => $row]);
            } else {
                echo json_encode(['code' => 500, 'data' => 'Error']);
            }
        } else {
            $select_claim = "SELECT * FROM data_claim_first WHERE confirm=0 ORDER BY id DESC";
            $claim_result = $hyper->connect->query($select_claim);
            $i = 0;
            $row = mysqli_num_rows($claim_result);
            if ($row > 0) {
                do {
                    $claim_data = $claim_result->fetch_assoc();
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
                        'claim_data_detail' => $claim_data['detail'] ,
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
                } while ($i < $row);
                if ($row == count($data)) {
                    echo json_encode(['code' => 200, 'data' => $data, 'row' => $row]);
                } else {
                    echo json_encode(['code' => 500, 'data' => 'Error']);
                }
            }
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
