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
				<svg xmlns="http://www.w3.org/2000/svg" style="color: white;" width="20" height="20" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
					<path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
				</svg>
				<sup style="color: #00ff73;"><?= mysqli_num_rows($notify) ?></sup>
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
	<ul id="onpc" class="navbar-nav ml-auto align-items-center " style="display:inline-flex; ">
		<li class="nav-item" style="margin-right:15px;">
			<div class="mx-1" style="color: #fff;"> <?= $points; ?> บาท</div>
		</li>
		<li class="nav-item" style="margin-right:15px;">
			<button class="btn " data-toggle="modal" data-target="#notification">
				<svg xmlns="http://www.w3.org/2000/svg" style="color: white;" width="20" height="20" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
					<path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
				</svg>
				<sup style="color: #00ff73; font-size:14px;"><?= mysqli_num_rows($notify) ?></sup>
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
			<div class="modal-body" style="font-size: 15px">
				<div>
					<?php
					while ($row = mysqli_fetch_assoc($notify)) {
						$msg = base64_decode($row['message']);
						$order_id = (int) filter_var($msg, FILTER_SANITIZE_NUMBER_INT);

						$datetime = $row['datetime'];
						$datetime7 = date_add(date_create($datetime), date_interval_create_from_date_string('7 days'));
						$date_diff = date_diff(date_create($datetime), $datetime7)->format("%a");

						if ($row['isadmin']) {
					?>
							<div class="alert alert-info">
								<div class="row align-items-center mb-1">
									<div class="col-1 col-md-1 " style="padding-right: 0;">
										<i class="fas fa-bell"></i>
									</div>
									<div class="col-12 col-md-8 " align="start" style="padding-right: 0;">
										<?= $msg ?>
									</div>
									<div class="col-4 col-md-3 mb-2" style="margin-top: 4px;">
										<a href="report&id=<?= $order_id ?>" class="btn btn-sm btn-warning " style=" color :black ; ">
											รายละเอียด
										</a>
									</div>
									<div class="col-12 mt-5" align="right" style="position: absolute;">
										<small class="text-muted">
											เหลือเวลาอีก <?= $date_diff ?> วัน
										</small>
									</div>
								</div>
							</div>
							<?php
						} else {
							if ($row['status'] == 1) {
							?>
								<div class="alert alert-success">
									<div class="row align-items-center mb-1">
										<div class="col-1 col-md-1 ">
											<i class="fas fa-bell"></i>
										</div>
										<div class="col-12 col-md-8" align="start">
											<?= $msg ?>
										</div>
										<div class="col-4 col-md-3 mb-2" style="margin-top: 4px;">
											<a href="history&id=<?= $order_id ?>" class="btn btn-sm btn-warning " style=" color :black ; ">
												รายละเอียด
											</a>
										</div>
										<div class="col-12 mt-5" align="right" style="position: absolute;">
											<small class="text-muted">
												เหลือเวลาอีก <?= $date_diff ?> วัน
											</small>
										</div>
									</div>
								</div>
							<?php
							} else {
							?>
								<div class="alert alert-danger">
									<div class="row align-items-center mb-1">
										<div class="col-1 col-md-1 ">
											<i class="fas fa-bell"></i>
										</div>
										<div class="col-12 col-md-8 " align="start">
											<?= $msg ?>
										</div>
										<div class="col-4 col-md-3 mb-2" style="margin-top: 4px;">
											<a href="history&id=<?= $order_id ?>" class="btn btn-sm btn-warning " style=" color :black ; ">
												รายละเอียด
											</a>
										</div>
										<div class="col-12 mt-5" align="right" style="position: absolute;">
											<small class="text-muted">
												เหลือเวลาอีก <?= $date_diff ?> วัน
											</small>
										</div>
									</div>
								</div>
					<?php
							}
						}
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