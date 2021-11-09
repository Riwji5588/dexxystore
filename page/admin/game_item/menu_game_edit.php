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

            $gid = $game['game_id'];
            $data_ready_selled = "SELECT count(data_id) AS 'totaldata' FROM game_data WHERE game_id = $gid AND selled = 0";
            $ready_selled_row = $hyper->connect->query($data_ready_selled)->fetch_array();

            $card = "SELECT count(card_id) AS 'totalcard' FROM game_card WHERE game_id = $gid";
            $card_row = $hyper->connect->query($card)->fetch_array();

        ?>
        <h3 class="text-center mt-4 mb-4">--- เลือกประเภทการจัดการ ---</br><b><?= $game['game_name']; ?></b></h3>
        <!-- Status Site Bar -->
        <div class="row no-gutters mt-4">

            <div class="col-6 p-2">
                <a href="gamecard&gameid=<?= $id; ?>"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                    <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-shopping-cart"></i></h1>
                    <h1 class="mt-0 mb-0"><?= number_format($card_row['totalcard'],0); ?></h1>
                    <font class="text-muted">การ์ดแสดงสินค้า</font>
                </div></a>
            </div>
            
            <div class="col-6 p-2">
                <a href="gamedata&gameid=<?= $id; ?>"><div class="card shadow-dark radius-border-6 hyper-bg-white text-center p-3 hyper-card">
                    <h1 class="mt-0 mb-0" style="font-size: 3.5rem;"><i class="fal fa-server"></i></h1>
                    <h1 class="mt-0 mb-0"><?= number_format($ready_selled_row['totaldata'],0); ?></h1>
                    <font class="text-muted">ข้อมูลไอดีในระบบ</font>
                </div></a>
            </div>

        </div>
        <!-- End Status Site Bar -->
        <?php } ?>