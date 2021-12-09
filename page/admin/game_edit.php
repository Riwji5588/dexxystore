      <!-- Game Type -->

      <h3 class="text-center mt-4 mb-4" style="color: white;">--- สินค้าทั้งหมดในระบบ ---</h3>
      <center><button class="btn hyper-btn-info my-2 my-sm-0 w-100" type="button" data-toggle="modal" data-target="#addgamemodal"><i class="fal fa-plus-square mr-1"></i> เพิ่มสินค้าใหม่เข้าระบบ</button></center>

      <!-- Add Game Modal -->
      <div class="modal fade" id="addgamemodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 radius-border-2 hyper-bg-white">
            <div class="modal-header hyper-bg-dark">
              <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> เพิ่มสินค้าใหม่เข้าระบบ</h6>
            </div>
            <div class="modal-body text-center">

              <!-- Card Example -->
              <div class="media m-auto">
                <img id="gamelogoimgnew" src="assets/img/logoani_236x236.jpg" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;">
                <div class="media-body text-center text-md-left">
                  <img id="gamelogoresimgnew" src="assets/img/logoani_236x236.jpg" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;">
                  <h4 class="mt-0 mb-1" id="gamenamenew">ชื่อสินค้า</h4>
                  <font class="text-muted">แนะนำขนาด 120 x 120 Pixel</font>
                </div>
              </div>
              <!-- End Card Example -->

              <form id="addnewgame" method="POST" enctype="multipart/form-data">

                <div class="input-group mb-2 mt-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-gamepad-alt"></i></span>
                  </div>
                  <input id="nametxtgamenew" name="nametxtgamenew" onkeyup="txtgamepreview(this,'new')" maxlength="32" type="text" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อเกมที่ต้องการเพิ่ม" required autocomplete="off">
                </div>
                <input type="file" style="display:none;" id="imggamelogonew" name="imggamelogonew" onchange="gamelogoURL(this,'new');" accept=".jpg,.png,.gif," />
                <button id="uploadimggamelogo" onclick="uploadgamelogo('new')" type="button" class="btn btn-sm hyper-btn-info w-100"><i class="fal fa-image mr-1"></i>เพิ่มรูปภาพ</button>
                <button type="submit" id="submitdatanew" class="d-none"></button>
              </form>

            </div>
            <div class="modal-footer p-2 border-0">
              <button type="button" onclick="submitdata('new')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>เพิ่มเกม</button>
              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Add Game Modal -->

      <!-- Card -->
      <div class="row no-gutters mt-3">

        <?php

        $sql_select_game = "SELECT * FROM game_type ORDER BY game_id DESC";
        $query_game = $hyper->connect->query($sql_select_game);
        $total_game_row = mysqli_num_rows($query_game);
        $game = mysqli_fetch_array($query_game);

        if ($total_game_row <= 0) {
        ?>
          <h4 class="text-center w-100 mt-4">ไม่มีข้อมูลในขณะนี้</h4>
          <?php
        } else {
          do {
            $gid = $game['game_id'];
            $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE game_id = $gid AND selled = 0";
            $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();
          ?>
            <div class="col-6 col-lg-4 p-2">
              <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-2 h-100 hyper-card">
                <div class="media mb-2">
                  <img src="assets/img/game/<?= $game['game_image']; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;">
                  <div class="media-body text-center text-md-left">
                    <img src="assets/img/game/<?= $game['game_image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;">
                    <h4 class="mt-0 mb-1"><?= $game['game_name']; ?></h4>
                    <font class="text-muted"><?= number_format($ready_selled_row['totaldata'], 0); ?> ไอดี</font>
                  </div>
                </div>
                <button class="btn btn-sm hyper-btn-info mt-3" type="button" data-toggle="modal" data-target="#editgamemodal<?= $game['game_id']; ?>"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
                <button class="btn btn-sm hyper-btn-notoutline-danger mt-2" onclick="DelGame(this)" value="<?= $game['game_id']; ?>" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>
              </div>
            </div>

            <!-- Card Game Edit Modal -->
            <div class="modal fade" id="editgamemodal<?= $game['game_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                  <div class="modal-header hyper-bg-dark">
                    <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> อัพเดท</h6>
                  </div>
                  <div class="modal-body text-center">

                    <!-- Card Example -->
                    <div class="media m-auto">
                      <img id="gamelogoimg<?= $game['game_id']; ?>" src="assets/img/game/<?= $game['game_image']; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;">
                      <div class="media-body text-center text-md-left">
                        <img id="gamelogoresimg<?= $game['game_id']; ?>" src="assets/img/game/<?= $game['game_image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;">
                        <h4 class="mt-0 mb-1" id="gamename<?= $game['game_id']; ?>"><?= $game['game_name']; ?></h4>
                        <font class="text-muted">แนะนำขนาด 120 x 120 Pixel</font>
                      </div>
                    </div>
                    <!-- End Card Example -->

                    <form id="updategame<?= $game['game_id']; ?>" method="POST" enctype="multipart/form-data">

                      <div class="input-group mb-2 mt-4">
                        <div class="input-group-prepend">
                          <span class="input-group-text hyper-bg-dark border-dark"><i class="fal fa-gamepad-alt"></i></span>
                        </div>
                        <input id="nametxtgame<?= $game['game_id']; ?>" onkeyup="txtgamepreview(this,'<?= $game['game_id']; ?>')" maxlength="32" type="text" value="<?= $game['game_name']; ?>" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อเกม" required autocomplete="off">
                      </div>
                      <input type="file" style="display:none;" id="imggamelogo<?= $game['game_id']; ?>" name="imggamelogo<?= $game['game_id']; ?>" onchange="gamelogoURL(this,'<?= $game['game_id']; ?>');" accept=".jpg,.png,.gif," />
                      <button id="uploadimggamelogo" onclick="uploadgamelogo('<?= $game['game_id']; ?>')" type="button" class="btn btn-sm hyper-btn-info w-100"><i class="fal fa-image mr-1"></i>เปลี่ยนรูปภาพ</button>
                      <button type="submit" id="updatedata<?= $game['game_id']; ?>" class="d-none"></button>
                    </form>

                  </div>
                  <div class="modal-footer p-2 border-0">
                    <button type="button" onclick="updatedata('<?= $game['game_id']; ?>')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>อัพเดท</button>
                    <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Card Game Edit Modal -->

        <?php } while ($game = mysqli_fetch_array($query_game));
        } ?>

      </div>
      <!-- End Card -->

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
          $("#imggamelogo" + id).click();
        }

        function submitdata(id) {
          $("#submitdata" + id).click();
        }
      </script>

      <script>
        /* Additem script */
        $("#addnewgame").submit(function(additem) {
          additem.preventDefault();

          $.ajax({

            type: "POST",
            url: "plugin/add_new_game.php",
            data: new FormData(this),
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {
              swal("กำลังเพิ่มเกม กรุณารอสักครู่...", {
                button: false,
                closeOnClickOutside: false,
                timer: 500,
              });

            },

            success: function(data) {
              setTimeout(() => {
                if (data.code == "200") {
                  swal("เพิ่มเกม สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
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

        });

        /** Delete Game */
        function DelGame(id) {
          var id = id.value;
          swal({
              title: 'ต้องการลบเกมที่ ' + id,
              text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้ \n ข้อมูลของเกมนี้จะถูกลบทั้งหมด",
              icon: "warning",
              buttons: {
                confirm: {
                  text: 'ลบเกม',
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
                  url: "plugin/del_game.php",
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
                        swal("ลบเกม สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
                          button: false,
                          closeOnClickOutside: false,
                        });
                        setTimeout(function() {
                          window.location.reload();
                        }, 500);
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

        /** Update Game */
        function updatedata(id) {

          $("#updatedata" + id).submit();

          $("#updatedata" + id).submit(function(updategame) {
            updategame.preventDefault();

            swal({
                title: 'ต้องการอัพเดทเกมที่ ' + id,
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
                  var gid = id;
                  var imagefile = $('#imggamelogo' + id)[0].files[0];
                  var namegame = $('#nametxtgame' + id).val();
                  updatedata.append('gid', gid);
                  updatedata.append('img', imagefile);
                  updatedata.append('name', namegame);

                  $.ajax({

                    type: "POST",
                    url: "plugin/edit_game.php",
                    dataType: "json",
                    data: updatedata,
                    cache: false,
                    contentType: false,
                    processData: false,

                    beforeSend: function() {
                      swal("กำลังอัพเดทเกม กรุณารอสักครู่...", {
                        button: false,
                        closeOnClickOutside: false,
                        timer: 500,
                      });

                    },

                    success: function(data) {
                      setTimeout(() => {
                        if (data.code == "200") {
                          swal("อัพเดทเกม สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
                            button: false,
                            closeOnClickOutside: false,
                          });
                          setTimeout(function() {
                            window.location.reload();
                          }, 1000);
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
      <!-- End Game Type -->

      <style>
        body {
          background-color: #131315;
        }
      </style>