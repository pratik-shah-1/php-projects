	<?php 
		$home_footer_bg = '';
		if(pageUrl()=='/'){
			$home_footer_bg = 'background-color:#F4F5F8;';
		}
	?>

	<!-- **********FOOTER********** -->
	<footer>
		<!-- FOOTER_TRANSPARENT_DIV -->
		<!-- IF HOME PAGE THEN TRANSPARENT-DIV HAVE DIFFERNT COLOR -->
		<div class="footer_transparent_div" style="<?= $home_footer_bg; ?>">
			<!-- GET_OUR_NEWSLETTERS -->
			<form class="get_our_newsletter" action="">
				<p>GET OUR NEWSLETTER</p>
				<div>
					<input type="text" placeholder="YOUR EMAIL">
					<button>Submit</button>
				</div>
			</form>
		</div><!-- END_FOOTER_TRANSPARENT_DIV -->

		<!-- FOOTER_MAIN_DIV -->
		<div class="footer_main_div">
			<!-- LOGO + LINKS -->
			<div>
				<div class="footer_logo">
					<a href="<?= url('/'); ?>"><img src="<?= assets('assets/img/global/logo.png'); ?>" alt=""></a>
				</div>
				<div class="footer_links">
					<a href="<?= url('/'); ?>">HOME</a>
					<a href="<?= url('/about'); ?>">ABOUT</a>
					<a href="javascript:void(0)">TESTIMONIALS</a>
					<a href="<?= url('/faqs'); ?>">FAQS</a>
					<a href="javascript:void(0)">INSURANCE POLICY</a>
					<a href="javascript:void(0)">IMPRESSUM</a>
				</div>
				<div class="social_media_links">
					<a href="javascript:void(0)"><img src="<?= assets('assets/img/global/facebook.png'); ?>" alt=""></a>
					<a href="javascript:void(0)"><img src="<?= assets('assets/img/global/instagram.png'); ?>" alt=""></a>
				</div>
			</div>
			<!-- COPYRIGHT_SECTION -->
			<div>
				<p class="copyright_section">©2022 Helperland. All rights reserved. Terms and Conditions | <a href="javascript:void(0)">Privacy Policy</a></p>
			</div>
		</div><!-- END_FOOTER_MAIN_DIV -->

	</footer>

	<!-- **********FIXED_BUTTON********** -->
	<!-- GO_TO_TOP_BTN -->
	<button class="go_top_btn"><img src="<?= assets('assets/img/buttons/up_btn.png'); ?>" alt=""></button>

	<!-- CHAT -->
	<!-- <button class="chat"><img src="<?= assets('assets/img/global/time.png'); ?>" alt=""></button> -->

	<!-- PRIVACY_POLICY -->
	<!-- <div class="cookie">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat nunc libero, ac malesuada ligula aliquam ac. <a href="javascript:void(0)">Privacy Policy</a></p>
		<button id="cookie_submit_btn">OK!</button>
	</div> -->


	<!-- EXCEL2TABLE -->
	<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
	<!-- DATATABLE -->
	<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<!-- AOS -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<!-- TITL-JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.0.3/tilt.jquery.min.js"></script>
	<!-- SWEET-ALERT -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- CUSTOM_JAVASCRIPT -->
	<script src="<?= assets('assets/js/accordion.js'); ?>"></script>
	<script src="<?= assets('assets/js/avatar.js'); ?>"></script>
	<script src="<?= assets('assets/js/admintab.js'); ?>"></script>
	<script src="<?= assets('assets/js/dropdown.js'); ?>"></script>
	<script src="<?= assets('assets/js/footer.js'); ?>"></script>
	<script src="<?= assets('assets/js/homenav.js'); ?>"></script>
	<script src="<?= assets('assets/js/label.js'); ?>"></script>
	<script src="<?= assets('assets/js/model.js'); ?>"></script>
	<script src="<?= assets('assets/js/navtabs.js'); ?>"></script>
	<script src="<?= assets('assets/js/sidenav.js'); ?>"></script>
	<script src="<?= assets('assets/js/tabletab.js'); ?>"></script>
	<script src="<?= assets('assets/js/validation.js'); ?>"></script>
	<script>
		AOS.init();
		$('.home_s3_intro > img').tilt({
			glare: true,
			maxGlare: .5
		});
	</script>
	
	<?= component('session-scripts'); ?>
	
</body>
</html>
