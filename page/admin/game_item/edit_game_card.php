      <?php

      if(empty($_GET['gameid'])){
          $id = -7;
      }else{
          $id = $_GET['gameid'];
      }

      $sql_select_game = "SELECT * FROM game_type WHERE game_id = '$id'";
      $query_game = $hyper->connect->query($sql_select_game);
      $total_game_row = mysqli_num_rows($query_game);
      $game = mysqli_fetch_array($query_game);

      if($total_game_row <= 0){

          if($data_user['role'] == '779'){
              include('page/admin/game_item/game_select.php');
            }else{
              include('page/welcome.php'); 
            }

      }else{
      ?>
      <!-- Edit Card Shop -->
      <h3 class="text-center mt-4 mb-4">--- การ์ดแสดงสินค้า ---</br><b><?= $game['game_name']; ?></b></h3>
      <center><button class="btn hyper-btn-info my-2 my-sm-0 w-100" type="button" data-toggle="modal" data-target="#addgamecardmodal"><i class="fal fa-plus-square mr-1"></i> เพิ่มการ์ดแสดงสินค้าใหม่เข้าระบบ</button></center>

      <!-- Add Game Modal -->
      <div class="modal fade" id="addgamecardmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 radius-border-2 hyper-bg-white">
            <div class="modal-header hyper-bg-dark">
              <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> เพิ่มการ์ดแสดงสินค้าใหม่เข้าระบบ</h6>
            </div>
            <div class="modal-body text-center">

        <!-- CARD -->
              <form id="addgamecard" method="POST" enctype="multipart/form-data">

                    <div class="ml-auto mr-auto mb-3 text-center">
                      <img id="gamecardimgnew" src="assets/img/item/card.jpg" class="img-fluid" style="height: 170px;"></br>
                      <font class="text-muted">แนะนำขนาด 1920 x 1080 Pixel</font></br>
                      <input type="file" style="display:none;" id="imggamecardnew" name="imggamecardnew" onchange="gamecardURL(this,'new');" accept=".jpg,.png"/>
                      <button  onclick="uploadcardgame('new')"class="btn btn-sm hyper-btn-info mb-2 mb-md-0 mr-0 mr-md-2 w-100" type="button"><i class="fal fa-images mr-1"></i>เพิ่มรูปภาพ</button>
                    </div>

                    <div class="input-group input-group-sm mb-3 mt-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text hyper-bg-dark border-dark">ชื่อการ์ดแสดงสินค้า</span>
                      </div>
                      <input id="title" name="title" type="text" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อการ์ดแสดงสินค้า" required autocomplete="off">
                    </div>

                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text hyper-bg-dark border-dark">ราคาสินค้า</span>
                      </div>
                      <input id="price" name="price" type="number" class="form-control form-control-sm hyper-form-control" placeholder="ราคาสินค้า" required autocomplete="off">
                    </div>

                    <input type="hidden" id="gameid" name="gameid" value="<?= $game['game_id']; ?>"/>

                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
                      </div>
                      <textarea id="detail" name="detail" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"></textarea>
                    </div>
                    <button type="submit" id="submitdatanew" class="d-none"></button>
              </form>
        <!-- End CARD -->

            </div>
            <div class="modal-footer p-2 border-0">
              <button type="button" onclick="submitdata('new')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>เพิ่มการ์ดแสดงสินค้า</button>
              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Add Game Modal -->

      <div class="row no-gutters mt-4">

      <?php

        $perpage = 9;

        $sql_select_game = "SELECT * FROM game_card WHERE game_id = '$id'";
        $query_game = $hyper->connect->query($sql_select_game);
        $total_game_row = mysqli_num_rows($query_game);
        $total_page = ceil($total_game_row / $perpage);
        $limit_page = $total_page;

        if(empty($_GET['page'])){
          $_GET['page'] = '1';
          $page = 1;
        }

        if (isset($_GET['page'])) {
          $page = $_GET['page'];
        } else {
          $page = 1;
        }

        if($_GET['page'] <= 0 ||$_GET['page'] > $total_page || !filter_var($_GET['page'], FILTER_VALIDATE_INT)){$_GET['page'] = '1';$page = 1;}

        $start = ($page - 1) * $perpage;

        $sql_select_game_page = "SELECT * FROM game_card WHERE game_id = '$id' LIMIT {$start} , {$perpage}";
        $query_game_page = $hyper->connect->query($sql_select_game_page);

        if($total_game_row <= 0){
      ?>
      <h4 class="text-center w-100 mt-4">ไม่มีข้อมูลในขณะนี้</h4>
      <?php }else{ 
          $card = mysqli_fetch_array($query_game_page);
        do{ 
          
          $imgid = $card['card_id'];
          $sql_select_card_image = "SELECT * FROM card_image WHERE card_id = '$imgid' ORDER BY image_id ASC LIMIT 1";
          $query_card_image = $hyper->connect->query($sql_select_card_image);
          $card_image = mysqli_fetch_array($query_card_image);


          $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE card_id = $imgid AND selled = 0";
          $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();
      ?>
        <!-- CARD -->

        <div class="col-12 col-md-6 col-lg-4 p-2">
          <div class="card shadow-dark radius-border-6 hyper-bg-white border-0 h-100">
            <img src="assets/img/item/<?= $card_image['image_name']; ?>" class="card-img-top img-fluid" style="border-top-left-radius: 0.6rem !important;border-top-right-radius: 0.6rem !important;">
            <div class="card-body">
              <h5 class="mt-0 mb-2" ><?= $card['card_title'] ?></h5>
              <h5 class="mt-0">ราคา <?= number_format($card['card_price'],0) ?> Points</h5>
              <h6 class="mt-0 text-muted">เหลือจำนวน <?= number_format($ready_selled_row['totaldata'],0); ?> ไอดี</h6>
              <div class="row no-gutters ml-auto mr-auto mt-3">
                <button class="btn btn-sm hyper-btn-info col-12 col-md-5 mb-2 mb-md-0 mr-0 mr-md-2" data-toggle="modal" data-target="#editgamecardmodal<?= $card['card_id'] ?>"><i class="fal fa-edit mr-1"></i>แก้ไข</button>
                <button onclick="DelCard(this)" value="<?= $card['card_id'] ?>" class="btn btn-sm hyper-btn-notoutline-danger col-12 col-md-4"><i class="fal fa-trash-alt mr-1"></i>ลบ</button>
              </div>
            </div>
          </div>
        </div>

      <!-- Edit Game Modal -->
      <div class="modal fade" id="editgamecardmodal<?= $card['card_id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 radius-border-2 hyper-bg-white">
            <div class="modal-header hyper-bg-dark">
              <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> แก้ไขการ์ดแสดงสินค้า</h6>
            </div>
            <div class="modal-body text-center">

          <!-- CARD -->
          <form method="POST" enctype="multipart/form-data">
                    
                    <!-- Image Slide -->
                    <div id="slideimg<?= $card['card_id'] ?>" class="card-img-top img-fluid carousel slide " data-ride="carousel">
                      <div class="carousel-inner">
  
                      <?php

                      $sql_select_edit_card_image = "SELECT * FROM card_image WHERE card_id = '$imgid' ORDER BY image_id ASC";
                      $query_edit_card_image = $hyper->connect->query($sql_select_edit_card_image);
                      $edit_card_image = mysqli_fetch_array($query_edit_card_image);
                      $active = 1;
                      do{

                      ?>
                        <div class="carousel-item <?php if($active == 1){echo 'active'; } ?>" data-interval="60000">
                          <img id="gamecardimg1" src="assets/img/item/<?= $edit_card_image['image_name']; ?>" class="d-block w-100">
                          <div class="carousel-caption d-none d-md-block">
                            <button type="button" value="<?= $edit_card_image['image_id']; ?>" onclick="DelImage(this)" class="btn btn-sm hyper-btn-notoutline-danger w-100 mt-2"><i class="fal fa-image mr-1"></i>ลบรูปภาพ</button>
                          </div>
                        </div>
                      <?php $active = 0; }while ($edit_card_image = mysqli_fetch_array($query_edit_card_image)); ?>
  
                      </div>
          
                      <a class="carousel-control-prev" href="#slideimg<?= $card['card_id'] ?>" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#slideimg<?= $card['card_id'] ?>" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                      <!-- End Image Slide -->
          
                  </div>

                      <div class="ml-auto mr-auto mb-3 text-center mt-3">
                        <img id="gamecardimg<?= $card['card_id'] ?>" src="assets/img/item/card.jpg" class="img-fluid" style="height: 170px;"></br>
                        <font class="text-muted">แนะนำขนาด 1920 x 1080 Pixel</font></br>
                        <input type="file" style="display:none;" id="imggamecard<?= $card['card_id'] ?>" name="imggamecard<?= $card['card_id'] ?>" onchange="gamecardURL(this,'<?= $card['card_id'] ?>');" accept=".jpg,.png"/>
                        <button  onclick="uploadcardgame('<?= $card['card_id'] ?>')"class="btn btn-sm hyper-btn-info mb-2 mb-md-0 mr-0 mr-md-2 w-100" type="button"><i class="fal fa-images mr-1"></i>เพิ่มรูปภาพ</button>
                      </div>

                      <div class="input-group input-group-sm mb-3 mt-4">
                        <div class="input-group-prepend">
                          <span class="input-group-text hyper-bg-dark border-dark">ชื่อการ์ดแสดงสินค้า</span>
                        </div>
                        <input id="title<?= $card['card_id'] ?>" type="text" value="<?= $card['card_title'] ?>" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อการ์ดแสดงสินค้า" required autocomplete="off">
                      </div>

                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text hyper-bg-dark border-dark">ราคาสินค้า</span>
                        </div>
                        <input id="price<?= $card['card_id'] ?>" type="number" value="<?= $card['card_price'] ?>" class="form-control form-control-sm hyper-form-control" placeholder="ราคาสินค้า" required autocomplete="off">
                      </div>

                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
                        </div>
                        <textarea id="detail<?= $card['card_id'] ?>" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"><?= $card['card_detail'] ?></textarea>
                      </div>

                      <input type="hidden" id="gameid<?= $card['card_id'] ?>" name="gameid<?= $card['card_id'] ?>" value="<?= $card['game_id']; ?>"/>
                      <button type="submit" id="updatedata<?= $card['card_id'] ?>" class="d-none"></button>

          </form>
          <!-- End CARD -->

            </div>
            <div class="modal-footer p-2 border-0">
              <button type="button" onclick="updatedata('<?= $card['card_id'] ?>')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>แก้ไขการ์ดแสดงสินค้า</button>
              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Edit Game Modal -->


        <!-- END CARD -->
      <?php }while ($card = mysqli_fetch_array($query_game_page));} ?>

      </div>

      <?php 
        if($total_page > 1){

          $backpage = $_GET['page']-1;
          $nextpage = $_GET['page']+1;

      ?>
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center mb-0 mt-3">
            <li class="page-item <?php if($_GET['page'] <= 1){ echo 'disabled';}?>">
              <a class="page-link" href="gamecard&gameid=<?= $game['game_id']; ?>&page=<?= $backpage; ?>" tabindex="-1" aria-disabled="true">หน้าก่อนหน้า</a>
            </li>
            <?php for($i=1;$i<=$total_page;$i++){ ?>
            <li class="page-item"><a class="page-link <?php if($_GET['page'] == $i){ echo 'active';} ?>" href="gamecard&gameid=<?= $game['game_id']; ?>&page=<?= $i; ?>"><?= $i; ?></a></li>
            <?php } ?>
            <li class="page-item <?php if($_GET['page'] >= $total_page){ echo 'disabled';}?>">
              <a class="page-link" href="gamecard&gameid=<?= $game['game_id']; ?>&page=<?= $nextpage; ?>">หน้าถัดไป</a>
            </li>
          </ul>
        </nav>
        <!-- End Pagination -->
      <?php } ?>

      <!-- End Edit Card Shop -->

      <script>
      function gamecardURL(input,id) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('#gamecardimg'+id).attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
          
        }
      }

      function uploadcardgame(id) {
        $("#imggamecard"+id).click();
      }

      function submitdata(id) {
        $("#submitdata"+id).click();
      }
    </script>


    
    <script>
      /* Additem script */
      $("#addgamecard").submit(function(additem){
      additem.preventDefault();

      $.ajax({

      type: "POST",
      url: "plugin/add_new_card.php",
      data: new FormData(this),
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,

      beforeSend: function() {
        swal("กำลังเพิ่มการ์ดแสดงสินค้า กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

      },

      success : function(data){
        setTimeout(function() {
          if (data.code == "200"){
            swal("เพิ่มการ์ดแสดงสินค้า สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
            setTimeout(function(){ window.location.reload();}, 2000);
          } else {
            swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
          }
        }, 2000);
      }

      });

      });



    /** Update Card */
    function updatedata(id) {

    $("#updatedata" + id).submit();

    $("#updatedata" + id).submit(function(updategame){
      updategame.preventDefault();

      swal({
      title: 'ต้องการอัพเดทการ์ดที่ ' + id,
      text: "คุณต้องการอัพเดทข้อมูลใช่หรือไม่",
      icon: "info",
      buttons: {
        confirm : {text:'อัพเดท',className:'hyper-btn-notoutline-success'},
        cancel : 'ยกเลิก'
      },
      closeOnClickOutside:false,
      })
      .then((willDelete) => {
        if (willDelete) {

          var updatedata = new FormData();
          var cid = id;
          var imagefile = $('#imggamecard'+id)[0].files[0];
          var name = $('#title'+id).val();
          var price = $('#price'+id).val();
          var detail = $('#detail'+id).val();
          updatedata.append('cid',cid);
          updatedata.append('img',imagefile);
          updatedata.append('title',name);
          updatedata.append('price',price);
          updatedata.append('detail',detail);

          $.ajax({

          type: "POST",
          url: "plugin/edit_card.php",
          dataType: "json",
          data: updatedata,
          cache: false,
          contentType: false,
          processData: false,

          beforeSend: function() {
            swal("กำลังอัพเดทการ์ดแสดงสินค้า กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

          },

          success : function(data){
            setTimeout(function() {
              if (data.code == "200"){
                swal("อัพเดทการ์ดแสดงสินค้า สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
                setTimeout(function(){ window.location.reload();}, 2000);
              } else {
                swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
              }
            }, 2000);
          }

          });

        }
      });

    });
    }


  /** Delete Card Image */
  function DelImage(id){
    var  id = id.value;
    swal({
      title: 'ต้องการลบรูปภาพนี้',
      text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
      icon: "warning",
      buttons: {
        confirm : {text:'ลบรูปภาพ',className:'hyper-btn-notoutline-danger'},
        cancel : 'ยกเลิก'
      },
      closeOnClickOutside:false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({

          type: "POST",
          url: "plugin/del_card_image.php",
          dataType: "json",
          data: {id:id},

          beforeSend: function() {
          swal("กำลังลบข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

          },

          success : function(data){
          setTimeout(function() {
              if (data.code == "200"){
                  swal("ลบรูปภาพ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
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

    /** Delete Card */
    function DelCard(id){
    var  id = id.value;
    swal({
      title: 'ต้องการลบการ์ดนี้',
      text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
      icon: "warning",
      buttons: {
        confirm : {text:'ลบการ์ด',className:'hyper-btn-notoutline-danger'},
        cancel : 'ยกเลิก'
      },
      closeOnClickOutside:false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({

          type: "POST",
          url: "plugin/del_card.php",
          dataType: "json",
          data: {id:id},

          beforeSend: function() {
          swal("กำลังลบข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

          },

          success : function(data){
          setTimeout(function() {
              if (data.code == "200"){
                  swal("ลบการ์ด สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
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

    <?php } ?>