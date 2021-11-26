<?php

$noti_count = 0;
$sid = $_COOKIE['USER_SID'];
$var = "SELECT * FROM accounts WHERE sid = '" . $sid . "' ";
$user_query = $hyper->connect->query($var);
$total_user = mysqli_num_rows($user_query);
$data_user = $hyper->connect->query($var)->fetch_array();
$select_noti = "SELECT * FROM notify_log WHERE _to={$data_user['ac_id']} ORDER BY id DESC";

$notify = $hyper->connect->query($select_noti);

?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #131315;">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar6">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a href="home" class="navbar-brand ml-3" style="width: 10%;"><img src="assets/img/logo_dexyStore.jpg" width="64" height="64" class="d-inline-block align-top rounded-circle"></a>
	<!-- ON Mobile -->
	<ul id="onmb" class="nav ml-auto align-items-center" style="display:inline-flex">
		<li class="nav-item">
			<div style="color: #fff;"> <?= $points; ?> บาท</div>
		</li>
		<li class="nav-item mb-2">
			<button class="btn" data-toggle="modal" data-target="#notification">
				<svg xmlns="http://www.w3.org/2000/svg" style="color: #DFC107;" width="20" height="20" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
					<path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
				</svg>
				<span style="color: #fff;"><?= mysqli_num_rows($notify) ?></span>
			</button>
		</li>
		<li class="nav-item mb-1" style="margin-left: -10px;">
			<a class="nav-link btn btn-sm rd" href="logout">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
					<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
				</svg>
			</a>
		</li>
	</ul>
	<div class="navbar-collapse collapse justify-content-center" id="navbar6">
		<ul class="navbar-nav align-items-center">
			<li><a href="home"><button class="btn btn-sm pu <?php if ($page == 'home' || $page == 'shop' || $page == 'item') {
																echo '-active';
															} ?> mr-2" type="button"><i class="fal fa-home-lg-alt mr-1"></i> หน้าแรก</button></a></li>
			<li><a href="profile"><button class="btn btn-sm gr <?php if ($page == 'profile') {
																	echo '-active';
																} ?> mr-2" type="butt><i class=" fal fa-user mr-1"></i> บัญชีของฉัน</button></a></li>
			<?php if ($data_user['role'] == '779') { ?><li><a href="adminsys"><button class="btn btn-sm pk <?php if ($page == 'adminsys' || $page == 'gametype' || $page == 'gameselect' || $page == 'editgame' || $page == 'gamecard' || $page == 'gamedata' || $page == 'dataowner' || $page == 'datauser' || $page == 'datapay' || $page == 'websetting' || $page == 'report') {
																												echo '-active';
																											} ?> mr-2" type="button"><i class="fal fa-tools mr-1"></i> ระบบแอดมิน</button></a></li><?php } ?>
			<li><a href="history"><button class="btn btn-sm yl <?php if ($page == 'history') {
																	echo '-active';
																} ?> mr-2" type="button"><i class="fal fa-history mr-1"></i> ประวัติการซื้อ</button></a></li>
			<li><a href="topup"><button class="btn btn-sm or <?php if ($page == 'topup') {
																	echo '-active';
																} ?> mr-2" type="button"><i class="fal fa-credit-card mr-1" style="color: white;"></i> เติมเงิน</button></a></li>
			<li><a href="https://twitter.com/dexy_store" target="_blank"><button class="btn btn-sm bl mr-2" type="button"><i class="fab fa-twitter-square mr-1"></i> Twitter</button></a></li>
		</ul>
	</div>
	<!-- On PC -->
	<ul id="onpc" class="navbar-nav ml-auto align-items-center" style="display:inline-flex;">
		<li class="nav-item">
			<div class="mx-1" style="color: #fff;"> <?= $points; ?> บาท</div>
		</li>
		<li class="nav-item">

			<button class="btn yl" data-toggle="modal" data-target="#notification">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell " viewBox="0 0 16 16">
					<path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
				</svg>
				<span style="color: #fff;"><?= mysqli_num_rows($notify) ?></span>
			</button>

		</li>
		<li class="nav-item" style="margin-left: -10px;">
			<a class="nav-link" href="logout">
				<button class="btn btn-sm rd" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
						<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
					</svg> ออกจากระบบ
				</button>
			</a>
		</li>
	</ul>
</nav>

<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header " style=" background : #486d7e;">
				<h5 class="modal-title" id="exampleModalLabel" style=" color : white;">การแจ้งเตือน</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color : white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div>
					<?php
					while ($row = mysqli_fetch_assoc($notify)) {
						echo '<div class="alert alert-success" >
								<div class="row">
								&nbsp;&nbsp;	<i class="fas fa-bell"></i>&nbsp;&nbsp;<p>' . base64_decode($row['message']) . '
								<a href="history"><button type="button" class="btn btn-sm btn-warning " style=" color :black ; ">รายละเอียด</button>
								</a>
							</p>   
								</div>
							</div> ';
					}
					?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>


<style>
	@media screen and (max-width: 770px) {
		#onpc {
			display: none !important;
		}
	}

	@media screen and (min-width: 771px) {
		#onmb {
			display: none !important;
		}
	}
</style>