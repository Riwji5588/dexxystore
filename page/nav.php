<link rel="stylesheet" href="responsive-nav.css">
<script src="responsive-nav.js"></script>

<nav class="navbar navbar-expand-md navbar-dark fixed-top justify-content-center" style="background-color: #131315;">
  <a class="navbar-brand" href="home">
    <img src="assets/img/logo_dexyStore.png" width="120" height="60" class="d-inline-block align-top rounded-circle">
  </a>
  <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar2">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse justify-content-center align-items-center  w-100" id="collapsingNavbar2">
    <ul class="navbar-nav justify-content-center" align="center">
      <li><a href="login" class="btn btn-sm gr my-2 my-sm-0 mr-2"><i class="fal fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ</a></li>
      <li><a href="register" class="btn btn-sm or my-2 my-sm-0 mr-2"><i class="fal fa-user-plus mr-1"></i> สมัครสมาชิก</a></li>
      <li><a href="https://twitter.com/dexy_store" target="_blank" class="btn btn-sm bl my-2 my-sm-0 mr-2"><i class="fab fa-twitter-square mr-1"></i> Twitter</button></a></li>
    </ul>

  </div>
</nav>

<style>
  #collapsingNavbar2 ul li a {
    color: #FFF;

  }

  @media (min-width: 771px) {
    #collapsingNavbar2 {
      margin-right: 140px;
    }
  }
</style>