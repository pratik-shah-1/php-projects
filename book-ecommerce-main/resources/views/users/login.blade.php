@extends('users.master')
@section('title','MyBooks-Login')
@section('content')

@if(session('disable'))
	<script>swal('Account is Disabled','Ask to Admin','warning');</script>
@endif

@if(session('wrong'))
	<script>swal('Please Enter Correct Details!!!','','error');</script>
@endif

@if(session('signup'))
	<script>swal('Signup Successfully...','','success');</script>
@endif

@if(session('update'))
	<script>swal('Password Change Successfully...','','success');</script>
@endif

@if(session('error'))
	<script>swal('Try Again','','error');</script>
@endif

<main class="my-5 px-3 px-lg-0">	
	<form class="u_login" method="POST" action="/signin" onsubmit="return login(this);">
		<!-- CSRT Protection -->
		@csrf
		<!-- Title -->
		<p>Login Form</p>
		<div class="section_1">
			<div> 
				<input class="form-control" type="text" placeholder="Email Address" name="email" >
				<p class='m-0 small d-none text-danger pt-1 email_error_msg'>Email Address is Required!!!</p>
			</div>
			<div class='mt-0 pt-0'> 
				<input class="form-control" type="password" placeholder="Password" name="pswd"> 
				<p class='m-0 d-none small text-danger pt-1 pswd_error_msg'>Password must be required!!!</p>
			</div>
			<div> <input class='btn btn-outline-primary' type="submit" value="LOGIN" > </div>
		</div>
		<div class="section_2"> <a href="" class="forgot_btn">Forgot Password?</a> </div>
		<div class='d-flex flex-row justify-content-center pt-2'>
			<p class='m-0 mr-2'>Not a Member?</p>
			<a class='signup_btn' href="">Signup</a>
		</div>
		<hr>
		<!-- Signup Via Gmail or Facebook -->
		<div class="section_3">
			<button><img src="assets\img\svg\google.svg">Login by Gmail</button>
			<button><img src="assets\img\svg\facebook.svg">Login by Facebook</button>
		</div>
	</form>

	<form class="u_signup d-none" action="/signup" method="POST">
		@csrf
		<p>SignUp Form</p>
		<div>
			<label>Full Name<span>*</span> </label>
			<input class="form-control" type="text" name="name" required>
			<p class='name_error_msg d-none m-0 small text-danger pt-1'>Name is Required!!!</p>
		</div>
		<div>
			<label>Phone Number<span></span> </label>
			<input class="form-control" type="number" name="mobile" required>
			 <p class='mobile_error_msg d-none m-0 small text-danger pt-1 '>Phone is Required!!!</p>
		</div>
		<div>
			<label>Email Address<span>*</span> </label>
			<input class="form-control" type="Email" name="email" required>
			 <p class='email_error_msg d-none m-0 small text-danger pt-1 '>Email Address is Required!!!</p>
		</div>
		<div>
			<label>Password<span>*</span> </label>
			<input class="form-control" type="Password" name="pswd" required>
			 <p class='pswd_error_msg d-none m-0 small text-danger pt-1 '>Password is Required!!!</p>
		</div>
		<div>
			<label>Confirm Password<span>*</span> </label>
			<input class="form-control" type="Password" name="cpswd"  required>
			 <p class='cpswd_error_msg d-none m-0 small text-danger pt-1 '>Password must be match!!!</p>
		</div>
		<div><input class='btn btn-outline-primary mt-2' type="submit" value="SignUp" name="submit"></div>
		<div class='flex-row justify-content-center pt-2'>
			<p class='m-0 mr-2'>Already a Member?</p>
			<a class='login_btn' href="">Login</a>
		</div>
	</form>

	<!-- Forgot Password -->
