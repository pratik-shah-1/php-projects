<?= component('header'); ?>

<!-- **********CONTACT_MAIN********** -->

<!-- CONTACT_PAGE_BANNER -->
<div class="banner">
	<img src="<?= assets('assets/img/banner/contact.png'); ?>" alt="">
</div>

<main>

	<!-- **********CONTACT_US********** -->
	<div class="contact">
		
		<!-- SECTION_1_TITLE -->
		<div class="title_with_icon">
			<p>Contact us</p>
			<div>
				<div><img src="<?= assets('assets/img/global/separator.png'); ?>" alt=""></div>
			</div>
		</div>

		<div class="contact_card_container">
			<div class="contact_card">
				<div><img src="<?= assets('assets/img/static/contact/section_1/location.png'); ?>" alt="" ></div>
				<div><p>1111 Lorem ipsum text 100,</p><p>Lorem ipsum AB</p></div>
			</div>
			<div class="contact_card">
				<div><img src="<?= assets('assets/img/static/contact/section_1/phone.png'); ?>" alt="" ></div>
				<div><p>+49 (40) 123 56 7890</p><p>+49 (40) 987 56 0000</p></div>
			</div>
			<div class="contact_card">
				<div><img src="<?= assets('assets/img/static/contact/section_1/envelope.png'); ?>" alt="" ></div>
				<div><p>info@helperland.com</p></div>
			</div>
		</div><!-- END_SECTION_1_CARD_CONTAINER -->

	</div><!-- END_CONTACT_US -->
	
	<hr class="contact_hr">

	<!-- **********GET_IN_TOUCH********** -->
	<div class="get_in_touch">
		<p class="get_in_touch_title">Get in touch with us</p>
		<form id="contact_us">
			<div>
				<div class="form_group">
					<input class="input" type="text" placeholder="First Name" name="firstname">
					<div class="validation_message d_none">
						<p>Validation Message</p>
					</div>
				</div>
				<div class="form_group">
					<input class="input" type="text" placeholder="Last Name" name="lastname">
					<div class="validation_message d_none">
						<p>Validation Message</p>
					</div>
				</div>
			</div>
			<div>
				<div class="form_group">
					<div class="phone_number">
						<label for="">+46</label>
						<input type="text" placeholder="Phone Number" name="phone">
					</div>		
					<div class="validation_message d_none">
						<p>Validation Message</p>
					</div>
				</div>
				<div class="form_group">
					<input class="input" type="text" placeholder="Email Address" name="email">
					<div class="validation_message d_none">
						<p>Validation Message</p>
					</div>
				</div>
			</div>
			<div class="form_group">
				<select class="select" name="subject" id="">
					<option value=""></option>
					<option value="General" selected>General</option>
					<option value="Inquiry">Inquiry</option>
					<option value="Renewal">Renewal</option>
					<option value="Revocation">Revocation</option>
				</select>
				<div class="validation_message d_none">
					<p>Validation Message</p>
				</div>
			</div>
			<div class="form_group">
				<textarea class="textarea" name="message" placeholder="Message"></textarea>
				<div class="validation_message d_none">
					<p>Validation Message</p>
				</div>
			</div>
			<div class="form_group">
				<label class="label" for="">Attachment</label>
				<div class="file_upload">
					<label for="attachment">Upload</label>
					<input type="file" id="attachment" name="attachment">
				</div>
				<div class="validation_message d_none">
					<p>Please Enter First Name!</p>
				</div>
			</div>
			<div>
				<input type="checkbox" name="TermCheckBox">
				<p>Our current ones apply <a href="javascript:void(0)">privacy policy</a> i hereby agree that my data entered into the contact form will be stored electronically and processed and used for the used for the purpose of establishing contact. the consent can be withdrawn at any time pursuant to art. 7(3) GDPR by informal notification (eg. by e-mail).</p>
			</div>
			<button class="form_btn" disabled>Submit</button>
		</form>
	</div><!-- END_GET_IN_TOUCH -->

	<!-- MAP -->
	<div class="map">
		<img src="<?= assets('assets/img/static/contact/section_2/map.png'); ?>" alt="">
	</div>

<main>


<!-- **********CONTACT-US-SCRIPTS********** -->
<script>

	<?php if(session('isLogged')){ ?>
		$('[name="firstname"]').val(store.loggedUserDetails.FirstName);
		$('[name="lastname"]').val(store.loggedUserDetails.LastName);
		$('[name="email"]').val(store.loggedUserDetails.Email);
		$('[name="phone"]').val(store.loggedUserDetails.Mobile);
	<?php } ?>

	$('[name="TermCheckBox"]').click(()=>{
		if($('[name="TermCheckBox"]').prop('checked')==true){
			$('.form_btn').prop('disabled', false);
		}
		else{
			$('.form_btn').prop('disabled', true);
		}
	});

	$('#contact_us').submit(function(e){
		e.preventDefault();
		$('.form_btn').prop('disabled', true);
		let validation = true;

		const validationArr = [firstname_validation(),
								lastname_validation(),
								email_validation(),
								phone_validation(),
								message_validation(),
								subject_validation()];

		for(let i=0; i<validationArr.length; i++){
			if(validationArr[i]==false){
				validation = false;
				break;
			}	
		}

		// FORM DATA FOR FILE UPLOAD...
		const data = new FormData();
		data.append('firstName', $('[name="firstname"]').val());
		data.append('lastName', $('[name="lastname"]').val());
		data.append('phone', $('[name="phone"]').val());
		data.append('email', $('[name="email"]').val());
		data.append('message', $('[name="message"]').val());
		data.append('subject', $('[name="subject"]').val());
		data.append('attachment', $('[name="attachment"]').prop('files')[0]);

		if(validation){
			$.ajax({
				url : `${BASE_URL}/contact`,
				type : 'POST',
				data : data,
				processData : false,
				contentType : false,
				success : function(res){
					if(res!=="" && res!==undefined){
						try{
							const result = JSON.parse(res);
							Swal.fire({
								title : 'Good job!',
								text : result.message,
								icon : 'success'
							});
							$('#contact_us').trigger('reset');
							$('.form_btn').prop('disabled', true);
						}
						catch(e){
							Swal.fire({
								title : 'Server Error',
								text : 'Invalid Response Coming From Server',
								icon : 'error'
							});
							$('.form_btn').prop('disabled', false);
						}
					}
				}
			});
		}
	});
</script>

<?= component('footer') ?>