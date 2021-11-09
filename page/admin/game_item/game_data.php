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
      <!-- Game Data -->

      <h3 class="text-center mt-4 mb-4">--- ข้อมูลทั้งหมดใน <?= $game['game_name']; ?> ---</h3>
      <center><button class="btn hyper-btn-info my-2 my-sm-0 w-100" type="button" data-toggle="modal" data-target="#addgamemodal"><i class="fal fa-plus-square mr-1"></i> เพิ่มข้อมูลใหม่เข้าระบบ</button></center>

      <!-- Add Game Data Modal -->
      <div class="modal fade" id="addgamemodal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 radius-border-2 hyper-bg-white">
            <div class="modal-header hyper-bg-dark">
              <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> เพิ่มข้อมูลใหม่เข้าระบบ</h6>
            </div>
            <div class="modal-body text-center">

              <form id="addDatanew" method="POST" enctype="multipart/form-data">

                <div class="input-group input-group-sm mb-3 mt-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text hyper-bg-dark border-dark">ชื่อผู้ใช้งาน</span>
                  </div>
                  <input id="usernamenew" name="usernamenew" type="text" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อผู้ใช้งาน" required autocomplete="off">
                </div>

                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text hyper-bg-dark border-dark">รหัสผ่าน</span>
                  </div>
                  <input id="passwordnew" name="passwordnew" type="password" class="form-control form-control-sm hyper-form-control" placeholder="รหัสผ่าน" required autocomplete="off">
                </div>

                <div class="input-group input-group-sm mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text hyper-bg-dark border-dark" for="inputGroupSelect01">เลือกการ์ด</label>
                  </div>
                  <select id="cardnew" name="cardnew" class="custom-select hyper-form-control" id="inputGroupSelect01">
                    <option selected>เลือกการ์ด...</option>
                    <?php
                    $sql_select_type_card = "SELECT * FROM game_card WHERE game_id = '$id'";
                    $query_type_card = $hyper->connect->query($sql_select_type_card);
                    $total_type_card_row = mysqli_num_rows($query_type_card);
                    
                    if($total_type_card_row > 0){
                      $cardtype = mysqli_fetch_array($query_type_card);
                      do{
                    ?>
                      <option value="<?= $cardtype['card_id']; ?>" ><?= $cardtype['card_title']; ?></option>
                    <?php }while ($cardtype = mysqli_fetch_array($query_type_card));} ?>
                  </select>
                </div>

                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
                  </div>
                  <textarea id="detailnew" name="detailnew" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"></textarea>
                </div>

                <input type="hidden" id="gameidnew" name="gameidnew" value="<?= $game['game_id']; ?>"/>

                <button type="submit" id="submitdatanew" class="d-none"></button>
              </form>

            </div>
            <div class="modal-footer p-2 border-0">
              <button type="button" onclick="submitdata('new')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>เพิ่มข้อมูล</button>
              <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Add Game Data Modal -->

      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
            <th scope="col" style="width:120px;">เลขที่ข้อมูล</th>
            <th scope="col">บัญชีผู้ใช้</th>
            <th scope="col">ที่อยู่การ์ด</th>
            <th scope="col" style="width: 170px;">เมนู</th>
            </tr>
        </thead>
        <tbody>

        <?php
          $sql_select_data = "SELECT * FROM game_data WHERE game_id = '$id' AND selled = 0";
          $query_data = $hyper->connect->query($sql_select_data);
          $total_data_row = mysqli_num_rows($query_data);
          
          if($total_data_row > 0){
            $data = mysqli_fetch_array($query_data);
            do{
        ?>
          <tr>
            <td><?= $data['data_id']; ?></td>
            <td><?= $data['username']; ?></td>
            <?php
              $data_card_id = $data['card_id'];
              $sql_select_data_card = "SELECT * FROM game_card WHERE card_id = '$data_card_id'";
              $query_data_card = $hyper->connect->query($sql_select_data_card);
              $data_card = mysqli_fetch_array($query_data_card);
            ?>
            <td><?= $data_card['card_title']; ?></td>
            <td>
              <button class="btn btn-sm hyper-btn-notoutline-success" type="button" data-toggle="modal" data-target="#editdatamodal<?= $data['data_id']; ?>"><i class="fal fa-edit mr-1"></i> แก้ไข</button>
              <button onclick="DelData(this)" value="<?= $data['data_id']; ?>" class="btn btn-sm hyper-btn-notoutline-danger my-1 my-sm-0" type="button"><i class="fal fa-trash-alt mr-1"></i> ลบ</button>

              <!-- Edit Game Data Modal -->
              <div class="modal fade" id="editdatamodal<?= $data['data_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                    <div class="modal-header hyper-bg-dark">
                      <h6 class="modal-title"><i class="fal fa-plus-square mr-1"></i> แก้ไขข้อมูล</h6>
                    </div>
                    <div class="modal-body text-center">

                      <form method="POST" enctype="multipart/form-data">

                        <div class="input-group input-group-sm mb-3 mt-4">
                          <div class="input-group-prepend">
                            <span class="input-group-text hyper-bg-dark border-dark">ชื่อผู้ใช้งาน</span>
                          </div>
                          <input id="username<?= $data['data_id']; ?>" type="text" value="<?= $data['username']; ?>" class="form-control form-control-sm hyper-form-control" placeholder="ชื่อผู้ใช้งาน" required autocomplete="off">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text hyper-bg-dark border-dark">รหัสผ่าน</span>
                          </div>
                          <input id="password<?= $data['data_id']; ?>" type="text" value="<?= base64_decode($data['password']); ?>" class="form-control form-control-sm hyper-form-control" placeholder="รหัสผ่าน" required autocomplete="off">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text hyper-bg-dark border-dark" for="inputGroupSelect01">เลือกการ์ด</label>
                          </div>
                          <select class="custom-select hyper-form-control" id="card<?= $data['data_id']; ?>">
                          <?php
                          $sql_select_type_card = "SELECT * FROM game_card WHERE game_id = '$id'";
                          $query_type_card = $hyper->connect->query($sql_select_type_card);
                          $total_type_card_row = mysqli_num_rows($query_type_card);
                          
                          if($total_type_card_row > 0){
                            $cardtype = mysqli_fetch_array($query_type_card);
                            do{
                          ?>
                            <option <?php if($cardtype['card_id'] == $data_card_id){echo 'selected'; }?> value="<?= $cardtype['card_id']; ?>" ><?= $cardtype['card_title']; ?></option>
                          <?php }while ($cardtype = mysqli_fetch_array($query_type_card));} ?>
                          </select>
                        </div>

                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text hyper-bg-dark border-dark">รายละเอียด</span>
                          </div>
                          <textarea id="detail<?= $data['data_id']; ?>" class="form-control form-control-sm hyper-form-control" style="height: 100px;min-height: 100px;max-height: 100px;"><?= $data['detail']; ?></textarea>
                        </div>

                        <input type="hidden" id="gameid<?= $data['data_id']; ?>" value="<?= $game['game_id']; ?>"/>

                        <button type="submit" id="updatedata<?= $data['data_id']; ?>" class="d-none"></button>
                      </form>

                    </div>
                    <div class="modal-footer p-2 border-0">
                      <button type="button" onclick="updatedata('<?= $data['data_id']; ?>')" class="btn hyper-btn-notoutline-success"><i class="fal fa-plus-square mr-1"></i>อัพเดทข้อมูล</button>
                      <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ยกเลิก</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Edit Game Data Modal -->

            </td>
          </tr>
        <?php }while ($data = mysqli_fetch_array($query_data));} ?>

        </tbody>
        </table>
      </div>

      <script>
        function submitdata(id) {
          $("#submitdata"+id).click();
        }
      </script>
      <script>

      /* AddData script */
      $("#addDatanew").submit(function(adddata){
      adddata.preventDefault();

      $.ajax({

        type: "POST",
        url: "plugin/add_new_data.php",
        data: new FormData(this),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function() {
          swal("กำลังเพิ่มข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

        },

        success : function(data){
          setTimeout(function() {
            if (data.code == "200"){
              swal("เพิ่มข้อมูล สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
              setTimeout(function(){ window.location.reload();}, 2000);
            } else {
              swal(data.msg ,"" ,"error",{button:{className:'hyper-btn-notoutline-danger',},closeOnClickOutside:false,});
            }
          }, 2000);
        }

      });
      });


      /** Delete Data */
      function DelData(id){
      var  id = id.value;
      swal({
        title: 'ต้องการลบข้อมูลที่ ' + id,
        text: "ถ้าลบแล้วจำไม่สามารถกู้กลับมาได้",
        icon: "warning",
        buttons: {
          confirm : {text:'ลบข้อมูล',className:'hyper-btn-notoutline-danger'},
          cancel : 'ยกเลิก'
        },
        closeOnClickOutside:false,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({

            type: "POST",
            url: "plugin/del_data.php",
            dataType: "json",
            data: {id:id},

            beforeSend: function() {
            swal("กำลังลบข้อมูล กรุณารอสักครู่...",{button:false,closeOnClickOutside:false,timer:1900,});

            },

            success : function(data){
            setTimeout(function() {
                if (data.code == "200"){
                    swal("ลบข้อมูล สำเร็จ!", "ระบบกำลังพาท่านไป...", "success",{button:false,closeOnClickOutside:false,});
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
        title: 'ต้องการอัพเดทข้อมูลที่ ' + id,
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
            var did = id;
            var username = $('#username'+id).val();
            var password = $('#password'+id).val();
            var cid = $('#card'+id).val();
            var detail = $('#detail'+id).val();
            var gid = $('#gameid'+id).val();

            updatedata.append('data_id',did);
            updatedata.append('username',username);
            updatedata.append('password',password);
            updatedata.append('card_id',cid);
            updatedata.append('detail',detail);
            updatedata.append('gameid',gid);

            $.ajax({

            type: "POST",
            url: "plugin/edit_data.php",
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
                  swal("อัพเดทข้อมูล สำเร็จ!", "ระบบกำลังบันทึกข้อมูล...", "success",{button:false,closeOnClickOutside:false,});
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
      <!-- End Game Data -->
<?php } ?>