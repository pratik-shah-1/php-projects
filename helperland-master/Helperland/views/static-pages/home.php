<?= component('header'); ?>

<!-- **********SECTION_1********** -->
<div class="home_s1">

	<!-- BACKGROUND_IMG -->
	<img class="home_s1_bg" src="<?= assets('assets/img/static/home/section_1/langing_page.png'); ?>" alt="">

	<!-- INTRO_CARD -->
	<div class="home_s1_intro_card">
		<p>Do not feel like housework?</p>
		<p>Great! Book now for Helperland and enjoy the benefits</p>
		<ul>
			<li><i class="fas fa-check"></i>certified & insured helper</li>
			<li><i class="fas fa-check"></i>easy booking procedure</li>
			<li><i class="fas fa-check"></i>friendly customer service</li>
			<li><i class="fas fa-check"></i>secure online payment method</li>
		</ul>
	</div>

	<!-- LET'S BOOKS A CLEANER -->
	<?php if(session('userRole')!=3 && session('userRole')!=2){ ?>
		<a class="home_s1_main_btn" href="<?= url('/book-now'); ?>" data-aos="fade-up">Let's Book a Cleaner</a>
	<?php } ?>

	<!-- SECTION_1_CARD_CONTAINER -->
	<div class="home_s1_card_container">
	
		<div class="home_s1_card" data-aos="fade-right" data-aos-delay="100">
			<img src="<?= assets('assets/img/static/home/section_1/step_1.png'); ?>" alt="">
			<p>Enter your postcode</p>
		</div>
	
		<img src="<?= assets('assets/img/static/home/section_1/up_curve.png'); ?>" alt="">
	
		<div class="home_s1_card" data-aos="fade-right" data-aos-delay="101">
			<img src="<?= assets('assets/img/static/home/section_1/step_2.png'); ?>" alt="">
			<p>Select your plan</p>
		</div>
	
		<img src="<?= assets('assets/img/static/home/section_1/down_curve.png'); ?>" alt="">
	
		<div class="home_s1_card" data-aos="fade-right" data-aos-delay="102">
			<img src="<?= assets('assets/img/static/home/section_1/step_3.png'); ?>" alt="">
			<p>Pay securely online</p>
		</div>
	
		<img src="<?= assets('assets/img/static/home/section_1/up_curve.png'); ?>" alt="">
	
		<div class="home_s1_card" data-aos="fade-right" data-aos-delay="103">
			<img src="<?= assets('assets/img/static/home/section_1/step_4.png'); ?>" alt="">
			<p>Enjoy amazing service</p>
		</div>
	
	</div><!-- END_SECTION_1_CARD_CONTAINER -->

	<!-- DOWN_BTN -->
	<button class="home_s1_down_btn circle" target="#home_s2"><img src="<?= assets('assets/img/buttons/down_btn.png'); ?>" alt=""></button>

</div><!-- END_SECTION_1 -->


<!-- **********SECTION_2********** -->
<div class="home_s2" id="home_s2">

	<!-- SECTION_2_TITLE -->
	<p class="home_section_title">Why Helperland</p>

	<!-- SECTION_2_CARD_CONTAINER -->
	<div class="home_s2_card_container">
		<div class="home_s2_card" data-aos="zoom-in" data-aos-delay="100">
			<div class="circle">
				<img src="<?= assets('assets/img/static/home/section_2/helper.jpg'); ?>" alt="">
			</div>
			<div>
				<p>Experience & Vetted Professionals</p>
				<p>dominate the industry in scale and scope with an adaptable, extensive network that consistently delivers exceptional results.</p>
			</div>
		</div>
		<div class="home_s2_card" data-aos="zoom-in" data-aos-delay="103">
			<div class="circle">
				<img src="<?= assets('assets/img/static/home/section_2/laptop.jpg'); ?>" alt="">
			</div>
			<div>
				<p>Secure Online Payment</p>
				<p>Payment is processed securely online. Customers pay safely online and manage the booking.</p>
			</div>
		</div>
		<div class="home_s2_card" data-aos="zoom-in" data-aos-delay="104">
			<div class="circle">
				<img src="<?= assets('assets/img/static/home/section_2/custom_service.jpg'); ?>" alt="">
			</div>
			<div>
				<p>Dedicated Customer Service</p>
				<p>to our customers and are guided in all we do by their needs. The team is always happy to support you and offer all the information.</p>
			</div>
		</div>
	</div><!-- END_SECTION_2_CARD_CONTAIENR -->

</div><!-- END_SECTION_2 -->


