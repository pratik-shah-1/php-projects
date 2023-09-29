<?= component('header') ?>

<!-- **********FAQ_MAIN********** -->

<!-- FAQ_BANNER -->
<div class="banner">
	<img src="<?= assets('assets/img/banner/faqs.png'); ?>" alt="">
</div>	

<main class="faq">
	<!-- FAQ_TITLE -->
	<div class="title_with_icon">
		<p>FAQs</p>
		<div>
			<div><img src="<?= assets('assets/img/global/separator.png'); ?>" alt=""></div>
		</div>
	</div>

	<!-- FAQ_INTRO -->
	<div class="faq_intro">
		<p>Whether you are Customer or Service provider, We have tried our best to solve all your queries and questions.</p>
	</div>

	<div class="faq_container">
		<div class="tab_container">
			<div class="tab_indicator faq_tabs">
				<button class="tab_btn active_faq_tab">CUSTOMER</button>
				<button class="tab_btn">FOR SERVICE PROVIDER</button>
			</div>
			<div class="tab_body">
				<div class="tab_content active_tab_content">
					<div class="questions">
						<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>What's included in a cleaning?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">Bedroom, Living Room & Common Areas, Bathrooms, Kitchen, Extras</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
						<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>Which Helperland professional will come to my place?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">Helperland has a vast network of experienced, top-rated cleaners. Based on the time and date of your request, we work to assign the best professional available. Like working with a specific pro? Add them to your Pro Team from the mobile app and they'll be requested first for all future bookings. You will receive an email with details about your professional prior to your appointment.</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
						<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>Can I skip or reschedule bookings?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit the value of the booking to your account. You can use this credit on future cleanings and other Helperland services.</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
						<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>Do I need to be home for the booking?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">We strongly recommend that you are home for the first clean of your booking to show your cleaner around. Some customers choose to give a spare key to their cleaner, but this decision is based on individual preferences.</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
					</div><!-- END_QUESTIONS -->
				</div><!-- END_TAB_CONTENT -->
				<div class="tab_content d_none">
					<div class="questions">
					<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>How much do service providers earn?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">The self-employed service providers working with Helperland set their own payouts, this means that they decide how much they earn per hour.</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
						<div class="accordion">
							<div class="question">
								<button class="accordion_btn"><img src="<?= assets('assets/img/buttons/angle/angle_right_circle.png'); ?>" alt=""><p>What support do you provide to the service providers?</p></button>
							</div>
							<div class="accordion_content">
								<p class="answer">Our call-centre is available to assist the service providers with all queries or issues in regards to their bookings during office hours. Before a service provider starts receiving jobs, every individual partner receives an orientation session to familiarise with the online platform and their profile.</p>
							</div><!-- END_ACCORDION_CONTENT -->
						</div><!-- END_ACCORDION -->
					</div>
				</div><!-- END_TAB_CONTENT -->
			</div><!-- END_TAB_BODY -->
		</div><!-- END_TAB_CONTAINER -->
	</div><!-- END_USR_FAQ -->
</main><!-- END_MAIN -->

<?= component('footer') ?>
