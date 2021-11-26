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

if (isset($_SESSION['USER_SID'])) {

  $loged = 1;
  $sid = $_SESSION['USER_SID'];
  $var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
  $data_user = $hyper->connect->query($var)->fetch_array();

  $username = $data_user['username'];
  $points = number_format($data_user['points'], 0);
  $email = $data_user['email'];
  $role = $data_user['role'];
  $sid = $data_user['sid'];
  $ac_id = $data_user['ac_id'];

  setcookie('USER_SID', $sid, time() + 1 * 24 * 60 * 60);
} else {
  $loged = 0;
}

if (empty($_GET['thispage'])) {
  $_GET['thispage'] = 'home';
}

$page = $_GET['thispage'];

function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));
  $strHour = date("H", strtotime($strDate));
  $strMinute = date("i", strtotime($strDate));
  $strday = date("l", strtotime($strDate));
  $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  $strdayCut = array("", "วันจันทร์ที่", "วันอังคารที่", "วันพุธที่", "วันพฤหัสบดีที่", "วันศุกร์ที่", "วันเสาร์ที่", "วันอาทิตย์ที่");
  if ($strday == "Monday") {
    $strdayThai = $strdayCut[1];
  } elseif ($strday == "Tuesday") {
    $strdayThai = $strdayCut[2];
  } elseif ($strday == "Wednesday") {
    $strdayThai = $strdayCut[3];
  } elseif ($strday == "Thursday") {
    $strdayThai = $strdayCut[4];
  } elseif ($strday == "Friday") {
    $strdayThai = $strdayCut[5];
  } elseif ($strday == "Saturday") {
    $strdayThai = $strdayCut[6];
  } elseif ($strday == "Sunday") {
    $strdayThai = $strdayCut[7];
  }
  $strMonthThai = $strMonthCut[$strMonth];
  return "$strdayThai $strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
}

if (isset($_COOKIE['USER_SID'])) {
  $sid = $_COOKIE['USER_SID'];
  $var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
  $user_query = $hyper->connect->query($var);
  $total_user = mysqli_num_rows($user_query);
  $data_user = $hyper->connect->query($var)->fetch_array();
  $select_noti = "SELECT * FROM notify_log WHERE _to={$data_user['ac_id']}";

  $notify = $hyper->connect->query($select_noti);

  for ($i = 0; $i < $notify->num_rows; $i++) {
    $datetime = $notify->fetch_array()['datetime'];
    if (date_diff(date_create($datetime), date_create('now'))->format("%a") > 7) {
      $hyper->connect->query("DELETE FROM notify_log WHERE _to='{$data_user['ac_id']}' AND datetime='$datetime'");
    }
  }
}
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


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
  <link href="assets/css/hyper.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-VhBcF/php0Z/P5ZxlxaEx1GwqTQVIBu4G4giRWxTKOCjTxsPFETUDdVL5B6vYvOt" crossorigin="anonymous">

  <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> -->
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
    .modal {
      z-index: 1052 !important;
      /* display: none !important; */
    }

    .modal-backdrop.fade.show {
      z-index: 1051 !important;
      /* display: none !important; */
    }

    @media screen and (max-width: 768px) {
      .modal {
        z-index: 1052 !important;
        /* display: none !important; */
      }

      .modal-backdrop.fade.show {
        /* z-index: 1051 !important; */
        display: none !important;
      }
    }

    .btn {
      color: white;
    }

    a .pu:hover {
      color: #b67bfb;
      text-shadow:
        0 0 7px #b67bfb,
        0 0 10px #b67bfb,
        0 0 21px #b67bfb,
        0 0 42px #b67bfb,
        0 0 82px #b67bfb,
        0 0 92px #b67bfb,
        0 0 102px #b67bfb,
        0 0 151px #b67bfb;
      animation: pulsate 1.2s infinite alternate;
    }

    a .gr:hover {
      color: #40ff56;
      text-shadow:
        0 0 7px #40ff56,
        0 0 10px #40ff56,
        0 0 21px #40ff56,
        0 0 42px #40ff56,
        0 0 82px #40ff56,
        0 0 92px #40ff56,
        0 0 102px #40ff56,
        0 0 151px #40ff56;
      animation: pulsate 1.2s infinite alternate;
    }

    a .pk:hover {
      color: pink;
      text-shadow:
        0 0 7px #fc2c84,
        0 0 10px #fc2c84,
        0 0 21px #fc2c84,
        0 0 42px #fc2c84,
        0 0 82px #fc2c84,
        0 0 92px #fc2c84,
        0 0 102px #fc2c84,
        0 0 151px #fc2c84;
      animation: pulsate 1.2s infinite alternate;
    }

    a .yl:hover {
      color: #f7ff24;
      text-shadow:
        0 0 7px #f7ff24,
        0 0 10px #f7ff24,
        0 0 21px #f7ff24,
        0 0 42px #f7ff24,
        0 0 82px #f7ff24,
        0 0 92px #f7ff24,
        0 0 102px #f7ff24,
        0 0 151px #f7ff24;
      animation: pulsate 1.2s infinite alternate;
    }
    .yl:hover {
      color: #f7ff24;
      text-shadow:
        0 0 7px #f7ff24,
        0 0 10px #f7ff24,
        0 0 21px #f7ff24,
        0 0 42px #f7ff24,
        0 0 82px #f7ff24,
        0 0 92px #f7ff24,
        0 0 102px #f7ff24,
        0 0 151px #f7ff24;
      animation: pulsate 1.2s infinite alternate;
    }

    a .or:hover {
      color: #ffaa56;
      text-shadow:
        0 0 7px #ffaa56,
        0 0 10px #ffaa56,
        0 0 21px #ffaa56,
        0 0 42px #ffaa56,
        0 0 82px #ffaa56,
        0 0 92px #ffaa56,
        0 0 102px #ffaa56,
        0 0 151px #ffaa56;
      animation: pulsate 1.2s infinite alternate;
    }

    a .bl:hover {
      color: #00c0ff;
      text-shadow:
        0 0 7px #00c0ff,
        0 0 10px #00c0ff,
        0 0 21px #00c0ff,
        0 0 42px #00c0ff,
        0 0 82px #00c0ff,
        0 0 92px #00c0ff,
        0 0 102px #00c0ff,
        0 0 151px #00c0ff;
      animation: pulsate 1.2s infinite alternate;
    }

    a .rd:hover {
      color: #ff3434;
      text-shadow:
        0 0 7px#ff3434,
        0 0 10px#ff3434,
        0 0 21px #ff3434,
        0 0 42px#ff3434,
        0 0 82px #ff3434,
        0 0 92px#ff3434,
        0 0 102px #ff3434,
        0 0 151px #ff3434;
      animation: pulsate 1.2s infinite alternate;
    }

    .swal-modal .swal-text {
      text-align: center;
    }
  </style>
