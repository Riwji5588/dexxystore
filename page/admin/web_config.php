<h3 class="text-center mt-2 mb-4" style="color: white;">--- ตั้งค่าเว็บไซต์ ---</h3>
<!-- Web Config -->
<div class="row">
  <div class="container justify-content-center" id="container">
    <div class="card mt-4 shadow-dark radius-border mx-2 es col-12 col-md-5">
      <div class="card-body">
      
        <div class="row no-gutters">

          <div class="col-12">
            <form method="POST" enctype="multipart/form-data">
              <?php
              $sql_select_web = "SELECT * FROM web_config WHERE con_id = 1";
              $query_web = $hyper->connect->query($sql_select_web);
              $web = mysqli_fetch_array($query_web);
              ?>
              <!-- Card Example -->
              <div class="media m-auto">
                <img id="gamelogoimgnew" src="assets/img/<?= $webimage; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;" height="70px;">
                <div class="media-body text-center text-md-left">
                  <img id="gamelogoresimgnew" src="assets/img/<?= $web['image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;" height="70px;">
                  <h4 class="mt-0 mb-1" id="gamenamenew"><?= $web['name']; ?></h4>
                  <font class="text-muted">แนะนำขนาด 150 x 150 Pixel</font>
                </div>
              </div>
              <!-- End Card Example -->

              <input type="file" style="display:none;" id="logo" onchange="gamelogoURL(this,'new');" accept=".jpg,.png,.gif" />
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
                  <option <?php if ($web['opened'] == 1) {
                            echo 'selected';
                          } ?> value="1">เปิดให้บริการ</option>
                  <option <?php if ($web['opened'] == 999) {
                            echo 'selected';
                          } ?> value="999">ปิดปรับปรุงชั่วคราว</option>
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
        </div>

      </div>
    </div>
    <div class="card mt-4 shadow-dark radius-border mx-2 es col-12 col-md-5">
      <div class="card-body">
        <div class="row no-gutters">

          <div class="col-12">
            <form method="POST" enctype="multipart/form-data">
              <?php
              $sql_select_web = "SELECT * FROM web_config WHERE con_id = 1";
              $query_web = $hyper->connect->query($sql_select_web);
              $web = mysqli_fetch_array($query_web);
              ?>

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
        </div>

      </div>
    </div>
  </div>
</div>


<!-- End Web Config -->
<script>
  function gamelogoURL(input, id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#gamelogoimg' + id).attr('src', e.target.result);
        $('#gamelogoresimg' + id).attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);

    }
  }

  function txtgamepreview(input, id) {
    if (input.value) {
      var text = input.value;
    } else {
      var text = "GAMENAME";
    }
    $("#gamename" + id).html(text);
  }

  function uploadgamelogo(id) {
    $("#logo" + id).click();
  }

  function submitdata(id) {
    $("#submitdata" + id).click();
  }

  /** Delete Card Image */
  function DelImage(id) {
    var id = id.value;
    swal({
        title: 'ต้องการลบรูปภาพนี้',
        text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
        icon: "warning",
        buttons: {
          confirm: {
            text: 'ลบรูปภาพ',
            className: 'hyper-btn-notoutline-danger'
          },
          cancel: 'ยกเลิก'
        },
        closeOnClickOutside: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({

            type: "POST",
            url: "plugin/del_slide_image.php",
            dataType: "json",
            data: {
              id: id
            },

            beforeSend: function() {
              swal("กำลังลบข้อมูล กรุณารอสักครู่...", {
                button: false,
                closeOnClickOutside: false,
                timer: 500,
              });

            },

            success: function(data) {
              setTimeout(() => {
                if (data.code == "200") {
                  swal("ลบรูปภาพ สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
                    button: false,
                    closeOnClickOutside: false,
                  });
                  setTimeout(function() {
                    window.location.reload();
                  }, 1500);
                } else {
                  swal(data.msg, "", "error", {
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

  /** Update Config */
  function updatedata(id) {

    $("#updatedata" + id).submit();

    $("#updatedata" + id).submit(function(updategame) {
      updategame.preventDefault();

      swal({
          title: 'ต้องการอัพเดทเว็บไซต์',
          text: "คุณต้องการอัพเดทข้อมูลใช่หรือไม่",
          icon: "info",
          buttons: {
            confirm: {
              text: 'อัพเดท',
              className: 'hyper-btn-notoutline-success'
            },
            cancel: 'ยกเลิก'
          },
          closeOnClickOutside: false,
        })
        .then((willDelete) => {
          if (willDelete) {

            var updatedata = new FormData();
            var imagefile = $('#logo')[0].files[0];
            var name = $('#name').val();
            var facebook = $('#facebook').val();
            var open = $('#open').val();
            var detail = $('#detail').val();

            updatedata.append('img', imagefile);
            updatedata.append('name', name);
            updatedata.append('facebook', facebook);
            updatedata.append('open', open);
            updatedata.append('detail', detail);

            $.ajax({

              type: "POST",
              url: "plugin/edit_web.php",
              dataType: "json",
              data: updatedata,
              cache: false,
              contentType: false,
              processData: false,

              beforeSend: function() {
                swal("กำลังอัพเดทเว็บไซต์ กรุณารอสักครู่...", {
                  button: false,
                  closeOnClickOutside: false,
                  timer: 500,
                });

              },

              success: function(data) {
                setTimeout(() => {
                  if (data.code == "200") {
                    swal("อัพเดทเว็บไซต์ สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
                      button: false,
                      closeOnClickOutside: false,
                    });
                    setTimeout(function() {
                      window.location.reload();
                    }, 2000);
                  } else {
                    swal(data.msg, "", "error", {
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

    });
  }
</script>

<style>
  #container {
    display: inline-flex;
  }

  @media screen and (max-width: 600px) {
    #container {
      display: block;
    }
  }

  body {
    background-color: #131315;
  }

  .es {
    background-color: #b8b8b8;
  }

  h4 {
    color: black;
  }
</style>