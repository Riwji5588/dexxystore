        <!-- Image Banner -->
          <div id="carouselExampleInterval" class="carousel slide shadow-dark radius-border" data-ride="carousel">
            <div class="carousel-inner radius-border">

            <?php

            $sql_select_slide_image = "SELECT * FROM image_slide ORDER BY slide_id DESC";
            $query_slide_image = $hyper->connect->query($sql_select_slide_image);
            $slide_image = mysqli_fetch_array($query_slide_image);
            $active = 1;
            do{

            ?>
              <div class="carousel-item <?php if($active == 1){echo 'active'; } ?>" data-interval="7000">
                <img src="assets/img/slide/<?= $slide_image['image_name'] ?>" class="d-block w-100" alt="...">
              </div>
            <?php $active = 0; }while ($slide_image = mysqli_fetch_array($query_slide_image)); ?>

            </div>

            <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>

        </div>
        <!-- End Image Banner -->

        <!-- Site Banner Text -->
        <div class="card mt-4 shadow-dark radius-border hyper-bg-white">
        <div class="card-body">
        <div class="media">
            <img src="assets/img/logo.jpg" class="mr-3 img-fluid rounded-circle shadow-dark" style="width:17%;max-width: 130px;">
            <div class="media-body">
              <div class="mt-0 d-none d-lg-block">
                  <h1 class="mt-0 mb-1"><b>Dexy Store</b> เว็บไซต์บริการจำหน่าย ID Netflix มากมาย</h1>
<pre>
Welcome to Dexy Store
</pre>
              </div>
              <div class="d-block d-lg-none"><h1 class="mt-0 mb-2"><b></b></h1><h4>เว็บไซต์บริการจำหน่าย ID Netflix มากมาย</h4></div>
              
            </div>
        </div>
        </div>
        </div>
        <!-- End Site Banner Text -->

        <!-- Status Site Bar -->
        <div class="row no-gutters mt-4">
        <?php
          $game_type = "SELECT count(game_id) AS 'totalgame' FROM game_type";
          $game_type_row = $hyper->connect->query($game_type)->fetch_array();

          $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE selled = 0";
          $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

          $data_selled = "SELECT count(data_id) AS 'totalselled' FROM game_data WHERE selled = 1";
          $selled_row = $hyper->connect->query($data_selled)->fetch_array();
        ?>
            <div class="col-12 col-lg-4 p-2">
                <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3">
                    <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-gamepad"></i></h1>
                    <h1 class="mt-0 mb-0"><?= number_format($game_type_row['totalgame'],0); ?></h1>
                    <font class="text-muted">Accounts</font>
                </div>
            </div>
            
            <div class="col-6 col-lg-4 p-2">
                <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3">
                    <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-check-circle"></i></h1>
                    <h1 class="mt-0 mb-0"><?= number_format($ready_selled_row['totaldata'],0); ?></h1>
                    <font class="text-muted">Netflixพร้อมจำหน่าย</font>
                </div>
            </div>
            
            <div class="col-6 col-lg-4 p-2">
                <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3">
                    <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-box-full"></i></h1>
                    <h1 class="mt-0 mb-0"><?= number_format($selled_row['totalselled'],0); ?></h1>
                    <font class="text-muted">Netflixถูกจำหน่ายแล้ว</font>
                </div>
            </div>

        </div>
        <!-- End Status Site Bar -->


        <!-- Game Type -->
        <h1 class="text-center mt-4 mb-2">Netflixพร้อมจำหน่าย</h1>
        <div class="row no-gutters">

        <?php
          $sql_select_game = "SELECT * FROM game_type ORDER BY game_id DESC";
          $query_game = $hyper->connect->query($sql_select_game);
          $total_game_row = mysqli_num_rows($query_game);
          $game = mysqli_fetch_array($query_game);

          if($total_game_row <= 0){
          ?>
          <h4 class="text-center w-100 mt-4">ไม่มีเกมในขณะนี้</h4>
          <?php 
          }else{
          do{
              $gid = $game['game_id'];
              $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE game_id = $gid AND selled = 0";
              $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

              if($ready_selled_row['totaldata'] > 0){

        ?>
            <div class="col-6 col-lg-4 p-2">
                <a href="shop&gameid=<?= $game['game_id']; ?>">
                <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-2 h-100 hyper-card">
                    <div class="media">
                        <img src="assets/img/game/<?= $game['game_image']; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;">
                        <div class="media-body text-center text-md-left">
                          <img src="assets/img/game/<?= $game['game_image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;">
                          <h4 class="mt-0 mb-1"><?= $game['game_name']; ?></h4>
                          <font class="text-muted"><?= number_format($ready_selled_row['totaldata'],0); ?> ไอดี</font>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        <?php }}while ($game = mysqli_fetch_array($query_game));} ?>

        </div>
        <!-- End Game Type -->