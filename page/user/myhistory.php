<!-- MyID -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="table-responsive mt-5">
  <table id="datatable" class="table  text-center w-100">
    <thead class="hyper-bg-dark">
      <tr>
        <th scope="col" style="width:120px;">เลขที่ข้อมูล</th>
        <th scope="col">สินค้า</th>
        <th scope="col">บัญชีผู้ใช้</th>
        <th scope="col">วันที่-เวลา ที่ซื้อ</th>
        <th scope="col">สถานะ</th>
        <th scope="col">เมนู</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $sql_select_selled = "SELECT * FROM data_selled WHERE ac_id = $ac_id";
      $query_selled = $hyper->connect->query($sql_select_selled);
      $total_selled_row = mysqli_num_rows($query_selled);

      if ($total_selled_row > 0) {
        $selled = mysqli_fetch_array($query_selled);
        do {

          $selled_data_id = $selled['data_id'];

          $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$selled_data_id'";
          $query_selled_data = $hyper->connect->query($sql_select_selled_data);
          $selled_data = mysqli_fetch_array($query_selled_data);

          $selled_game_id = $selled_data['game_id'];

          $sql_select_selled_game = "SELECT * FROM game_type WHERE game_id = '$selled_game_id'";
          $query_selled_game = $hyper->connect->query($sql_select_selled_game);
          $selled_game = mysqli_fetch_array($query_selled_game);
      ?>
          <tr>
            <td><?= $selled['selled_id']; ?></td>
            <td><?php if ($selled_game['game_name'] == null) {
                  echo 'unknow';
                } else {
                  echo $selled_game['game_name'];
                } ?></td>
            <td><?= $selled_data['username']; ?></td>
            <td><?= DateThai($selled['selled_date']); ?></td>
            <td>
              <?php
              if ($selled['claim'] == 1) {
                echo '<span class="text-success">เคลมสำเร็จ</span>';
              } else if ($selled['claim'] == 2) {
                echo '<span class="text-warning">รอดำเนินการ</span>';
              } else if ($selled['claim'] == 3) {
                echo '<span class="text-danger">ถูกปฏิเสธ</span>';
              } else if ((int)date_diff(date_create(date("Y-m-d H:i:s")), date_create($selled['exp_date']))->format('%a') > 0) {
                echo '<span class="text-primary">ยังไม่หมดอายุ</span>';
              } else {
                echo '<span class="text-danger">หมดอายุ</span>';
              }
              ?>
            </td>
            <td>
              <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#datamodal<?= $selled['selled_id']; ?>">แสดงไอดี</button>
              <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#datamodal1<?= $selled['selled_id']; ?>" style="color: ;"><i class="fas fa-exclamation-triangle"></i> แจ้งปัญหา</button>

              <!-- Data Modal -->
              <div class="modal fade" id="datamodal<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                    <div class="modal-header hyper-bg-dark">
                      <h5 class="modal-title"> ไอดีของคุณ</h5>
                      <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-left">
                      <div class="row" style="padding: 5px 2px 0px 2px;">
                        <div class="col-2">
                          <span>ชื่อผู้ใช้งาน</span>
                        </div>
                        <div class="col-8">
                          <input type="text" id="username<?= $selled['selled_id']; ?>1" value="<?= $selled_data['username']; ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                          <button id="username<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button>
                          <!-- 'username<?= $selled['selled_id']; ?>' -->
                        </div>
                      </div>
                      <div class="row" style="padding: 5px 2px 0px 2px;">
                        <div class="col-2">
                          <span>รหัสผ่าน</span>
                        </div>
                        <div class="col-8">
                          <input type="text" id="password<?= $selled['selled_id']; ?>1" value="<?= base64_decode($selled_data['password']); ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                          <button id="password<?= $selled['selled_id']; ?>" class="btn btn-dark btn-sm" onclick="copy(this)"> คัดลอก </button>
                        </div>
                      </div>
                      <div class="row" style="padding: 5px 2px 0px 2px;">
                        <div class="col-2">
                          <span>จอ</span>
                        </div>
                        <div class="col-8">
                          <input type="text" value="<?= $selled_data['display']; ?>" readonly style="background-color: #fff;border-radius: 0px;border: 0px">
                        </div>
                      </div>
                      <div class="row" style="padding: 5px 2px 0px 2px;">
                        <div class="col-2">
                          <span>วันหมดอายุ</span>
                        </div>
                        <div class="col-8">
                          <p><?= DateThai($selled['exp_date']) ?></p>
                        </div>
                      </div>

                      <div class="modal-footer p-2 border-0">
                        <button type="button" class="btn btn-secondary  btn-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- End Data Modal -->

              <!-- Claim Modal -->
              <div class="modal fade" id="datamodal1<?= $selled['selled_id']; ?>">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #ffc107;">
                      <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> แจ้งปัญหาในการใช้งาน</h5>
                      <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-left" style="width: auto;">
                      <!-- tab control -->
                      <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#claim<?= $selled['selled_id']; ?>">เคลมสินค้า</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#other<?= $selled['selled_id']; ?>">สอบถามปัญหาต่างๆ</a>
                        </li>
                      </ul>
                      <!--conternt !-->
                      <div class="tab-content">
                        <!-- claim tab -->
                        <div id="claim<?= $selled['selled_id']; ?>" class="tab-pane active">
                          <br>
                          <div class="form-group">
                            <p for="detail<?= $selled['selled_id']; ?>">ตัวอย่างสาเหตุปัญหา</p>
                            <ol>
                              <li>รหัสผ่านไม่ถูกต้อง / ไม่สามารถเข้าไอดีได้</li>
                              <li>ไอดีหมดอายุ ขึ้นให้จ่าย / Update Payment</li>
                              <li>จอซ้อน / หน้าจอเต็ม</li>
                            </ol>
                            <textarea id="detail<?= $selled['selled_id']; ?>" class="form-control" style="width: 88%;min-height: 100px" autofocus></textarea>
                            <span style="color: red;">
                              <b>*หมายเหตุ </b>
                              <ol>
                                <li>หากเคลม<u>ครั้งแรก</u> จะได้รับไอดีใหม่ทันที</li>
                                <li>หากเคลม<u>ครั้งที่ 2 ขึ้นไป</u> จะต้องรอแอดมินมาอนุมัติ</li>
                                <li>หาก<u>ถูกปฏิเสธ</u> เหตุผลในการส่งเคลมไม่เป็นจริง หรือเป็นเท็จ แต่ถ้าหากต้องการส่งเคลมอีกครั้งก็สามารถส่งได้</li>
                              </ol>
                            </span>
                          </div>
                          <div class="modal-footer p-2 border-0 form-group">
                            <button type="button" class="btn btn-success" onclick="claim(<?= $selled['selled_id']; ?>)"><i class="fad fa-times-circle mr-1"></i>ส่งเคลม</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                          </div>
                        </div>
                        <!-- other tab -->
                        <div id="other<?= $selled['selled_id']; ?>" class="tab-pane">
                          <br>
                          <div class="form-group">
                            <table style="width: 100%;">
                              <tr>
                                <td>
                                  <span>วิธีเปลี่ยนซับไทยและเสียงพากย์ไทย</span>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#sub">คลิก</button>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span>วิธีเปลี่ยนความชัดของวิดีโอ</span>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#video">คลิก</button>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <div class="form-group" align="center">
                            <p>สอบถามเพิ่มเติม โดยตรงกับทางร้าน</p>
                            <img src="assets/img/line.jpg" style="width:auto; max-width: 130px;">
                          </div>
                          <div class="modal-footer p-2 border-0 form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"><i class="fad fa-times-circle mr-1"></i>ปิด</button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <!-- End Data Modal -->

            </td>


          </tr>
      <?php } while ($selled = mysqli_fetch_array($query_selled));
      } ?>


    </tbody>
  </table>
