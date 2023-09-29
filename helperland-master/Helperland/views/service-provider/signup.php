<?= component('header'); ?>

<!-- **********SECTION_1********** -->
<div class="become_a_pro_s1">

	<!-- BACKGROUND_IMG -->
	<img class="become_a_pro_s1_bg" src="<?= assets('assets/img/service_provider/landing_page.png'); ?>" alt="">

    <!-- REGISTRATION_FORM -->
    <div class="registration_form">
        <p>Register Now!</p>
        <form id="sp_signup">
			<div class="form_group">
				<input class="input" type="text" placeholder="First Name" name="firstname">
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
			<div class="form_group">
				<input class="input" type="text" placeholder="Last Name" name="lastname">
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
			<div class="form_group">
				<input class="input" type="text" placeholder="Email Address" name="email">
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
			<div class="form_group">
				<div class="phone_number">
					<label for="">+46</label>
					<input type="text" placeholder="Phone Number" name="phone">
				</div>	
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
			<div class="form_group">
				<input class="input" type="password" placeholder="Password" name="password">
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
			<div class="form_group">
				<input class="input" type="password" placeholder="Confirm Password" name="cpassword">
				<div class="validation_message d_none">
					<p>Validation Message!!!</p>
				</div>
			</div>
            <div>
                <input type="checkbox"><p>Send me newsletters from Helperland</p>
            </div>
            <div>
                <input type="checkbox" name="TermCheckBox"><p>I accept <a href="javascript:void(0)">terms and conditions</a> & <a href="javascript:void(0)">privacy policy</a></p>
            </div>
			<input type="hidden" name="role" value="2">
            <button class="form_btn" disabled>Get Started <img src="<?= assets('assets/img/buttons/arrow/arrow_right_white.png'); ?>" alt=""></button>
        </form>
    </div>

	<!-- DOWN_BTN -->
	<button class="home_s1_down_btn"><img src="<?= assets('assets/img/buttons/down_btn.png'); ?>" alt=""></button>

</div><!-- END_SECTION_1 -->

<div class="become_a_pro_s2">

	<!-- SECTION_BACKGROUND -->
	<img class="become_a_pro_s2_bg_left" src="<?= assets('assets/img/service_provider/bg_left.png'); ?>">
	<img class="become_a_pro_s2_bg_right" src="<?= assets('assets/img/service_provider/bg_right.png'); ?>">

	<!-- SECTION_TITLE -->
	<p class="home_section_title">How it works</p>

	<!-- SECTION_CARD_CONTAINER -->
	<div class="become_a_pro_s2_card_container">
		<div class="become_a_pro_s2_card">
			<div>
				<p>Register yourself</p>
				<p>Provide your basic information to register yourself as a service provider.</p>
				<a href="javascript:void(0)">Read more <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
			</div>
			<img src="<?= assets('assets/img/service_provider/laptop.png'); ?>" alt="">
		</div>

		<div class="become_a_pro_s2_card">
			<img src="<?= assets('assets/img/service_provider/clean.png'); ?>" alt="">
			<div>
				<p>Get service requests</p>
				<p>You will get service requests from customes depend on service area and profile.</p>
				<a href="javascript:void(0)">Read more <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
			</div>
		</div>

		<div class="become_a_pro_s2_card">
			<div>
				<p>Complete service</p>
				<p>Accept service requests from your customers and complete your work.</p>
				<a href="javascript:void(0)">Read more <img src="<?= assets('assets/img/buttons/arrow/arrow_right_black.png'); ?>" alt=""></a>
			</div>
			<img src="<?= assets('assets/img/service_provider/cleaning.png'); ?>" alt="">
		</div>
	</div>
</div>

<?= component('footer'); ?>

<!-- **********SCRIPT FOR REGISTRATION********** -->
<script>

	$('[name="TermCheckBox"]').click(()=>{
		if($('[name="TermCheckBox"]').prop('checked')){
			$('.form_btn').prop('disabled', false);
		}
		else{
			$('.form_btn').prop('disabled', true);
		}
	});

	$('#sp_signup').submit((e)=>{

		e.preventDefault();

		let validation = true;

		const validationArr = [firstname_validation(),
								lastname_validation(),
								email_validation(),
								phone_validation(),
								password_validation(),
								cpassword_validation()];

		for(let i=0; i<validationArr.length; i++){
			if(validationArr[i]==false){
				validation = false;
				break;
			}	
		}

		let json = JSON.stringify({
			firstName : $('[name="firstname"]').val(),
			lastName : $('[name="lastname"]').val(),
			email : $('[name="email"]').val(),
			phone : $('[name="phone"]').val(),
			password : $('[name="password"]').val(),
			confirmPassword : $('[name="cpassword"]').val(),
			role : $('[name="role"]').val()	
		})

		if(validation){
			$.ajax({
				url : `${BASE_URL}/signup`,
				method : 'POST',
				contentType : 'application/json',
				data : json,
				success : function(res){
					if(res!==undefined && res!==""){
						try{
							const result = JSON.parse(res);
							Swal.fire({
								title : result.message,
								text : 'You need to active your account by admin',
								icon : 'success'
							});
							$('#sp_signup').trigger('reset');
							$('.form_btn').prop('disabled', true);
						}
						catch(e){
							console.log('Invalid Json Response');
							Swal.fire({
								title : 'Server Error',
								text : 'Invalid JSON Response',
								icon : 'error'
							});
						}
					}
				}
			});
		}
	});
</script>
