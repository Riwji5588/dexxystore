<?php

unset($_COOKIE['USER_SID']);
	session_destroy();
	setcookie("USER_SID", "", 0);
	echo "<script>";
	echo 'window.location = "'.$url.'";';
	echo "</script>";