<!-- 	<form class="forgot_pswd d-none" id="forgot_pswd" action="/send_otp" method="POST">
		@csrf
		<p>Forgot Password</p>
		<div class="mb-0">
			<input type="text" placeholder="Email Address" name="email" required>
			<input type="submit" value="NEXT" class="btn btn-outline-primary mt-3" required>
			<p class="text-center mt-3">Want to<a href="#" class="login_btn"> Login?</a></p>			
		</div>
	</form>

	<form class="forgot_pswd d-none" id="otp_section" method="POST" action="/check_otp">
		@csrf
		<p>OTP Section</p>
		<div>
			<input type="text" placeholder="Enter OTP" name="otp" required>
			<input type="submit" value="NEXT" class="btn btn-outline-primary" name="submit" required>			
		</div>
	</form>

	<form class="forgot_pswd d-none" id="set_new_pswd" action="/new_password" method="POST">
		@csrf
		<p>Set New Password</p>
		<div>
			<input type="text" value="" name="email" class="d-none" required>
			<input type="password" placeholder="New Password" name="npswd" required>
			<input class="mt-3" type="password" placeholder="Confirm Password" name="cpswd" required>
			<input type="submit" value="SUBMIT" class="btn btn-outline-primary" required>
		</div>
	</form> -->
</main>


<script>
	//Change Signup to Login
	$('.login_btn').click(function(e){
		e.preventDefault();
		$('.u_login').removeClass('d-none').trigger('reset');
		$('.u_signup').addClass('d-none');
	});

	$('.signup_btn').click(function(e){
		e.preventDefault();
		$('.u_signup').removeClass('d-none').trigger('reset');
		$('.u_login').addClass('d-none');
	});

	//-----------------------------------------------------
	//			 Email Validation
	//-----------------------------------------------------
	$('[name="email"]').focusout(function(){
		const val = $(this).val();
		const reg = /^[a-zA-Z0-9.]+@[a-zA-Z0-9]+(\.[a-zA-Z]{2,})+$/;
		$('.email_error_msg').removeClass('d-none').html('');
        if(val == ""){
        	$('.email_error_msg').html('Email Address cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
        	$('.email_error_msg').html('Please Enter Valid Email Address!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.email_error_msg').html('').addClass('d-none');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
	});


	//-----------------------------------------------------
	//			Password Validation
	//-----------------------------------------------------
	$('[name="pswd"]').focusout(function(){
		const val = $(this).val();
		const reg = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;        
		
		$('.pswd_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
        	$('.pswd_error_msg').html('Password Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
        	$('.pswd_error_msg').html('Make combo of special character digits and capital!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.pswd_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
	});

	$('[name="cpswd"]').keyup(function(){
		const val = $(this).val();
		const prev_val = $('[name="pswd"]:nth(1)').val();

		$('.cpswd_error_msg').removeClass('d-none').html('');
        if(val == ""){
        	$('.cpswd_error_msg').html('Confirm Password Filed Cannot be Blank !!!');
            $(this).addClass('is-invalid');
        }
        else if(val != prev_val){
        	$('.cpswd_error_msg').html('Password and Confirm Password Not Match!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.cpswd_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
	});
	//-----------------------------------------------------
	//			Mobile Validation
	//-----------------------------------------------------
	$('[name="mobile"]').focusout(function(){
		const val = $(this).val();
		const reg = /^[0-9]{10}$/;

		$('.mobile_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
        	$('.mobile_error_msg').html('Mobile Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
        	$('.mobile_error_msg').html('Mobile Number Must be 10 Digits!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.mobile_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
	});

	//-----------------------------------------------------
	//			Full Name Validation
	//-----------------------------------------------------
	$('[name="name"]').focusout(function(){
		const val = $(this).val();
		const reg = /^[A-Za-z]/;        
		$('.name_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
        	$('.name_error_msg').html('Name Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
        	$('.name_error_msg').html('Please Enter only Alphabets !!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.name_error_msg').html('');
            $(this).addClass('is-valid').removeClass('is-invalid');
        }
	});

</script>
@endsection	
	