</head>

<body>
  <!-- User Navbar -->
  <?php
  if ($loged == 1 && isset($_COOKIE['USER_SID'])) {
    include('page/user/user_nav.php');
  } else {
    include('page/nav.php');
  }
  ?>
  <!-- End User Navbar -->

  <!-- Container Start -->
  <div class="container" style="padding-top: 110px;">
    <?php
    if ($loged == 1 && isset($_COOKIE['USER_SID'])) {

      if ($page == 'home') {
        include('page/welcome.php');
      } elseif ($page == 'profile') {
        include('page/user/profile.php');
      } elseif ($page == 'history') {
        include('page/user/myhistory.php');
      } elseif ($page == 'topup') {
        include('page/user/pay.php');
      } elseif ($page == 'shop') {
        include('page/user/shop.php');
      } elseif ($page == 'item') {
        include('page/user/iteminfo.php');
      } elseif ($page == 'logout') {
        include('page/logout.php');
      } elseif ($page == 'adminsys') {
        if ($data_user['role'] == '779') {
          include('page/admin/dash.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'gametype') {
        if ($data_user['role'] == '779') {
          include('page/admin/game_edit.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'gameselect') {
        if ($data_user['role'] == '779') {
          include('page/admin/game_item/game_select.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'editgame') {
        if ($data_user['role'] == '779') {
          include('page/admin/game_item/menu_game_edit.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'gamecard') {
        if ($data_user['role'] == '779') {
          include('page/admin/game_item/edit_game_card.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'gamedata') {
        if ($data_user['role'] == '779') {
          include('page/admin/game_item/game_data.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'dataowner') {
        if ($data_user['role'] == '779') {
          include('page/admin/data_owner.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'datauser') {
        if ($data_user['role'] == '779') {
          include('page/admin/data_user.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'datapay') {
        if ($data_user['role'] == '779') {
          include('page/admin/history_pay.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'websetting') {
        if ($data_user['role'] == '779') {
          include('page/admin/web_config.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } elseif ($page == 'report') {
        if ($data_user['role'] == '779') {
          include('page/admin/aleart.php');
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      } else {
        $page = 'home';
        include('page/welcome.php');
      }
    } else {

      if ($page == 'login') {
        include('page/sign-in.php');
      } elseif ($page == 'register') {
        include('page/sign-up.php');
      } elseif ($page == 'resetpassword') {
        include('page/resetpassword.php');
      } else {
        if ($page == 'shop') {
          $page = 'home';
          include('page/welcome.php');
          echo "<script>";
          echo "swal('คุณยังไม่ได้เข้าสู่ระบบ', '', 'error').then(function() {
            window.location.replace('./home');
          });";
          echo "</script>";
        } else {
          $page = 'home';
          include('page/welcome.php');
        }
      }
    }
    ?>

    <!-- Footer -->
    <small class="pb-3 d-block my-auto footer-copyright text-secondary text-center py-4 w-100">© Copyright 2021 Website By <a href="https://twitter.com/dexy_store" target="_blank">Dexy Store</a> All Rights Reserved.</small>
    <!-- End Footer -->
  </div>
  <!-- Container End -->


</body>

</html>