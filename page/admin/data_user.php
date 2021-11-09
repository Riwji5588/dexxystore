      <!-- Data User -->
      <h3 class="text-center mt-4 mb-4">--- จัดการผู้ใช้งาน ---</h3>

      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
            <th scope="col" style="width:120px;">เลขที่บัญชี</th>
            <th scope="col">บัญชีผู้ใช้</th>
            <th scope="col">Point</th>
            <th scope="col">ระดับ</th>
            <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
        </thead>
        <tbody>
        <?php
          $sql_select_account = "SELECT * FROM accounts";
          $query_account = $hyper->connect->query($sql_select_account);
          $total_account_row = mysqli_num_rows($query_account);
          
          if($total_account_row > 0){
            $account = mysqli_fetch_array($query_account);
            do{
        ?>
          <tr>
            <td><?= $account['ac_id']; ?></td>
            <td><?= $account['username']; ?></td>
            <td><?= number_format($account['points'],0); ?></td>
            <td><?php if($account['role'] == 779){echo '<font style="color:#ff0039;">ผู้ดูแลระบบ</font>';}else{echo 'ผู้ใช้งาน';} ?></td>
            <td>
              <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editusermodal<?= $account['ac_id']; ?>"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
              <button onclick="DelUser(this)" value="<?= $account['ac_id']; ?>" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>

              <!-- Edit Game Data Modal -->
              <div class="modal fade" id="editusermodal<?= $account['ac_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                    <div class="modal-header hyper-bg-dark">
                      <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> อัพเดทข้อมูล</h6>
                    </div>
                    <div class="modal-body text-center">

                      <form method="POST" enctype="multipart/form-data">

                        <img src="assets/img/logoani_236x236.jpg" width="99px" class="img-fluid rounded-circle ml-auto mr-auto mb-2"></br>
                        <font class="text-muted">Username</font>
                        <h5><b><?= $account['username']; ?></b></h5>

                        <div class="input-group input-group-sm mb-3 mt-4">
                          <div class="input-group-prepend">
                            <span class="input-group-text hyper-bg-dark border-dark">E-mail</span>
                          </div>
                          <input id="email<?= $account['ac_id']; ?>" value="<?= $account['email']; ?>" type="email" class="form-control form-control-sm hyper-form-control" placeholder="E-mail" required>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text hyper-bg-dark border-dark">Point</span>
                          </div>
                          <input id="point<?= $account['ac_id']; ?>" value="<?= $account['points']; ?>" type="number" class="form-control form-control-sm hyper-form-control" placeholder="Point" required>
                        </div>

                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <label class="input-group-text hyper-bg-dark border-dark" for="inputGroupSelect01">ระดับผู้ใช้งาน</label>
                          </div>
                          <select id="role<?= $account['ac_id']; ?>" class="custom-select hyper-form-control" id="inputGroupSelect01">
                            <option <?php if($account['role'] == 1){echo 'selected';} ?> value="1">ผู้ใช้งาน</option>
                            <option <?php if($account['role'] == 779){echo 'selected';} ?> value="779">ผู้ดูแลระบบ</option>
                          </select>
                        </div>

                        <button type="submit" id="updatedata<?= $account['ac_id']; ?>" class="d-none"></button>
                      </form>

                    </div>
                    <div class="modal-footer p-2 border-0">
                      <button type="button" onclick="updatedata('<?= $account['ac_id']; ?>')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                      <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Edit Game Data Modal -->

            </td>
            </tr>
        <?php }while ($account = mysqli_fetch_array($query_account));} ?>

        </tbody>
        </table>
      </div>
      <!-- End User  -->

      <script>
      /** Delete Data */
      function DelUser(id){
            var  id = id.value;
            swal({
              title: 'ต้องการลบผู้ใช้งานที่ ' + id,
              text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
              icon: "warning",
              buttons: {
                confirm : {text:'ลบผู้ใช้งาน',className:'hyper-btn-notoutline-danger'},
                cancel : 'ยกเลิก'
              },
              closeOnClickOutside:false,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({

                  type: "POST",
                  url: "plugin/del_user.php",
                  dataType: "json",
                  data: {id:id},

                  beforeSend: function() {
                  swal("กำลังลบข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

                  },

                  success : function(data){
                  setTimeout(function() {
                      if (data.code == "200"){
                          swal("ลบผู้ใช้งาน สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
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



      /** Update Data */
      function updatedata(id) {

      $("#updatedata" + id).submit();

      $("#updatedata" + id).submit(function(updateData){
        updateData.preventDefault();

        swal({
        title: 'ต้องการอัพเดทผู้ใช้งาน',
        text: "คุณต้องการอัพเดทผู้ใช้งานใช่หรือไม่",
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
            var uid = id;
            var point = $('#point'+id).val();
            var email = $('#email'+id).val();
            var role = $('#role'+id).val();

            updatedata.append('user_id',uid);
            updatedata.append('point',point);
            updatedata.append('email',email);
            updatedata.append('role',role);

            $.ajax({

            type: "POST",
            url: "plugin/edit_user.php",
            dataType: "json",
            data: updatedata,
            cache: false,
            contentType: false,
            processData: false,

            beforeSend: function() {
              swal("กำลังอัพเดทข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

            },

            success : function(data){
              setTimeout(function() {
                if (data.code == "200"){
                  swal("อัพเดทผู้ใช้งาน สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
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