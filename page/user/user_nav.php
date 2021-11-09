<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">
            <img src="assets/img/<?= $webimage; ?>" width="64" height="64" class="d-inline-block align-top rounded-circle">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
          <div class="form-inline my-2 my-lg-0">

            <a href="home"><button class="btn btn-sm hyper-btn-dark<?php if($page == 'home' || $page == 'shop' || $page == 'item'){echo '-active'; } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-home-lg-alt mr-1"></i> หน้าแรก</button></a>
            <a href="profile"><button class="btn btn-sm hyper-btn-orange<?php if($page == 'profile'){echo '-active'; } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-user mr-1"></i> บัญชีของฉัน</button></a>
            <?php if($data_user['role'] == '779'){ ?><a href="adminsys"><button class="btn btn-sm hyper-btn-pink<?php if($page == 'adminsys' || $page == 'gametype' || $page == 'gameselect' || $page == 'editgame' || $page == 'gamecard' || $page == 'gamedata' || $page == 'dataowner' || $page == 'datauser' || $page == 'datapay' || $page == 'websetting'){echo '-active'; } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-tools mr-1"></i> ระบบแอดมิน</button></a><?php } ?>
            <a href="history"><button class="btn btn-sm hyper-btn-perple<?php if($page == 'history'){echo '-active'; } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-history mr-1"></i> ไอดีของฉัน</button></a>
            <a href="topup"><button class="btn btn-sm hyper-btn-success<?php if($page == 'topup'){echo '-active'; } ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-credit-card mr-1"></i> เติมเงิน</button></a>
            <a href="https://www.facebook.com/<?= $webfacebook; ?>" target="_blank"><button class="btn btn-sm hyper-btn-primary my-2 my-sm-0 mr-2" type="button"><i class="fab fa-facebook-square mr-1"></i> Facebook</button></a>
            <a href="logout"><button class="btn btn-sm hyper-btn-danger my-2 my-sm-0 mr-3" type="button"><i class="fad fa-times-circle mr-1"></i> ออกจากระบบ</button></a>
            
          </div>
        </div>
    </nav>