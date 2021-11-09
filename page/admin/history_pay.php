      <!-- Data Pay -->
      <h3 class="text-center mt-4 mb-4">--- ประวัติรายได้ทั้งหมด ---</h3>

      <div class="table-responsive mt-3">
        <table id="datatable" class="table table-hover text-center w-100">
        <thead class="hyper-bg-dark">
            <tr>
            <th scope="col" style="width:120px;">เลขที่รายการ</th>
            <th scope="col">บัญชีผู้ใช้</th>
            <th scope="col">Link</th>
            <th scope="col">จำนวน</th>
            <th scope="col" style="width: 170px;">วันที่-เวลา</th>
            </tr>
        </thead>
        <tbody>

        <?php
          $sql_select_pay = "SELECT * FROM history_pay";
          $query_pay = $hyper->connect->query($sql_select_pay);
          $total_pay_row = mysqli_num_rows($query_pay);
          
          if($total_pay_row > 0){
            $pay = mysqli_fetch_array($query_pay);
            do{
        ?>
        <tr>
            <td><?= $pay['pay_id']; ?></th>
            <td><?= $pay['username']; ?></th>
            <td><?= $pay['link']; ?></th>
            <td><?= number_format($pay['amount'],0); ?></th>
            <td><?= $pay['date']; ?></th>
          </tr>
        <?php }while ($pay = mysqli_fetch_array($query_pay));} ?>


        </tbody>
        </table>
      </div>
      <!-- End Pay  -->