<!-- **********SECTION_3********** -->
<div class="home_s3">

	<!-- SECTION_3_BACKGROUND -->
	<img class="home_s3_bg_left" src="<?= assets('assets/img/static/home/section_3/bg_left.png'); ?>" alt="">
	<img class="home_s3_bg_right" src="<?= assets('assets/img/static/home/section_3/bg_right.png'); ?>" alt="">

	<!-- SECTION_3_INTRO -->
	<div class="home_s3_intro">
		<div data-aos="zoom-in-right" data-aos-delay="100">
			<p>We don't know what makes you happy, but...</p>
			<p>if it's not dusting, our friendly helpers will relieve you of this burden. Don't fret anymore that valuable time is wasted on housework, but enjoy life to the full. You are worth filling your time with beautiful experiences. Free yourself at last and enjoy the time you have gained: go partying, unwind, play with your children, meet up with friends or dare a bungee jump. You can find more leisure ideas and exclusive events in our blog - guaranteed free of dust and cleaning tips!</p>	
		</div>
		<img data-tilt data-aos="zoom-in-left" data-aos-delay="103" src="<?= assets('assets/img/static/home/section_2/intro_img.png'); ?>" alt="">
	</div>		

	<!-- SECTION_3_BLOG_TITILE -->
	<p class="home_section_title">Our Blog</p>

	<!-- SECTION_3_CARD_CONTAINER -->
	<div class="home_s3_card_container">
		<div class="home_s3_card" data-aos="fade" data-aos-delay="100">
			<img src="<?= assets('assets/img/static/home/section_3/blog_1.png'); ?>" alt="">
			<div>
				<p>Lorem ipsum dolor sit amet</p>
				<span>January 28, 2019</span>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet.</p>
			</div>
			<a href="javascript:void(0)">Read the Post <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>
		<div class="home_s3_card" data-aos="fade" data-aos-delay="102">
			<img src="<?= assets('assets/img/static/home/section_3/blog_2.png'); ?>" alt="">
			<div>
				<p>Lorem ipsum dolor sit amet</p>
				<span>January 28, 2019</span>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet.</p>
			</div>
			<a href="javascript:void(0)">Read the Post <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>
		<div class="home_s3_card" data-aos="fade" data-aos-delay="103">
			<img src="<?= assets('assets/img/static/home/section_3/blog_3.png'); ?>" alt="">
			<div>
				<p>Lorem ipsum dolor sit amet</p>
				<span>January 28, 2019</span>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet.</p>
			</div>
			<a href="javascript:void(0)">Read the Post <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>
	</div>

</div>

<!-- **********SECTION_4********** -->
<div class="home_s4">

	<!-- SECTION_4_TITLE -->
	<p class="home_section_title">What Our Customers Say</p>

	<!-- SECTION_4_CARD_CONTAINER -->
	<div class="home_s4_card_container"> 

		<div class="home_s4_card" data-aos="fade" data-aos-delay="100">
			<img src="<?= assets('assets/img/global/message.png'); ?>" alt="">
			<div class="home_s4_profile">
				<img src="<?= assets('assets/img/static/home/section_4/person_1.png'); ?>" alt="">
				<div><p>Lary Watson</p><span>Manchester</span></div>
			</div>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet consequat. Praesent nec malesuada nibh.</p>
			<p> Nullam et metus congue, auctor augue sit amet, consectetur tortor.</p>
			<a href="javascript:void(0)">Read More <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>			

		<div class="home_s4_card" data-aos="fade" data-aos-delay="101">
			<img src="<?= assets('assets/img/global/message.png'); ?>" alt="">
			<div class="home_s4_profile">
				<img src="<?= assets('assets/img/static/home/section_4/person_2.png'); ?>" alt="">
				<div><p>John Smith</p><span>Manchester</span></div>
			</div>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet consequat. Praesent nec malesuada nibh.</p>
			<p> Nullam et metus congue, auctor augue sit amet, consectetur tortor.</p>
			<a href="javascript:void(0)">Read More <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>			

		<div class="home_s4_card" data-aos="fade" data-aos-delay="102">
			<img src="<?= assets('assets/img/global/message.png'); ?>" alt="">
			<div class="home_s4_profile">
				<img src="<?= assets('assets/img/static/home/section_4/person_3.png'); ?>" alt="">
				<div><p>Lars Johnson</p><span>Manchester</span></div>
			</div>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar aliquet consequat. Praesent nec malesuada nibh.</p>
			<p> Nullam et metus congue, auctor augue sit amet, consectetur tortor.</p>
			<a href="javascript:void(0)">Read More <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
		</div>			
	</div>
</div><!-- END_SECTION_4 -->

<?= component('footer'); ?>
