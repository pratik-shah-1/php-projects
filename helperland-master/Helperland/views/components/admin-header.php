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
	<!-- MOMENT -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
	<!-- GLOBAL DATA STORING -->
	<?= component('store'); ?>
</head>
<body>

	<!-- **********BACKLIGHT********** -->	
	<div class="backlight_container"></div>

	<!-- **********ADMIN NAVBAR********** -->	
    <nav class="admin_navbar">

        <div class="admin_logo">
            <a href="javascript:void(0)"><img src="<?= assets('assets/img/global/admin-logo.png'); ?>" alt=""></a>
        </div>

        <!-- NAV_BTN_RESPONSIVE -->
        <div class="admin_navbar_toggle_btn_container">
            <button class="admin_dashboard_btn" title="Dashboard"><i class="fas fa-tachometer-alt"></i></button>
            <button class="sidenav_btn"><i class="fas fa-bars"></i></button>
        </div>
        <div class="admin_nav_menu">
            <img src="<?= assets('assets/img/global/user.png'); ?>" alt="">
            <p><?= session('userName'); ?></p>
            <button onclick="window.location.href=`<?= url('/logout') ?>`;" ><img src="<?= assets('assets/img/global/logout.png'); ?>" alt=""></button>
        </div>
    </nav>


	<!-- **********HIDDEN COMPONENTS********** -->	
	<?= component('sidenav'); ?>
	<?= component('popup/edit-service-request'); ?>
	