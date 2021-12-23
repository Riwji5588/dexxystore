      <!-- Data Owner -->
      <h3 class="text-center mt-4 mb-4" style="color: white;">--- ID Netflixถูกจำหน่ายแล้ว ---</h3>

      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-hover text-center w-100">
          <thead class="hyper-bg-dark">
            <tr>
              <th scope="col" style="width:120px;">เลขที่ข้อมูล</th>
              <th scope="col">สินค้า</th>
              <th scope="col">บัญชีผู้ใช้</th>
              <th scope="col">เจ้าของ</th>
              <th scope="col">วันที่ซื้อ</th>
              <th scope="col">สถานะ</th>
              <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
          </thead>
          <tbody>

            <?php
            $sql_select_selled = "SELECT * FROM data_selled";
            $query_selled = $hyper->connect->query($sql_select_selled);
            $total_selled_row = mysqli_num_rows($query_selled);

            if ($total_selled_row > 0) {
              $selled = mysqli_fetch_array($query_selled);
              do {

                $selled_data_id = $selled['data_id'];
                $selled_account_id = $selled['ac_id'];

                $sql_select_selled_data = "SELECT * FROM game_data WHERE data_id = '$selled_data_id'";
                $query_selled_data = $hyper->connect->query($sql_select_selled_data);
                $selled_data = mysqli_fetch_array($query_selled_data);

                $selled_game_id = $selled_data['game_id'];

                $sql_select_type_card = "SELECT * FROM game_card WHERE game_id = '$selled_game_id'";
                $query_type_card = $hyper->connect->query($sql_select_type_card);
                $cardtype = mysqli_fetch_array($query_type_card);

                $sql_select_selled_account = "SELECT * FROM accounts WHERE ac_id = '$selled_account_id'";
                $query_selled_account = $hyper->connect->query($sql_select_selled_account);
                $selled_account = mysqli_fetch_array($query_selled_account);

                $expire = strtotime($selled['exp_date']) - strtotime('today midnight');
            ?>
                <tr>
                  <td><?= $selled['selled_id']; ?></td>
                  <td><?php if ($cardtype['card_id'] == null) {
                        echo 'unknow';
                      } else {
                        echo $cardtype['card_title'] . ' - ' . $cardtype['card_price'];
                      } ?></td>
                  <td><?= $selled_data['username']; ?></td>
                  <td><?= $selled_account['username']; ?></td>
                  <td><?= DateThai1($selled['selled_date']); ?></td>
                  <td><?php if ($expire < 1) {
                        echo "หมดอายุ";
                      } else {
                        echo "ยังไม่หมดอายุ";
                      } ?></td>
                  <td>
                    <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editownermodal<?= $selled_data['data_id']; ?>"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
                    <button onclick="DelData(this)" value="<?= $selled['selled_id']; ?>" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>

                    <!-- Edit Game Data Modal -->
                    <div class="modal fade" id="editownermodal<?= $selled_data['data_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                          <div class="modal-header hyper-bg-dark">
                            <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> อัพเดทข้อมูล</h6>
                          </div>
                          <div class="modal-body text-center">

                            <form method="POST" enctype="multipart/form-data">

                              <div class="input-group input-group-sm mb-3 mt-4">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">ชื่อผู้ใช้งาน</span>
                                </div>
                                <input id="username<?= $selled_data['data_id']; ?>" value="<?= $selled_data['username']; ?>" type="text" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อผู้ใช้งาน" required autocomplete="off">
                              </div>

                              <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">รหัสผ่าน</span>
                                </div>
                                <input id="password<?= $selled_data['data_id']; ?>" value="<?= base64_decode($selled_data['password']); ?>" type="text" class="form-control form-control-sm hyper-form-control" placeholder="รหัสผ่าน" required autocomplete="off">
                              </div>

                              <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">จอ</span>
                                </div>
                                <input id="username<?= $selled_data['data_id']; ?>" value="<?= $selled_data['display']; ?>" type="text" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อผู้ใช้งาน" required autocomplete="off">
                              </div>

                              <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                  <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
                                </div>
                                <textarea id="detail<?= $selled_data['data_id']; ?>" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"><?= $selled_data['detail']; ?></textarea>
                              </div>

                              <button type="submit" id="updatedata<?= $selled_data['data_id']; ?>" class="d-none"></button>
                            </form>

                          </div>
                          <div class="modal-footer p-2 border-0">
                            <button type="button" onclick="updatedata('<?= $selled_data['data_id']; ?>')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                            <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End Edit Game Data Modal -->

                  </td>
                </tr>
            <?php } while ($selled = mysqli_fetch_array($query_selled));
            } ?>

          </tbody>
        </table>
      </div>
      <!-- End Data Owner  -->

      <script>
        /** Delete Data */
        function DelData(id) {
          var id = id.value;
          swal({
              title: 'ต้องการลบข้อมูลที่ ' + id,
              text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
              icon: "warning",
              buttons: {
                confirm: {
                  text: 'ลบข้อมูล',
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
                  url: "plugin/del_owner_data.php",
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
                        swal("ลบข้อมูล สำเร็จ!", "ระบบกำลังพาท่านไป...", "success", {
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



        /** Update Data */
        function updatedata(id) {

          $("#updatedata" + id).submit();

          $("#updatedata" + id).submit(function(updateData) {
            updateData.preventDefault();

            swal({
                title: 'ต้องการอัพเดทข้อมูล',
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
                  var did = id;
                  var username = $('#username' + id).val();
                  var password = $('#password' + id).val();
                  var detail = $('#detail' + id).val();

                  updatedata.append('data_id', did);
                  updatedata.append('username', username);
                  updatedata.append('password', password);
                  updatedata.append('detail', detail);

                  $.ajax({

                    type: "POST",
                    url: "plugin/edit_owner_data.php",
                    dataType: "json",
                    data: updatedata,
                    cache: false,
                    contentType: false,
                    processData: false,

                    beforeSend: function() {
                      swal("กำลังอัพเดทข้อมูล กรุณารอสักครู่...", {
                        button: false,
                        closeOnClickOutside: false,
                        timer: 500,
                      });

                    },

                    success: function(data) {
                      setTimeout(() => {
                        if (data.code == "200") {
                          swal("อัพเดทข้อมูล สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success", {
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

          });
        }
      </script>
      <style>
        body {
          background-color: #131315;
        }

        label {
          color: white;
        }

        #datatable_info {
          color: white;
        }

        .es:hover {
          background-color: white;
        }

        .table-hover:hover {
          background-color: #ddd;
        }
      </style>