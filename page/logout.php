<?php

	session_destroy();
	unset($_COOKIE['USER_SID']);
	setcookie("USER_SID", "", time()-3600);
	echo "<script>";
	echo 'window.location = "'.$url.'";';
	echo "</script>";

?>