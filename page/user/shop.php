<?php

if (empty($_GET['gameid'])) {
  $id = -7;
} else {
  $id = $_GET['gameid'];
}

$sql_select_game = "SELECT * FROM game_type WHERE game_id = '$id'";
$query_game = $hyper->connect->query($sql_select_game);
$total_game_row = mysqli_num_rows($query_game);
$game = mysqli_fetch_array($query_game);

$gid = $game['game_id'];

$card = "SELECT count(card_id) AS 'totalcard' FROM game_card WHERE game_id = $gid";
$card_row = $hyper->connect->query($card)->fetch_array();

if ($total_game_row <= 0) {

  include('page/welcome.php');
} else {
?>

  <!-- Shop ID -->
  <div class="media mt-3 mb-3 pl-2">
    <img src="assets/img/game/<?= $game['game_image']; ?>" width="80px" class="mr-3 rounded-circle">
    <div class="media-body pt-2" style=" color : white; ">
      <h3 class="mt-0 d-none d-lg-block"><?= $game['game_name']; ?> <font class="ml-2 mr-2">|</font> เงินคงเหลือ <?= $points; ?> บาท</h3>
      <h3 class="mt-0 d-block d-lg-none"><?= $game['game_name']; ?><h5 class="mt-0 d-block d-lg-none">เงิน คงเหลือ <?= $points; ?> บาท</h5>
      </h3>
      <font class="text-muted" style=" color: white; ">มีสินค้าทั้งหมด <?= number_format($card_row['totalcard'], 0); ?> รายการ</font>
    </div>
  </div>

  <!-- ID CARD -->
  <div class="row no-gutters justify-content-center">
    <?php

    $perpage = 9;

    $sql_select_game = "SELECT * FROM game_card WHERE game_id = '$id'";
    $query_game = $hyper->connect->query($sql_select_game);
    $total_game_row = mysqli_num_rows($query_game);
    $total_page = ceil($total_game_row / $perpage);
    $limit_page = $total_page;

    if (empty($_GET['page'])) {
      $_GET['page'] = '1';
      $page = 1;
    }

    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }

    if ($_GET['page'] <= 0 || $_GET['page'] > $total_page || !filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
      $_GET['page'] = '1';
      $page = 1;
    }

    $start = ($page - 1) * $perpage;

    $sql_select_game_page = "SELECT * FROM game_card WHERE game_id = '$id' LIMIT {$start} , {$perpage}";
    $query_game_page = $hyper->connect->query($sql_select_game_page);

    if ($total_game_row <= 0) {
    ?>
      <h4 class="text-center w-100 mt-4">ไม่มีข้อมูลในขณะนี้</h4>
      <?php } else {
      $card = mysqli_fetch_array($query_game_page);
      do {

        $imgid = $card['card_id'];
        $sql_select_card_image = "SELECT * FROM card_image WHERE card_id = '$imgid' ORDER BY image_id ASC LIMIT 1";
        $query_card_image = $hyper->connect->query($sql_select_card_image);
        $card_image = mysqli_fetch_array($query_card_image);


        $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE card_id = $imgid AND selled = 0";
        $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

        if ($ready_selled_row['totaldata'] > 0) {
      ?>

          <div class="col-10 col-md-6 col-lg-4 p-2" data-toggle="modal" data-target="#detail<?= $card['card_id'] ?>">
            <div class="card shadow-dark radius-border-6 hyper-bg-white hyper-card h-100" style="border:3px solid #2E384D !important;">
              <img src="assets/img/item/<?= $card_image['image_name']; ?>" class="card-img-top img-fluid" style="border-top-left-radius: 0.6rem !important;border-top-right-radius: 0.6rem !important;">
              <div class="card-body">
                <h5 class="mt-0 mb-2" id="title<?= $card['card_id'] ?>"><?= $card['card_title'] ?></h5>
                <h5 class="mt-0" id="price<?= $card['card_id'] ?>">ราคา <?= number_format($card['card_price'], 0) ?> บาท</h5>
                <h6 class="mt-0" style="color: green;">พร้อมส่ง</h6>
                <div class="row no-gutters ml-auto mr-auto mt-3">
                  <button id="click<?= $card['card_id'] ?>" class="btn btn-sm hyper-btn-success col-12" type="button" data-toggle="modal" data-target="#detail<?= $card['card_id'] ?>" style=" color: black;"><i class="fal fa-shopping-cart mr-1"></i>ซื้อสินค้า</button>
                </div>
              </div>
            </div>
          </div>

          <!--modal start Detail-->
          <div class="modal fade" id="detail<?= $card['card_id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                <div class="modal-header text-danger" style="background: #fff;">
                  <h5 class="modal-title"><i class="fal fa-info-circle mr-1"></i> กรุณาอ่านรายละเอียดก่อนสั่งซื้อสินค้า</h5>
                </div>
                <div class="modal-body text-left">

                  <div class="col-12">
                    <div id="insub" class="carousel slide" data-ride="carousel" style="padding: 10px;">
                      <ol class="carousel-indicators">
                        <li data-target="#insub" data-slide-to="0" class="active"></li>
                        <li data-target="#insub" data-slide-to="1"></li>
                        <li data-target="#insub" data-slide-to="2"></li>
                      </ol>
                      <div class="carousel-inner align-items-center">
                        <div class="carousel-item active" align="center">
                          <img src="assets/img/1.png" class="d-block w-70 carousel" alt="...">
                        </div>
                        <div class="carousel-item" align="center">
                          <img src="assets/img/2.png" class="d-block w-70 carousel" alt="...">
                        </div>
                        <div class="carousel-item" align="center">
                          <img src="assets/img/3.png" class="d-block w-70 carousel" alt="...">
                        </div>
                        <div class="carousel-item" align="center">
                          <img src="assets/img/4.png" class="d-block w-70 carousel" alt="...">
                        </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-target="#insub" data-slide="prev">
                        <span class="carousel-control-prev-icon color-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-target="#insub" data-slide="next">
                        <span class="carousel-control-next-icon color-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </button>
                    </div>
                  </div>
                  </pre>
                  <div class="modal-footer p-2 border-0 row">

                    <button onclick="BuyItem(this)" value="<?= $card['card_id'] ?>" class="btn  hyper-btn-buy mb-2 mb-md-0 mr-0 mr-md-2 "><i class="fal fa-shopping-cart mr-1"></i>ซื้อสินค้า</button>
                    <button type="button" class="btn  hyper-btn-notoutline-danger  mb-2 mb-md-0 mr-0 mr-md-2" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>

                  </div>

                </div>
              </div>
            </div>
          </div>
          <!--modal End Detail-->

    <?php }
      } while ($card = mysqli_fetch_array($query_game_page));
    } ?>

  </div>
  <!-- End ID CARD -->
  <?php
  if ($total_page > 1) {

    $backpage = $_GET['page'] - 1;
    $nextpage = $_GET['page'] + 1;

  ?>
    <!-- Pagination -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center mb-0 mt-3">
        <li class="page-item <?php if ($_GET['page'] <= 1) {
                                echo 'disabled';
                              } ?>">
          <a class="page-link" href="shop&gameid=<?= $game['game_id']; ?>&page=<?= $backpage; ?>" tabindex="-1" aria-disabled="true">หน้าก่อนหน้า</a>
        </li>
        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
          <li class="page-item"><a class="page-link <?php if ($_GET['page'] == $i) {
                                                      echo 'active';
                                                    } ?>" href="shop&gameid=<?= $game['game_id']; ?>&page=<?= $i; ?>"><?= $i; ?></a></li>
        <?php } ?>
        <li class="page-item <?php if ($_GET['page'] >= $total_page) {
                                echo 'disabled';
                              } ?>">
          <a class="page-link" href="shop&gameid=<?= $game['game_id']; ?>&page=<?= $nextpage; ?>">หน้าถัดไป</a>
        </li>
      </ul>
    </nav>
    <!-- End Pagination -->
  <?php } ?>
  <!-- End Shop ID-->

  <script>
    function open(id) {
      document.getElementById(id).click
    }

    function BuyItem(id) {

      var id = id.value;

      swal({
          title: 'ต้องการซื้อสินค้านี้หรือไม่',
          text: 'สินค้า ' + $('#title' + id).html() + '\n' + $('#price' + id).html(),
          icon: "info",
          buttons: {
            confirm: {
              text: 'ซื้อสินค้า',
              className: 'hyper-btn-notoutline-success'
            },
            cancel: 'ยกเลิก'
          },
          closeOnClickOutside: false,
        })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({

              type: "POST",
              url: "plugin/buyitem.php",
              dataType: "json",
              data: {
                type: 1,
                id: id
              },

              beforeSend: function() {
                swal("กำลังซื้อสินค้า กรุณารอสักครู่...", {
                  button: false,
                  closeOnClickOutside: false,
                  timer: 500,
                });

              },

              success: function(data) {
                setTimeout(() => {
                  if (data.code == "200") {
                    swal({
                      title: 'ซื้อสินค้า สำเร็จ!',
                      text: 'ออเดอร์ที่ ' + data.order + ' สินค้าของคุณจะไปอยู้ในหน้าประวัติการซื้อ !',
                      icon: "success",
                      closeOnClickOutside: false,
                      button: false,
                    });
                    setTimeout(function() {
                      window.location.reload();
                    }, 1500);
                  } else {
                    swal(data.msg, "\n", "error", {
                      button: {
                        className: 'hyper-btn-notoutline-danger',
                      },
                      closeOnClickOutside: false,
                    });
                  }
                }, 600);
              }

            });

          }
        });

    }
  </script>

<?php } ?>

<style>
  body {
    background-color: #131315;
  }
</style>