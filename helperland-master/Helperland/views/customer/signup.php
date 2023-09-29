<?= component('header'); ?>

<!-- **********CUSTOMER_SIGNUP********** -->
<div class="customer_signup">

    <div class="title_with_icon">
		<p>Create an Account</p>
		<div>
			<div><img src="<?= assets('assets/img/global/separator.png'); ?>" alt=""></div>
		</div>
	</div>
	<form id="customer_signup">
        <div>
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
		</div>
        <div>
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
		</div>
        <div>
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
        </div>
        <div>
            <input type="checkbox" name="TermCheckBox">
            <label for="">I have read the <a href="javascript:void(0)">privacy policy</a></label>
        </div>
        <div>
			<input type="hidden" name="role" value="1">
            <button class="form_btn" disabled>Register</button>
        </div>
        <div>
            <p>Already Register? <a href="javascript:void(0)" onclick="open_model('login')">Login Now</a></p>
        </div>
    </form>
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

	$('#customer_signup').submit((e)=>{
		e.preventDefault();
		let validation = true;;
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
								title : 'Good job!',
								text : result.message,
								icon : 'success'
							}).then((res)=>{
								if(res.isConfirmed){
									$('#customer_signup').trigger('reset');
									$('.form_btn').prop('disabled', true);
								}
							});
						}
						catch(e){
							console.log('Invalid Json Response!!!');
							Swal.fire({
								title : 'Server Error',
								text : 'Invalid Response Coming From Server!!!',
								icon : 'error'
							});
						}
					}
				}
			});
		}
	});
</script>

