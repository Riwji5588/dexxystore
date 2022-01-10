<?php
include("hyper_api.php");

if (isset($_POST)) {
    if ($_POST['action'] == 'getalluser') {
        $users = [];
        $bans = [];

        $select = "SELECT ac_id, username, email, points, role, ban FROM accounts ORDER BY role DESC";
        $select_ban = "SELECT * FROM user_ban";
        $query = $hyper->connect->query($select);
        $ban_query = $hyper->connect->query($select_ban);
        $ban_row = $ban_query->num_rows;
        $row = $query->num_rows;
        $i = 0;

        do {
            $user = $query->fetch_assoc();
            $users[] = $user;
            $i++;
        } while ($i < $row);

        $i = 0;
        do {
            $ban = $ban_query->fetch_assoc();
            $bans["ac".$ban['ac_id']] = $ban;
            $i++;
        } while ($i < $ban_row);

        if ($row == count($users)) {
            echo json_encode(['code' => 200, 'data' => $users, 'ban' => $bans]);
        } else {
            echo json_encode(['code' => 500, 'data' => 'Error']);
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
