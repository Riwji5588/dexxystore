<?php
include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/hyper_class.php';

$hyper = (object) array(
    "user" => new User,
    "connect" => mysqli_connect($db_cofig['db_host'], $db_cofig['db_user'], $db_cofig['db_pass'], $db_cofig['db_name']),
    "url" => "https://sandbox.dexystore.me",
    // "url" => "http://localhost/dexystore",
    "line"=> new LineMsg,
    "notify" => new Notify,
    "datethai" => new DateThai,
);

