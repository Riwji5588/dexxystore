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
            <a href="login"><button class="btn btn-sm hyper-btn-success my-2 my-sm-0 mr-2" type="button"><i class="fal fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ</button></a>
            <a href="register"><button class="btn btn-sm hyper-btn-orange my-2 my-sm-0 mr-2" type="button"><i class="fal fa-user-plus mr-1"></i> สมัครสมาชิก</button></a>
            <a href="https://www.facebook.com/<?= $webfacebook; ?>" target="_blank"><button class="btn btn-sm hyper-btn-primary my-2 my-sm-0 mr-3" type="button"><i class="fab fa-facebook-square mr-1"></i> Facebook</button></a>
          </div>
        </div>
    </nav>