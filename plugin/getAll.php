<?php
include("hyper_api.php");

$users = [];

$select = "SELECT ac_id, username, email, points, role FROM accounts";
$query = $hyper->connect->query($select);
$row = $query->num_rows;
$i = 0;

do {
    $user = $query->fetch_assoc();
    $users[] = $user;
    $i++;
} while ($i < $row);


if ($row == count($users)) {
    echo json_encode(['code' => 200, 'data' => $users]);
} else {
    echo json_encode(['code' => 500, 'data' => 'Error']);
}
