<?php
include("hyper_api.php");
date_default_timezone_set("Asia/Bangkok");

if (isset($_POST)) {
    if ($_POST['action'] == 'getalluser') {
        $users = [];
        $bans = [];

        $select = "SELECT ac_id, username, email, points, role FROM accounts ORDER BY role DESC";
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
            $bans["ac" . $ban['ac_id']] = $ban;
            $i++;
        } while ($i < $ban_row);

        if ($row == count($users)) {
            echo json_encode(['code' => 200, 'data' => $users, 'ban' => $bans]);
        } else {
            echo json_encode(['code' => 500, 'data' => 'Error']);
        }
    } else if ($_POST['action'] == 'getusermodal') {
        $users = [];
        $bans = [];
        $orders = [];

        $select = "SELECT ac_id, username, email, points, role FROM accounts WHERE ac_id = '" . $_POST['id'] . "'";
        $select_ban = "SELECT * FROM user_ban WHERE ac_id = '" . $_POST['id'] . "'";
        $query = $hyper->connect->query($select);
        $ban_query = $hyper->connect->query($select_ban);
        $ban_row = $ban_query->num_rows;
        $user_row = $query->num_rows;

        $user = $query->fetch_assoc();
        if ($user != null) {
            $users[] = $user;
        }

        $ban = $ban_query->fetch_assoc();
        if ($ban != null) {
            $bans[] = $ban;
        } else {
            array_push($bans, ['ac_id' => 0]);
            $ban_row += 1;
        }

        $sellect_order = "SELECT selled_id, exp_date FROM data_selled WHERE ac_id='" . $_POST['id'] . "' ORDER BY selled_id ASC";
        $result = $hyper->connect->query($sellect_order);
        $order_row = mysqli_num_rows($result);
        $count = 0;
        if ($order_row > 0) {
            $i = 0;
            do {
                $order = $result->fetch_assoc();
                $now = strtotime(date('Y-m-d H:i:s'));
                $order_date = strtotime(date($order['exp_date']));

                $expire = $order_date - $now;
                if ($expire > 0) {
                    array_push($orders, (int)$order['selled_id']);
                    $count++;
                }
                $i++;
            } while ($order_row > $i);
        }

        if ($user_row == count($users) && $ban_row == count($bans) && $count == count($orders)) {
            echo json_encode(['code' => 200, 'data' => $users, 'ban' => $bans, 'order_id' => $orders]);
        } else {
            echo json_encode(['code' => 500, 'message' => $ban]);
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
