<?php
include("hyper_api.php");
$data = [];

if (isset($_POST)) {
    if ($_POST['action'] == 'getreport') {
        if ($_POST['type'] == 1) {
            $select_claim = "SELECT * FROM data_claim WHERE confirm!=9 ORDER BY id DESC LIMIT 20";
            $claim_result = $hyper->connect->query($select_claim);
            $i = 0;
            if (mysqli_num_rows($claim_result) > 0) {
                do {
                    $claim_data = $claim_result->fetch_array();
                    $select_data = "SELECT * FROM game_data WHERE data_id={$claim_data['data_id']}";
                    $select_user = "SELECT * FROM accounts WHERE ac_id={$claim_data['ac_id']}";
                    $username = $hyper->connect->query($select_user)->fetch_array();

                    $data_result = $hyper->connect->query($select_data)->fetch_array();
                    $data_result['password'] = base64_decode($data_result['password']);

                    array_push($data, [
                        // data_claim
                        //
                    ]);

                } while ($i < mysqli_num_rows($claim_result));
            }
        } else {
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
