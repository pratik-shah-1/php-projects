@extends('users.master')
@section('title','Payment-Checkout')
@section('content')
<div class="checkout">
	<p>CHECKOUT</p>
	<form action="/checkout_process" method="POST">
		@csrf
		<input type="text" name="total_amount" value="{{$total_amount}}" class="d-none">
		<input type="text" name="coupon_code" value="{{$coupon_code}}" class="d-none">
		<div>
			<div>
				<label for="">Full Name</label>
				<input class="form-control" type="text" name="name" placeholder="Name" value="{{$user->name}}" required>
				<p class="name_error_msg d-none small text-danger m-0 pt-1"></p>
			</div>
			<div>
				<label for="">Email Address</label>
				<input class="form-control" type="text" name="email" placeholder="Email Address" value="{{$user->email}}" readonly required>	
				<p class="error_error_msg d-none small text-danger m-0 pt-1"></p>
			</div>
		</div>
		<div>
			<div>
				<label for="">Mobile</label>
				<input class="form-control" type="text" name="mobile" placeholder="Mobile" value="{{$user->mobile}}" required>
				<p class="mobile_error_msg d-none small text-danger m-0 pt-1"></p>
			</div>
			<div>
				<label for="">Zip Code</label>
				<input class="form-control" type="text" name="zcode" placeholder="Zip Code" value="{{$user->zcode}}" required>	
				<p class="zcode_error_msg d-none small text-danger m-0 pt-1"></p>
			</div>
		</div>
		<div>
			<div>
				<label for="">Address</label>
				<textarea name="address" placeholder="Address" required>{{$user->address}}</textarea>
			</div>
		</div>
		<div>
			<select name="payment_method">
				<option value="cod">Cash on Delivery</option>
				<option value="online">Online Payment</option>
			</select>
			<button class="btn btn-danger">CHECKOUT</button>
		</div>
	</form>
</div>
<script>

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
	//			Zip Code Validation
	//-----------------------------------------------------
	$('[name="zcode"]').focusout(function(){
		const val = $(this).val();
		const reg = /^[0-9]{6}$/;

		$('.zcode_error_msg').removeClass('d-none').html('');
        
        if(val == ""){
        	$('.zcode_error_msg').html('Zip Code Field cannot be blank!');
            $(this).addClass('is-invalid');
        }
        else if(!reg.test(val)){
        	$('.zcode_error_msg').html('Zip Code Must be 6 Digits!!!');
            $(this).addClass('is-invalid');
        }
        else{
            $('.zcode_error_msg').html('');
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