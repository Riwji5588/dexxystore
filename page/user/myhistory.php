      <!-- MyID -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <div class="table-responsive mt-5">
        <table id="datatable" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:120px;">เลขที่ข้อมูล</th>
              <th scope="col">เกม</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">เมนู</th>
              <th scope="col">วันที่-เวลา ที่ซื้อ</th>
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
                  <td>
                    <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#datamodal<?= $selled['selled_id']; ?>"><i class="fal fa-info-circle mr-1"></i> เพิ่มเติม</button>
                    <button class="btn btn-sm btn-warning " type="button" data-toggle="modal" data-target="#datamodal1<?= $selled['selled_id']; ?>" style="color: ;"><i class="fas fa-exclamation-triangle"></i> แจ้งปัญหา</button>

                    <!-- Data Modal -->
                    <div class="modal fade" id="datamodal<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                          <div class="modal-header hyper-bg-dark">
                            <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i> ข้อมูลเพิ่มเติม</h6>
                          </div>
                          <div class="modal-body text-left">
                            <div class="form-group">
                              <span><b>ชื่อผู้ใช้งาน</b></span>
                              <?= $selled_data['username']; ?>
                            </div>
                            <div class="form-group">
                              <span><b>รหัสผ่าน</b></span>
                              <?= base64_decode($selled_data['password']); ?>
                            </div>
                            <div class="form-group">
                              <span><b>รายละเอียด</b></span>
                              <span style=" color: red;"><?= $selled_data['display']; ?></span>
                            </div>
                            <div class="form-group">
                              <span><b>วันหมดอายุ</b></span>
                              <?= $selled['exp_date']; ?>
                            </div>

                            <div class="modal-footer p-2 border-0">
                              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Data Modal -->

                    <!-- Claim Modal -->
                    <div class="modal fade" id="datamodal1<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i> แจ้งปัญหาในการใช้งาน</h6>
                          </div>
                          <div class="modal-body text-left" style="width: auto;">

                            <ul class="nav nav-tabs">
                              <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#user<?= $selled['selled_id']; ?>">ปัญหาการใช้งานด้านผู้ใช้</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tec<?= $selled['selled_id']; ?>">ปัญหาการใช้งานด้านเทคนิค</a>
                              </li>

                            </ul>
                            <!--conternt !-->
                            <div class="tab-content">
                              <div id="user<?= $selled['selled_id']; ?>" class="container tab-pane active"><br>
                                <h4>ปัญหาการใช้งานด้านผู้ใช้ </h4> <b style="color: red;">!---กรุณาติดต่อแอดมินผ่านLine---!</b><br>
                                <img src="assets/img/line.jpg" style="width:auto; max-width: 130px;">
                              </div>

                              <div id="tec<?= $selled['selled_id']; ?>" class="container tab-pane fade"><br>
                                <h4>ปัญหาการใช้งานด้านเทคนิค</h4>
                                
                                  
                                    <span ><b>รายละเอียด</b></span>
                                  
                                <textarea id="" class="form-control form-control-sm hyper-form-control" style="width:50% ; height: 100px;min-height: 100px;max-height: 100px;"> </textarea>
                                <br>
                                <button type="button" class="btn hyper-btn-notoutline-danger" onclick="claim(<?= $selled['selled_id']; ?>)"><i class="fad fa-times-circle mr-1"></i>ส่งเคลม</button>
                              </div>
                            </div>

                            <div class="modal-footer p-2 border-0">

                              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Data Modal -->

                  </td>
                  <td><?= $selled['selled_date']; ?></td>

                </tr>
            <?php } while ($selled = mysqli_fetch_array($query_selled));
            } ?>


          </tbody>
        </table>
      </div>
      <!-- End MyID -->

      <script>
        function claim(id) {
          $.ajax({

            type: "POST",
            url: "plugin/claim.php",
            dataType: "json",
            data: {
              id: id
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
                  swal("ส่งเคลม สำเร็จ!", '\n', "success", {
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

        .modal-header {
          background-color: #ffc107;


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
      </style>