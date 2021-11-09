      <!-- Web Config -->
      <div class="card mt-4 shadow-dark radius-border hyper-bg-white ml-auto mr-auto">
        <div class="card-body">
          <h4 class="mt-0 mb-4 text-center">ตั้งค่าเว็บไซต์</h4>

          <div class="row no-gutters">

          <div class="col-12 col-lg-5">
          <form method="POST" enctype="multipart/form-data">
          <?php
          $sql_select_web = "SELECT * FROM web_config WHERE con_id = 1";
          $query_web = $hyper->connect->query($sql_select_web);
          $web = mysqli_fetch_array($query_web);
          ?>
          <!-- Card Example -->
          <div class="media m-auto">
            <img id="gamelogoimgnew" src="assets/img/<?= $web['image']; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;" height="70px;">
            <div class="media-body text-center text-md-left">
              <img id="gamelogoresimgnew" src="assets/img/<?= $web['image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;" height="70px;">
              <h4 class="mt-0 mb-1" id="gamenamenew"><?= $web['name']; ?></h4>
              <font class="text-muted">แนะนำขนาด 150 x 150 Pixel</font>
            </div>
          </div>
          <!-- End Card Example -->

          <input type="file" style="display:none;" id="logo" onchange="gamelogoURL(this,'new');" accept=".jpg,.png"/>
          <button onclick="uploadgamelogo('')" type="button" class="btn btn-sm hyper-btn-info w-100 mt-3"><i class="fal fa-image mr-1"></i>เปลี่ยนรูปภาพ</button>

          <div class="input-group input-group-sm mb-3 mt-3">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark">ชื่อเว็บไซต์</span>
            </div>
            <input id="name" value="<?= $web['name']; ?>" type="text" onkeyup="txtgamepreview(this,'new')" maxlength="32" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อเว็บไซต์" required>
          </div>

            <div class="input-group input-group-sm mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text hyper-bg-dark border-dark">Facebook</span>
              </div>
              <input id="facebook" value="<?= $web['facebook']; ?>" type="text" class="form-control form-control-sm hyper-form-control" placeholder="Facebook" required>
            </div>
  

          <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text hyper-bg-dark border-dark" for="inputGroupSelect01">สถานะเว็บไซต์</label>
            </div>
            <select id="open" class="custom-select hyper-form-control" id="inputGroupSelect01">
              <option <?php if($web['opened'] == 1){echo 'selected';} ?> value="1">เปิดให้บริการ</option>
              <option <?php if($web['opened'] == 999){echo 'selected';} ?> value="999">ปิดปรับปรุงชั่วคราว</option>
            </select>
          </div>

          <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
            </div>
            <textarea id="detail" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"><?= $web['detail']; ?></textarea>
          </div>

          <button type="submit" id="updatedata<?= $web['con_id']; ?>" class="d-none"></button>

          <button onclick="updatedata('<?= $web['con_id']; ?>')" class="btn btn-sm hyper-btn-notoutline-success my-2 my-sm-0 mr-2 w-100" type="button"><i class="fal fa-check-circle mr-1"></i> อัพเดทข้อมูล</button>
          </form>
          </div>

        <div class="col-12 col-lg-7 pl-lg-4 pt-3">
          
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
                <div class="carousel-caption d-none d-md-block pb-0">
                    <button type="button" onclick="DelImage(this)" value="<?= $slide_image['slide_id'] ?>" class="btn btn-sm hyper-btn-notoutline-danger w-100 mt-2"><i class="fal fa-image mr-1"></i>ลบรูปภาพ</button>
                </div>
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
            
        <form method="POST" id="addbannerimg" enctype="multipart/form-data">
            <div class="ml-auto mr-auto mb-3 text-center mt-3">
              <img id="bannerimgnew" src="assets/img/slide/bannerani2.png" class="img-fluid" style="height: 100px;"></br>
              <font class="text-muted">แนะนำขนาด 1920 x 700 Pixel</font></br>
              <input type="hidden" value="1" name="bannerpass" />
              <input type="file" style="display:none;" id="imgbannernew" name="imgbannernew" onchange="bannerURL(this,'new');" accept=".jpg,.png"/>
            </div>
            <button type="submit" id="submitdatanew" class="d-none"></button>
        </form>
        
        <div class="row no-gutters ml-auto mr-auto pl-lg-4">
            <button onclick="uploadbanner('new') "class="btn col-12 mb-2 mb-md-0 col-md-5 mr-2 btn-sm hyper-btn-info w-100" type="button"><i class="fal fa-images mr-1"></i>เพิ่มรูปภาพ</button>
            <button onclick="submitdata('new')" class="btn col-12 col-md-6 btn-sm hyper-btn-notoutline-success w-100" type="submit"><i class="fal fa-check-circle mr-1"></i> อัพโหลดรูปภาพ</button>
        </div>

        </div>

        </div>

        </div>
      </div>
      <!-- End Web Config -->
      <script>
        function gamelogoURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              $('#gamelogoimg'+id).attr('src', e.target.result);
              $('#gamelogoresimg'+id).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
            
          }
        }

        function txtgamepreview(input,id) {
          if(input.value){
            var text = input.value;
          }else{
            var text = "GAMENAME";
          }
          $("#gamename"+id).html(text);
        }

        function uploadgamelogo(id) {
          $("#logo"+id).click();
        }

        function submitdata(id) {
          $("#submitdata"+id).click();
        }

        function bannerURL(input,id) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('#bannerimg'+id).attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
          
        }
        } 

        function uploadbanner(id) {
          $("#imgbanner"+id).click();
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
                url: "plugin/del_slide_image.php",
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

        /* Add bannerimg script */
        $("#addbannerimg").submit(function(additem){
        additem.preventDefault();

        $.ajax({

        type: "POST",
        url: "plugin/add_new_slide.php",
        data: new FormData(this),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function() {
          swal("กำลังเพิ่มรูปภาพ กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

        },

        success : function(data){
          setTimeout(function() {
            if (data.code == "200"){
              swal("เพิ่มรูปภาพ สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
              setTimeout(function(){ window.location.reload();}, 2000);
            } else {
              swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
            }
          }, 2000);
        }

        });

        });


        /** Update Config */
        function updatedata(id) {

        $("#updatedata" + id).submit();

        $("#updatedata" + id).submit(function(updategame){
          updategame.preventDefault();

          swal({
          title: 'ต้องการอัพเดทเว็บไซต์',
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
              var imagefile = $('#logo')[0].files[0];
              var name = $('#name').val();
              var facebook = $('#facebook').val();
              var open = $('#open').val();
              var detail = $('#detail').val();

              updatedata.append('img',imagefile);
              updatedata.append('name',name);
              updatedata.append('facebook',facebook);
              updatedata.append('open',open);
              updatedata.append('detail',detail);

              $.ajax({

              type: "POST",
              url: "plugin/edit_web.php",
              dataType: "json",
              data: updatedata,
              cache: false,
              contentType: false,
              processData: false,

              beforeSend: function() {
                swal("กำลังอัพเดทเว็บไซต์ กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

              },

              success : function(data){
                setTimeout(function() {
                  if (data.code == "200"){
                    swal("อัพเดทเว็บไซต์ สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
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

      </script>