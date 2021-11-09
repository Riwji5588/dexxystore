<?php
session_start();
include("plugin/hyper_api.php");
require "plugin/directory.php";

  $web_sql = "SELECT * FROM web_config WHERE con_id = 1";
  $web_con = $hyper->connect->query($web_sql)->fetch_array();

  $webname = $web_con['name'];
  $webfacebook = $web_con['facebook'];
  $webdetail = $web_con['detail'];
  $webimage = $web_con['image'];
  $webopen = $web_con['opened'];

if(isset($_SESSION['USER_SID'])){

  $loged = 1;
  $sid = $_SESSION['USER_SID'];
  $var = "SELECT * FROM accounts WHERE sid = '".$sid."' ";
  $data_user = $hyper->connect->query($var)->fetch_array();

  $username = $data_user['username'];
  $points = number_format($data_user['points'],0);
  $email = $data_user['email'];
  $role =$data_user['role'];
  $sid =$data_user['sid'];
  $ac_id =$data_user['ac_id'];

  setcookie('USER_SID', $sid, time()+1*24*60*60);

}else{
  $loged = 0;
}

if(empty($_GET['thispage'])){
  $_GET['thispage'] = 'home';
}

$page = $_GET['thispage'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>HYPER STUDIO</title>

<link rel="shortcut icon" href="assets/img/<?= $webimage; ?>" type="image/png">
<link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
<link href="assets/css/animate.css" rel="stylesheet">
<script src="assets/js/sweetalert.min.js"></script>
<link href="assets/css/hyper.css" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-VhBcF/php0Z/P5ZxlxaEx1GwqTQVIBu4G4giRWxTKOCjTxsPFETUDdVL5B6vYvOt" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
  $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
      $('#datatable').DataTable();
  });
  </script>
  <style>
  .swal-modal .swal-text {
    text-align: center;
}
  </style>
</head>
<body>


    <!-- User Navbar -->
    <?php
      if($loged == 1){
        include('page/user/user_nav.php');
      }else{
        include('page/nav.php');
      }
    ?>
    <!-- End User Navbar -->

    <!-- Container Start -->
    <div class="container" style="padding-top: 110px;">

    <?php
      if($loged == 1){

        if($page == 'home'){
          include('page/welcome.php');
        }elseif($page == 'profile'){
          include('page/user/profile.php'); 
        }elseif($page == 'history'){
          include('page/user/myhistory.php'); 
        }elseif($page == 'topup'){
          include('page/user/pay.php'); 
        }elseif($page == 'shop'){
          include('page/user/shop.php'); 
        }elseif($page == 'item'){
          include('page/user/iteminfo.php'); 
        }elseif($page == 'logout'){
          include('page/logout.php'); 
        }
        
        
        
        elseif($page == 'adminsys'){
          if($data_user['role'] == '779'){
            include('page/admin/dash.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'gametype'){
          if($data_user['role'] == '779'){
            include('page/admin/game_edit.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'gameselect'){
          if($data_user['role'] == '779'){
            include('page/admin/game_item/game_select.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'editgame'){
          if($data_user['role'] == '779'){
            include('page/admin/game_item/menu_game_edit.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'gamecard'){
          if($data_user['role'] == '779'){
            include('page/admin/game_item/edit_game_card.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'gamedata'){
          if($data_user['role'] == '779'){
            include('page/admin/game_item/game_data.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'dataowner'){
          if($data_user['role'] == '779'){
            include('page/admin/data_owner.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'datauser'){
          if($data_user['role'] == '779'){
            include('page/admin/data_user.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'datapay'){
          if($data_user['role'] == '779'){
            include('page/admin/history_pay.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }elseif($page == 'websetting'){
          if($data_user['role'] == '779'){
            include('page/admin/web_config.php');
          }else{
            $page = 'home';
            include('page/welcome.php'); 
          }
        }
        
        

        else{
          $page = 'home';
          include('page/welcome.php'); 
        }

      }else{

        if($page == 'login'){
          include('page/sign-in.php');
        }elseif($page == 'register'){
          include('page/sign-up.php'); 
        }elseif($page == 'resetpassword'){
          include('page/resetpassword.php'); 
        }else{
          $page = 'home';
          include('page/welcome.php'); 
        }
        
      }
    ?>

    <!-- Footer -->
      <small class="pb-3 d-block my-auto footer-copyright text-secondary text-center py-4 w-100">©  Copyright 2021 Website By <a href="https://twitter.com/dexy_store" target="_blank">Dexy Store</a> All Rights Reserved.</small>
    <!-- End Footer -->
    </div>
    <!-- Container End -->


</body>
</html>