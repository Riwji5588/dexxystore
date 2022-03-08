<!-- Game Type -->

<h1 class="text-center mt-4 textanimate" style="color: white;" align="center">
  <div>เว็บไซต์ซื้อสินค้าอัตโนมัติ</div>
  <div>
    <span>บริการ 24 ชั่วโมง !</span>
  </div>
</h1><br>
<h1 id="titleOrder" class="text-center mb-2" style="color: white;">
  <div class="sign text-center" align="center">
    <span class="fast-flicker">สิน</span>ค้า<span class="flicker">แนะนำ</span>
  </div>
</h1><br>
<div class="row no-gutters" style="justify-content: center;">

  <?php
  $sql_select_game = "SELECT * FROM game_type ORDER BY game_id DESC";
  $query_game = $hyper->connect->query($sql_select_game);
  $total_game_row = mysqli_num_rows($query_game);
  $game = mysqli_fetch_array($query_game);



  if ($total_game_row <= 0) {
  ?>
    <h4 class="text-center w-100 mt-4">ไม่มีสินค้าในขณะนี้</h4>
    <?php
  } else {
    $allCount = 0;
    do {
      $gid = $game['game_id'];
      $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE game_id = $gid AND selled = 0";
      $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

      $sql_select_count = "SELECT COUNT(isactive) as isactive FROM game_card WHERE isactive = '1' AND game_id = $gid";
      $card_count = $hyper->connect->query($sql_select_count)->fetch_assoc();

      
      if ($ready_selled_row['totaldata'] > 0) {
        $allCount +=$ready_selled_row['totaldata'];
    ?>
        <div class="col-10 col-md-6 col-lg-4 p-2">
          <a href="shop&gameid=<?= $game['game_id']; ?>">
            <div class="card shadow-dark radius-border-6 hyper-bg-white hyper-card" style="border:3px solid #2E384D !important;">
              <img src="assets/img/game/<?= $game['game_image']; ?>" class="card-img-top img-fluid" style="border-top-left-radius: 0.6rem !important;border-top-right-radius: 0.6rem !important;">
              <div class="card-body">
                <h4 class="mt-0 mb-2" id="title<?= $game['game_id']; ?>"><?= $game['game_name']; ?></h4>
                <?php if ($card_count['isactive'] > 0) : ?>
                  <h5 style="color: green;" class="text-left"> พร้อมส่ง ! </h5>
                <?php elseif ($card_count['isactive'] == 0) : ?>
                  <h5 style="color: red;" class="text-left"> ไม่พร้อมส่ง </h5>
                <?php endif; ?>
              </div>
            </div>
          </a>
        </div>

  <?php }
    } while ($game = mysqli_fetch_array($query_game));

    if ($allCount == 0) {
      ?>
      <h3 class="text-center w-100 mt-4 text-light">ไม่มีสินค้าในขณะนี้</h3>
      <script>
        $('#titleOrder').hide();
      </script>
      <?php
    }
  } ?>





  <!-- End Game Type -->

  <style>
    body {
      background-color: #131315;
    }

    .color {
      background-color: #131315;
    }

    /* .hover:hover {
      box-shadow: 0px 0px 10px #fff;
    } */

    #hover:hover {
      color: #b67bfb;
      box-shadow:
        0 0 1px #b67bfb,
        0 0 4px #b67bfb,
        0 0 5px #b67bfb,
        0 0 6px #b67bfb,
        0 0 8px #b67bfb,
        0 0 10px #b67bfb,
        0 0 20px #b67bfb,
        0 0 25px #b67bfb;
      animation: pulsate 1.2s infinite alternate;
    }
  </style>