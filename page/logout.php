<?php

unset($_COOKIE['USER_SID']);
unset($_SESSION['USER_SID']);
session_destroy();
setcookie("USER_SID", null, -1, "/");
echo "<script>";
echo 'window.location = "' . $url . '";';
echo "</script>";
