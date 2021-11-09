<?php

$directory = "/"; //FolderDirectory Web
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $surl = "https://";  
}else{$surl = "http://";  }

$url= $surl.$_SERVER['HTTP_HOST'].$directory;
?>