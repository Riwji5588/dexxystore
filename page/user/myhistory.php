      <!-- MyID -->
      <div class="table-responsive mt-5">
        <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
            <th scope="col" style="width:120px;">เลขที่ข้อมูล</th>
            <th scope="col">เกม</th>
            <th scope="col">บัญชีผู้ใช้</th>
            <th scope="col">เมนู</th>
            <th scope="col">วันที่-เวลา</th>
            </tr>
        </thead>
        <tbody>

        <?php
          $sql_select_selled = "SELECT * FROM data_selled WHERE ac_id = $ac_id";
          $query_selled = $hyper->connect->query($sql_select_selled);
          $total_selled_row = mysqli_num_rows($query_selled);
          
          if($total_selled_row > 0){
            $selled = mysqli_fetch_array($query_selled);
            do{

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
              <td>500<?= $selled['selled_id']; ?></td>
              <td><?php if($selled_game['game_name'] == null){echo 'unknow'; }else{echo $selled_game['game_name'];} ?></td>
              <td><?= $selled_data['username']; ?></td>
              <td>
                <button class="btn btn-sm hyper-btn-notoutline-danger" type="button" data-toggle="modal" data-target="#datamodal<?= $selled['selled_id']; ?>"><i class="fal fa-info-circle mr-1"></i> เพิ่มเติม</button>

                  <!-- Data Modal -->
                <div class="modal fade" id="datamodal<?= $selled['selled_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 radius-border-2 hyper-bg-white">
                      <div class="modal-header hyper-bg-dark">
                        <h6 class="modal-title"><i class="fal fa-info-circle mr-1"></i> ข้อมูลเพิ่มเติม</h6>
                      </div>
                      <div class="modal-body text-left">

                      <span><b>ชื่อผู้ใช้งาน</b></span>
                      <h5 class="mb-3"><?= $selled_data['username']; ?></h5>

                      <span><b>รหัสผ่าน</b></span>
                      <h5 class="mb-3"><?= base64_decode($selled_data['password']); ?></h5>

                      <span><b>รายละเอียด</b></span>
<pre><?= $selled_data['detail']; ?></pre>

                      </div>
                      <div class="modal-footer p-2 border-0">
                        <button type="button" class="btn hyper-btn-notoutline-danger" data-dismiss="modal"><i class="fad fa-times-circle mr-1"></i>ปิดหน้าต่าง</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Data Modal -->

              </td>
              <td><?= $selled['selled_date']; ?></td>
            </tr>
        <?php }while ($selled = mysqli_fetch_array($query_selled));} ?>


        </tbody>
        </table>
      </div>
      <!-- End MyID -->