</div>
<!-- End MyID -->

<!-- sub modal -->
<div class="modal fade" id="sub" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <br>
          <div class="col-12">
            <div id="insub" class="carousel slide" data-ride="carousel" style="padding: 10px;">
              <ol class="carousel-indicators">
                <li data-target="#insub" data-slide-to="0" class="active"></li>
                <li data-target="#insub" data-slide-to="1"></li>
                <li data-target="#insub" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="assets/img/line.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="assets/img/line.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="assets/img/line.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-target="#insub" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-target="#insub" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </button>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<!-- video modal -->
<div class="modal fade" id="video" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <br>
          <div class="col-12">
            <div id="invideo" class="carousel slide" data-ride="carousel" style="padding: 10px;">
              <ol class="carousel-indicators">
                <li data-target="#invideo" data-slide-to="0" class="active"></li>
                <li data-target="#invideo" data-slide-to="1"></li>
                <li data-target="#invideo" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="assets/img/logo.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="assets/img/logo.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="assets/img/logo.jpg" class="d-block w-100" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-target="#invideo" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-target="#invideo" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </button>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

<script>
  function copy(input) {
    let id = input.id + '1';
    var copyText = document.getElementById(id);
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    input.innerHTML = "คัดลอกแล้ว";
    input.className = "btn btn-success btn-sm";
    setTimeout(function() {
      input.innerHTML = "คัดลอก";
      input.className = "btn btn-dark btn-sm";
    }, 2000);
  }


  function claim(id) {
    var checkdetail = document.getElementById("detail" + id).value;
    // check detail if empty
    detail = checkdetail.substring(0, 2) == "  " || checkdetail.substring(0, 1) == " " || checkdetail == "" ? "" : checkdetail;
    $.ajax({

      type: "POST",
      url: "plugin/claim.php",
      dataType: "json",
      data: {
        id: id,
        detail: detail,
        type: 1
      },

      beforeSend: function() {
        swal("กำลังส่งเคลม กรุณารอสักครู่...", {
          button: false,
          closeOnClickOutside: false,
          timer: 1900,
        });

      },

      success: function(data) {
        setTimeout(function() {
          if (data.code == "200") {
            swal(data.msg, '\n', "success", {
              button: false,
              closeOnClickOutside: false,
            });
            setTimeout(function() {
              window.location.reload();
            }, 2000);
          } else {
            swal(data.msg, "\n", "error", {
              button: {
                className: 'hyper-btn-notoutline-danger',
              },
              closeOnClickOutside: false,
            });
          }
        }, 2000);
      }

    });
  }
</script>

<style>
  input {
    border-radius: 15px;
  }

  input.expdate {
    width: 35%;
  }

  input.detail {
    width: auto;

  }

  input.pass {
    width: 45%;
  }

  input.user {
    width: 45%;
  }

  #detailnew {
    height: 70px;
    min-height: 70px;
    max-height: 120px;
    width: 300px;

  }

  input.question {
    width: 45%;
  }
  body {
                background-color: #131315;
            }
  label {
color : white;
  }
  #datatable_info{
          color: white;
        }
</style>