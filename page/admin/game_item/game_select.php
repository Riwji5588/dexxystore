        <!-- Game Select -->
        <h3 class="text-center mt-4 mb-4">--- เลือกสินค้าที่ต้องการจัดการ ---</h3>
        <div class="row no-gutters">

            <?php

            $sql_select_game = "SELECT * FROM game_type ORDER BY game_id DESC";
            $query_game = $hyper->connect->query($sql_select_game);
            $total_game_row = mysqli_num_rows($query_game);
            $game = mysqli_fetch_array($query_game);

            if($total_game_row <= 0){
            ?>
            <h4 class="text-center w-100 mt-4">ไม่มีข้อมูลในขณะนี้</h4>
            <?php 
            }else{
            do{
                $gid = $game['game_id'];
                $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE game_id = $gid AND selled = 0";
                $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();
            ?>
            <div class="col-6 col-lg-4 p-2">
                <a href="editgame&gameid=<?= $game['game_id']; ?>">
                <div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-2 h-100 hyper-card">
                    <div class="media">
                        <img src="assets/img/game/<?= $game['game_image']; ?>" class="align-self-center mr-3 rounded-circle d-none d-md-block" width="70px;">
                        <div class="media-body text-center text-md-left">
                          <img src="assets/img/game/<?= $game['game_image']; ?>" class="ml-auto mr-auto rounded-circle d-block d-md-none" width="70px;">
                          <h4 class="mt-0 mb-1"><?= $game['game_name']; ?></h4>
                          <font class="text-muted"><?= number_format($ready_selled_row['totaldata'],0); ?> ไอดี</font>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <?php }while ($game = mysqli_fetch_array($query_game));} ?>

        </div>
        <!-- End Game Select -->