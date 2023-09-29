<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF-TOKEN -->
	<?php csrfToken(); ?>
	<!-- TITLE -->
	<?php component('title'); ?>
	<title><?= title(); ?></title>
	<!-- FAVICON -->
	<link rel="icon" href="<?= assets('assets/img/favicon/favicon.png'); ?>" sizes="16x16" type="image/png">
	<!-- FONT-AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS -->
	<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
	<!-- CSS  -->
	<link rel="stylesheet" href="<?= assets('assets/css/index.css'); ?>">
    <!-- DATATABLE -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- MOMENT -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
	<!-- FULL CALENDAR -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js"></script>
	<!-- GLOBAL DATA STORING -->
	<?= component('store'); ?>
</head>
<body>

	<!-- **********BACKLIGHT********** -->	
	<div class="backlight_container"></div>

	<!-- **********CONDITION FOR NAVBAR********** -->	
	<?php require('header-style.php'); ?>

	<!-- **********NAVBAR********** -->	
	<nav class="navbar" id="<?= $home_header_id; ?>" style="<?= $home_header_style; ?>">

		<!-- LOGO -->
		<div class="logo" style="<?= $home_header_logo_style; ?>">
			<a href="<?= url('/'); ?>"><img src="<?= assets('assets/img/global/logo.png') ?>" alt=""></a>
		</div>

		<!-- NAV_BTN_RESPONSIVE -->
		<button class="sidenav_btn"><i class="fas fa-bars"></i></button>
		
		<!-- NAV_MENU -->
		<div class="nav_menu">
			<?php if(session('userRole')!=3 && session('userRole')!=2){ ?>
				<a class="navbar_focus_btn <?= $home_focus_btn; ?>" href="<?= url('/book-now'); ?>">Book a Cleaner</a>
			<?php } ?>
			<a class="<?= $active_link['prices']; ?>" href="<?= url('/prices'); ?>">Prices</a>
			<a class="<?= $active_link['guarantee']; ?>" href="<?= url('/guarantee'); ?>">Our Guarantee</a>
			<a class="<?= $active_link['blog']; ?>" href="javascript:void(0)">Blog</a>
			<a class="<?= $active_link['contact']; ?>" href="<?= url('/contact'); ?>">Contact Us</a>
			<?php if(session('isLogged')){ ?>
				<?php if(false){ ?>
				<div class="dropdown border_left border_right">
					<button class="dropdown_btn">
						<!-- <span class="badge">10</span> -->
						<img src="<?= assets('assets/img/global/notification.png'); ?>" alt="">
					</button>
					<div class="dropdown_menu d_none">
						<!-- <div class="drowpdown_notification_container">
							<div class="drowpdown_notification">
								<p>Cancellation! You have canceled the order, Service ID: 8503</p>
								<p>30/12/2021 11:43</p>    
							</div>
							<div class="drowpdown_notification">
								<p>Cancellation! You have canceled the order, Service ID: 8503</p>
								<p>30/12/2021 11:43</p>    
							</div>
							<div class="drowpdown_notification">
								<p>Cancellation! You have canceled the order, Service ID: 8503</p>
								<p>30/12/2021 11:43</p>    
							</div>
							<div class="drowpdown_notification">
								<p>Cancellation! You have canceled the order, Service ID: 8503</p>
								<p>30/12/2021 11:43</p>    
							</div>
							<a href="javascript:void(0)">Show All</a>
						</div> -->
					</div>
				</div>
				<?php } ?>
				<div class="dropdown">
					<button class="dropdown_btn" style="display:flex;justify-content:space-between">
						<img src="<?= assets('assets/img/global/user.png'); ?>" alt="">
						<img style="margin-left:10px;" src="<?= assets('assets/img/buttons/angle/angle_down_white.png'); ?>" alt="">
					</button>
					<div class="dropdown_menu d_none">
						<div>
							<p>Welcome</p>
							<p><?= session('userName'); ?></p>
						</div>
						<hr>
						<a href="javascript:void(0)" onclick="dropdownDashboard()">Dashboard</a>
						<a href="javascript:void(0)" class="table_tab_btn" onclick="dropdownMySetting()">My Setting</a>
						<a href="<?= url('/logout') ?>">Logout</a>
					</div>
				</div>
			<?php 
				}
				else{ 
			?>
				<a class="navbar_focus_btn <?= $home_focus_btn; ?>" href="javascript:void(0)" onclick="open_model('login')">Login</a>
				<a class="navbar_focus_btn <?= $home_focus_btn; ?>" href="<?= url('/service-provider/signup'); ?>">Become a Helper</a>
			<?php } ?>
		</div><!-- END NAV_MENU -->
	</nav><!-- END NAVBAR -->


	<!-- **********HIDDEN COMPONENTS********** -->	
	<?= component('sidenav'); ?>
	<?= component('popup/login'); ?>
	<?= component('popup/forgot-password'); ?>
	<?= component('popup/otp'); ?>
	<?= component('popup/set-new-password'); ?>
	<?= component('popup/included-services'); ?>
	<?= component('popup/add-address'); ?>
	<?= component('popup/edit-address'); ?>
	<?= component('popup/service-details'); ?>
	<?= component('popup/reschedule-service'); ?>
	<?= component('popup/cancel-service'); ?>
	<?= component('popup/rating-sp'); ?>
	<?= component('popup/accept-service'); ?>

	<!-- **********DROPDOWN-TO-DASHBOARD********** -->
	<script>
		function dropdownDashboard(){
			const userRole = `<?= session('userRoleName'); ?>`;
			if(window.location.href == `${BASE_URL}/${userRole}/dashboard`){
				// IF WE ARE ON SAME PAGE THEN NOT TO REFRESH PAGE AND OPEN TAB BY JAVASCRIPT
				$('.table_tab_btn').removeClass('active_table_tab');
				table_tab_btn[1].classList.add('active_table_tab');

				$('.table_tab_content').addClass('d_none');
				table_tab_content[1].classList.remove('d_none');

				// CLOSE SIDENAV ALSO...
				$('.backlight_container').removeClass('backlight');
				$('.sidenav').animate({'right':'-250px'}, 500);
				$('.admin_tab_list').animate({'left':'-272px'}, 500);
				$('body').css({'overflow-y':'auto'});
			}
			else{
				// ON DASHBOARD BY DEFAULT THE MY SETTING TAB OPEN...
				window.location.replace(`${BASE_URL}/${userRole}/dashboard`);
			}
		}
		function dropdownMySetting(){
			const userRole = `<?= session('userRoleName'); ?>`;
			if(window.location.href == `${BASE_URL}/${userRole}/dashboard`){
				// IF WE ARE ON SAME PAGE THEN NOT TO REFRESH PAGE AND OPEN TAB BY JAVASCRIPT

				// OPEN MY SETTING CODE...
				$('.table_tab_btn').removeClass('active_table_tab');
				$('.table_tab_content').addClass('d_none');
				table_tab_content[0].classList.remove('d_none');

				// CLOSE SIDENAV ALSO...
				$('.backlight_container').removeClass('backlight');
				$('.sidenav').animate({'right':'-250px'}, 500);
				$('.admin_tab_list').animate({'left':'-272px'}, 500);
				$('body').css({'overflow-y':'auto'});
			}
			else{
				// ON DASHBOARD BY DEFAULT THE MY SETTING TAB OPEN...
				localStorage.setItem('openMySetting', true);
				window.location.replace(`${BASE_URL}/${userRole}/dashboard`);
			}
		}
	</script>