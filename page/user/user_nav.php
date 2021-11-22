<nav class="navbar navbar-expand-md navbar-dark  fixed-top" style="background-color: #131315;">
  <a class="navbar-brand" href="home">
    <img src="assets/img/logo_dexyStore.jpg" width="64" height="64" class="d-inline-block align-top rounded-circle">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02" style="margin-right: 30%;">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    <div class="form-inline my-2 my-lg-0">

      <a href="home"><button class="btn btn-small pu <?php if ($page == 'home' || $page == 'shop' || $page == 'item') {
                                                        echo '-active';
                                                      } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-home-lg-alt mr-1"></i> หน้าแรก</button></a>
      <a href="profile"><button class="btn btn-sm gr <?php if ($page == 'profile') {
                                                        echo '-active';
                                                      } ?> my-2 my-sm-0 mr-2" type="butt><i class=" fal fa-user mr-1"></i> บัญชีของฉัน</button></a>
      <?php if ($data_user['role'] == '779') { ?><a href="adminsys"><button class="btn btn-sm pk <?php if ($page == 'adminsys' || $page == 'gametype' || $page == 'gameselect' || $page == 'editgame' || $page == 'gamecard' || $page == 'gamedata' || $page == 'dataowner' || $page == 'datauser' || $page == 'datapay' || $page == 'websetting' || $page == 'report') {
                                                                                                    echo '-active';
                                                                                                  } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-tools mr-1"></i> ระบบแอดมิน</button></a><?php } ?>
      <a href="history"><button class="btn btn-sm yl <?php if ($page == 'history') {
                                                        echo '-active';
                                                      } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-history mr-1"></i> ประวัติการซื้อ</button></a>
      <a href="topup"><button class="btn btn-sm or <?php if ($page == 'topup') {
                                                      echo '-active';
                                                    } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-credit-card mr-1" style="color: white;"></i> เติมเงิน</button></a>
      <a href="https://twitter.com/dexy_store/" target="_blank"><button class="btn btn-sm bl my-2 my-sm-0 mr-2" type="button"><i class="fab fa-twitter-square mr-1"></i> Twitter</button></a>
      <a href="logout"><button class="btn btn-sm rd  my-2 my-sm-0 mr-3" type="button"><i class="fad fa-times-circle mr-1"></i> ออกจากระบบ</button></a>

    </div>
  </div>
</nav>

<style>
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
</style>