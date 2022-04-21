<?php
include('./hyper_api.php');
date_default_timezone_set("Asia/Bangkok");
$errormsg = "";

if (isset($_GET)) {
    $sql_claim = "SELECT * FROM data_claim WHERE isDelete = 1 ORDER BY id DESC";
    $sql_claim_first = "SELECT * FROM data_claim_first WHERE isDelete = 1 ORDER BY id DESC";
    $sql_selled = "SELECT * FROM data_selled WHERE isDelete = 1 ORDER BY selled_id DESC";

    $claim_result = $hyper->connect->query($sql_claim);
    $claim_result_first = $hyper->connect->query($sql_claim_first);
    $selled_result = $hyper->connect->query($sql_selled);

    if (!$claim_result || !$claim_result_first || !$selled_result) {
        $errormsg = "Error: " . $hyper->connect->error;
    }

    if (!$errormsg) {
        echo json_encode([
            'code' => 200,
            'claim' => $claim_result->fetch_assoc(),
            'claim_first' => $claim_result_first->fetch_assoc(),
            'selled' => $selled_result->fetch_assoc(),
        ]);
    } else {
        echo json_encode([
            'code' => 500,
            'message' => $errormsg,
        ]);
    }
}
