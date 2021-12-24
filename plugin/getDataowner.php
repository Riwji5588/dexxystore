<?php
include("hyper_api.php");

if (isset($_GET)) {
    if ($_GET['action'] == 'getdataowner'){
        $data = [];
        
        $sql_select_selled = "SELECT * FROM data_selled";
        $query_selled = $hyper->connect->query($sql_select_selled);
        $total_selled_row = mysqli_num_rows($query_selled);
        $i = 0;
        
        if ($total_selled_row > 0) {
            do {
        
                $selled = mysqli_fetch_assoc($query_selled);
                $selled_data_id = $selled['data_id'];
                $selled_account_id = $selled['ac_id'];
        
                $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$selled_data_id'";
                $query_selled_data = $hyper->connect->query($sql_select_selled_data);
                $selled_data = mysqli_fetch_assoc($query_selled_data);
        
                $selled_game_id = $selled_data['game_id'];
        
                $sql_select_type_card = "SELECT * FROM game_card WHERE game_id = '$selled_game_id'";
                $query_type_card = $hyper->connect->query($sql_select_type_card);
                $cardtype = mysqli_fetch_assoc($query_type_card);
        
                $sql_select_selled_account = "SELECT username FROM accounts WHERE ac_id = '$selled_account_id'";
                $query_selled_account = $hyper->connect->query($sql_select_selled_account);
                $selled_account = mysqli_fetch_assoc($query_selled_account);
        
                $expire = strtotime($selled['exp_date']) - strtotime('today midnight');
                array_push($data, [
                    // selled
                    'selled_id' => $selled['selled_id'],
                    'selled_date' => $selled['selled_date'],
                    // selled_data
                    'selled_data_username' => $selled_data['username'],
                    'selled_data_id' => $selled_data['data_id'],
                    'selled_data_password' => $selled_data['password'],
                    'selled_data_display' => $selled_data['display'],
                    'selled_data_detail' => $selled_data['detail'],
                    // selled_account
                    'account_username' => $selled_account['username'],
                    // cardtype
                    'card_id' => $cardtype['card_id'],
                    'card_title' => $cardtype['card_title'],
                    'card_price' => $cardtype['card_price'],
                    //
                    'expire' => $expire
                ]);
                // array_push($data, [
                //     // selled
                //     'selled_id' => $selled['selled_id'],
                // ]);
                $i++;
            } while ($i < $total_selled_row);
        }
        
        
        if ($total_selled_row == count($data)) {
            echo json_encode(['code' => 200, 'data' => $data]);
        } else {
            echo json_encode(['code' => 500, 'data' => 'Error']);
        }
    } else {
        echo json_encode(['code' => 500, 'data' => 'Error']);
    }
} else {
    echo json_encode(['code' => 405, 'data' => 'Method Not Allowed']);
}
