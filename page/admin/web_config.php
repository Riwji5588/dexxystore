<h3 class="text-center mt-2 mb-4" style="color: white;">--- ตั้งค่าเว็บไซต์ ---</h3>
<!-- Web Config -->
<div class="row ">
  <div class="container justify-content-center" id="container" align="center">
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
              <div class="input-group input-group-sm mb-3">
                <div class="custom-control custom-switch custom-switch-md w-100 justify-contant-center align-items-center" align="start">
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php if ($web['isenable'] == '1') {
                                                                                            echo "checked";
                                                                                          } ?> onchange="checkeds()">
                  <label class="custom-control-label pt-1" for="customSwitch1" style="position: absolute;">กำหนดเวลาเคลมครั้งแรก</label>
                </div>
              </div>
              <div id="timerange" class="input-group input-group-sm mb-3">
                <div class="btn btn-dark w-100" id="picker">
                  <i class="fa fa-calendar"></i> &nbsp;
                  <span id="time"></span>
                </div>
                <input id='start' type="hidden">
                <input id='end' type="hidden">
                <script>
                  let timerange = '<?= $web['timerange']; ?>';
                  let timerange_arr = timerange.split("-");
                  let start = parseInt(timerange_arr[0]);
                  let end = parseInt(timerange_arr[1]);

                  let start_hour = parseInt(start / 60) < 10 ? "0" + parseInt(start / 60) : parseInt(start / 60);
                  let start_min = (start - parseInt(start_hour) * 60) < 10 ? "0" + (start - parseInt(start_hour) * 60) : (start - parseInt(start_hour) * 60);
                  let start_time = start_hour + ":" + start_min;

                  let end_hour = parseInt(end / 60) < 10 ? "0" + parseInt(end / 60) : parseInt(end / 60);
                  let end_min = Math.abs(end - parseInt(end_hour) * 60) < 10 ? "0" + Math.abs(end - parseInt(end_hour) * 60) : Math.abs(end - parseInt(end_hour) * 60);
                  let end_time = end_hour + ":" + end_min;

                  $('#time').html(start_time + " น." + " - " + end_time + " น.");

                  $('#picker').daterangepicker({
                    timePicker: true,
                    datepicker: false,
                    timePicker24Hour: true,
                    startDate: start_time,
                    endDate: end_time,
                    locale: {
                      format: 'HH:mm น.'
                    }

                  }, function(start, end) {
                    $('#time').html(start.format('HH:mm น.') + ' - ' + end.format('HH:mm น.'));
                  });

                  function checkeds() {
                    if ($('#customSwitch1').is(':checked')) {
                      $('#timerange').show();
                    } else {
                      $('#timerange').hide();
                    }
                  }
                </script>
              </div>
              <button onclick="updatedata('<?= $web['con_id']; ?>')" class="btn btn-sm hyper-btn-notoutline-success my-2 my-sm-0 mr-2 w-100" type="button"><i class="fal fa-check-circle mr-1"></i> อัพเดทข้อมูล</button>
          </div>

        </div>
      </div>
    </div>
  </div>


  <!-- End Web Config -->
  <script>
    $(document).ready(function() {
      if ($('#customSwitch1').is(':checked')) {
        $('#timerange').show();
      } else {
        $('#timerange').hide();
      }
      
      $(".cancelBtn.btn.btn-sm.btn-default").addClass("text-dark")
      $(".calendar-table").remove()
    });

    function showResult() {
      let time = $('#time').text()
      let startTime = time.split('-')[0].split(' น.')[0];
      let endTime = time.split('-')[1].split(' น.')[0].trim();
      startTime = parseInt(startTime.split(':')[0] * 60) + parseInt(startTime.split(':')[1]);
      endTime = parseInt(endTime.split(':')[0] * 60) + parseInt(endTime.split(':')[1]);
      return startTime + '-' + endTime;
    }

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

              var isenable = $('#customSwitch1').is(':checked') ? 1 : 0;
              var timerage = showResult()

              updatedata.append('img', imagefile);
              updatedata.append('name', name);
              updatedata.append('facebook', facebook);
              updatedata.append('open', open);
              updatedata.append('detail', detail);
              updatedata.append('isenable', isenable);
              updatedata.append('timerange', timerage);

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
                      }, 600);
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
    /* for md */

    .custom-switch.custom-switch-md .custom-control-label {
      padding-left: 2rem;
      padding-bottom: 1.5rem;
    }

    .custom-switch.custom-switch-md .custom-control-label::before {
      height: 1.5rem;
      width: calc(2rem + 0.75rem);
      border-radius: 3rem;
    }

    .custom-switch.custom-switch-md .custom-control-label::after {
      width: calc(1.5rem - 4px);
      height: calc(1.5rem - 4px);
      border-radius: calc(2rem - (1.5rem / 2));
    }

    .custom-switch.custom-switch-md .custom-control-input:checked~.custom-control-label::after {
      transform: translateX(calc(1.5rem - 0.25rem));
    }

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


    #container>div:nth-child(2)>div>div>div>form>div>div>div>div>div>div:nth-child(3) {
      background-color: #3C116E !important;
    }

    .jsr_slider:focus::before {
      background: #3C116E !important;
    }

    .jsr_slider::before {
      content: '';
      width: 15px;
      height: 15px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #3C116E;
      border-radius: 50%;
    }
  </style>