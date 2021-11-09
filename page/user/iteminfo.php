<?php

if(empty($_GET['itemid'])){
    $id = -7;
}else{
    $id = $_GET['itemid'];
}

$sql_select_card = "SELECT * FROM game_card WHERE card_id = '$id'";
$query_card = $hyper->connect->query($sql_select_card);
$total_card_row = mysqli_num_rows($query_card);
$card = mysqli_fetch_array($query_card);

$gid = $card['game_id'];
$cid = $card['card_id'];

if($total_card_row <= 0){

    include('page/welcome.php'); 

}else{

  $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE card_id = $cid AND selled = 0";
  $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

  $sql_select_game = "SELECT * FROM game_type WHERE game_id = $gid";
  $game_row = $hyper->connect->query($sql_select_game)->fetch_array();

?>
      <!-- Info -->
      <div class="ml-auto mr-auto" style="max-width: 700px;">
      <div class="media mt-3 mb-3 pl-2">
        <img src="assets/img/game/<?= $game_row['game_image']; ?>" width="80px" class="mr-3 rounded-circle">
        <div class="media-body pt-2">
          <h3 class="mt-0"><?= $card['card_title']; ?></h3>
          <font class="text-muted"><?= $game_row['game_name']; ?> | เหลือจำนวน <?= number_format($ready_selled_row['totaldata'],0); ?> ไอดี</font>
        </div>
      </div>

        <!-- CARD -->
                <div class="card shadow-dark radius-border-6 hyper-bg-white border-0">

                  <!-- Image Slide -->
                  <div id="carouselExampleInterval" class="card-img-top img-fluid carousel slide " data-ride="carousel" style="border-top-left-radius: 0.6rem !important;border-top-right-radius: 0.6rem !important;">
                    <div class="carousel-inner" style="border-top-left-radius: 0.6rem !important;border-top-right-radius: 0.6rem !important;">
                    <?php

                      $sql_select_card_image = "SELECT * FROM card_image WHERE card_id = $cid ORDER BY image_id ASC";
                      $query_card_image = $hyper->connect->query($sql_select_card_image);
                      $card_image = mysqli_fetch_array($query_card_image);
                      $active = 1;
                      do{

                    ?>
                      <div class="carousel-item <?php if($active == 1){echo 'active'; } ?>" data-interval="7000">
                        <img src="assets/img/item/<?= $card_image['image_name']; ?>" class="d-block w-100">
                      </div>
                    <?php $active = 0; }while ($card_image = mysqli_fetch_array($query_card_image)); ?>

                    </div>
        
                    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                    <!-- End Image Slide -->
        
                </div>
                  <div class="card-body">
                    <h5 class="mt-0 mb-2" id="title<?= $card['card_id'] ?>" ><?= $card['card_title']; ?></h5>
                    <h5 class="mt-0" id="price<?= $card['card_id'] ?>">ราคา <?= number_format($card['card_price'],0); ?> Points</h5>
                    <h6 class="mt-0"><u>รายละเอียด</u></h6>
                    <pre>
<?= $card['card_detail']; ?></pre>
                    <div class="row no-gutters ml-auto mr-auto mt-3">
                      <button onclick="BuyItem(this)" value="<?= $card['card_id'] ?>" class="btn btn-sm hyper-btn-buy col-12 mb-2 mb-md-0 mr-0 mr-md-2"><i class="fal fa-shopping-cart mr-1"></i>ซื้อสินค้า</button>
                    </div>
                  </div>
                </div>
        <!-- End CARD -->
      </div>
      <!-- End Info-->
<?php } ?>

<script>

function BuyItem(id){

  var id = id.value;

  swal({
  title: 'ต้องการซื้อสินค้านี้หรือไม่',
  text: 'สินค้า '+$('#title'+id).html()+'\n'+ $('#price'+id).html(),
  icon: "info",
  buttons: {
    confirm : {text:'ซื้อสินค้า',className:'hyper-btn-notoutline-success'},
    cancel : 'ยกเลิก'
  },
  closeOnClickOutside:false,
  })
  .then((willDelete) => {
    if (willDelete) {

      $.ajax({

            type: "POST",
            url: "plugin/buyitem.php",
            dataType: "json",
            data: {id:id},

            beforeSend: function() {
            swal("กำลังซื้อสินค้า กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

            },

            success : function(data){
            setTimeout(function() {
                if (data.code == "200"){
                    swal("ซื้อสินค้า สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
                    setTimeout(function(){ window.location.reload();}, 2000);
                } else {
                    swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
                }
            }, 2000);
            }

      });

    }
  });     

}

</script>