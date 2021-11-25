<!-- <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #131315;">
	<div class="d-flex w-50 order-0">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand ml-5" href="home">
			<img src="assets/img/logo_dexyStore.jpg" width="64" height="64" class="d-inline-block align-top rounded-circle">
		</a>
	</div>
	<div class="navbar-collapse collapse justify-content-center order-1" id="collapsingNavbar" style="width: 100%;">
		<ul class="navbar-nav ml-auto mr-auto">
			<li><a href="home"><button class="btn btn-sm pu <?php if ($page == 'home' || $page == 'shop' || $page == 'item') {
																echo '-active';
															} ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-home-lg-alt mr-1"></i> หน้าแรก</button></a></li>
			<li><a href="profile"><button class="btn btn-sm gr <?php if ($page == 'profile') {
																	echo '-active';
																} ?> my-2 my-sm-0 mr-2" type="butt><i class=" fal fa-user mr-1"></i> บัญชีของฉัน</button></a></li>
			<?php if ($data_user['role'] == '779') { ?><li><a href="adminsys"><button class="btn btn-sm pk <?php if ($page == 'adminsys' || $page == 'gametype' || $page == 'gameselect' || $page == 'editgame' || $page == 'gamecard' || $page == 'gamedata' || $page == 'dataowner' || $page == 'datauser' || $page == 'datapay' || $page == 'websetting' || $page == 'report') {
																												echo '-active';
																											} ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-tools mr-1"></i> ระบบแอดมิน</button></a></li><?php } ?>
			<li><a href="history"><button class="btn btn-sm yl <?php if ($page == 'history') {
																	echo '-active';
																} ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-history mr-1"></i> ประวัติการซื้อ</button></a></li>
			<li><a href="topup"><button class="btn btn-sm or <?php if ($page == 'topup') {
																	echo '-active';
																} ?> my-2 my-sm-0 mr-2" type="button"><i class="fal fa-credit-card mr-1" style="color: white;"></i> เติมเงิน</button></a></li>
			<li><a href="https://twitter.com/dexy_store" target="_blank"><button class="btn btn-sm bl my-2 my-sm-0 mr-2" type="button"><i class="fab fa-twitter-square mr-1"></i> Twitter</button></a></li>
			<li><a href="logout"><button class="btn btn-sm rd  my-2 my-sm-0 mr-3" type="button"><i class="fad fa-times-circle mr-1"></i> ออกจากระบบ</button></a></li>
		</ul>
	</div>
</nav> -->

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
		<li class="nav-item">
			<a class="nav-link" href="logout">
				<button class="btn btn-sm rd" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
						<path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
					</svg>
				</button>
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
			<div style="color: #fff;"> <?= $points; ?> บาท</div>
		</li>
		<li class="nav-item">
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