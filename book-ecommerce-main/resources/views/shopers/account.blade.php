@extends('shopers.master')
@section('title','Shopers-Account')
@section('content')
@if(session('update'))
	<script>swal('Update Successfully...','','success');</script>
@endif

<main>
	<div class='account'>
		<div class="a_left">
		   <ul>
		      	<li><img src="{{asset(session()->get('simg'))}}"><p>{{$shoper->name}}</p></li>
		     	<li><a href="#" onclick="Component('profile');">
		     		<i class="far fa-user"></i>Your Profile</a></li>
		      	<li><a href="#" onclick="Component('password');">
		      		<i class="fas fa-lock"></i>Change Password</a></li>
		      	<li><a href="#" onclick="Component('address');">
		      		<i class="fas fa-map-marker-alt"></i>Address</a></li>
		      	<li><a href="#" onclick="Component('delete');">
		      		<i class="far fa-trash-alt"></i>Delete Account</a></li>
		      	<li><a href="/shoper/signout">
		      		<i class="fas fa-sign-out-alt"></i>Logout</a></li>
		   </ul>
		</div>

		<div class="a_right px-lg-5 pt-5 px-4">

			<form class="person_info" action="/shoper/account/update/profile" method="POST" enctype="multipart/form-data">
				@csrf
				<h5 class='mb-3'>Your Information</h5>
				<div><label>Your Name</label><input type="text" name="name" value="{{$shoper->name}}" ></div>
				<div><label>Email Address</label><input type="text" name="email" value="{{$shoper->email}}" disabled></div>
				<div><label>Mobile</label><input type="text" name="mobile" value="{{$shoper->mobile}}"></div>
				<div class="custom-file">
				  <input type="file" name="img" class="custom-file-input" id="img">
				  <label class="custom-file-label m-0" for="img">Choose Profile Image</label>
				</div>
				<div><input class="btn btn-outline-primary" type="submit" value="Change / Update"></div>
			</form>

			<form class="change_pswd" action="/shoper/account/update/password" method="POST">
				@csrf
				<h5 class='mb-3'>Change Password</h5>
				<input type="password" name="pswd" placeholder="Old Password" required>
				<input type="password" name="npswd" placeholder="New Password" required>
				<input type="password" name="cpswd" placeholder="Confirm Password" required>
				<input class="btn btn-outline-primary" type="submit" value="Change">
			</form>

			<form class="del_account" action="/shoper/account/delete" method="POST">
				@csrf
				<h5 class="mb-3">Account Delete</h5>
				<textarea name="del_reason" placeholder="Why You Delete the Account?" required></textarea>
				<input type="password" placeholder="Password" name="pswd" required>
				<input type="submit" class="btn btn-danger"  value="Delete">
			</form>	

			<form class="person_adrs" action="/shoper/account/update/address" method="POST">
				@csrf
				<h5 class="mb-3">Address</h5>
				<div><label>State</label><select name="state" onchange="find_city(this.value)">
					@foreach($state as $s)
						<option value="{{$s->state}}">{{$s->state}}</option>
					@endforeach
				</select></div>
				<div><label>Citys</label><select name="city">
					@foreach($city as $c)
						<option value="{{$c->city}}">{{$c->city}}</option>
					@endforeach
				</select></div>
				<div><label>Delivery Address</label><textarea name="address" required>{{$shoper->address}}</textarea></div>
				<div><label>Zip Code</label><input type="text" name="zcode" value="{{$shoper->zcode}}" required></div>
				<div><input type="submit" name="btn" class="btn btn-outline-primary" value="UPDATE"></div>
			</form>
		</div><!-- End a_right -->
	</div><!-- End Acoount -->
</main>

<script>

	function Component(val){
		$('.a_right').children('form').addClass('d-none');
		if(val=='profile')
			$('.person_info').removeClass('d-none');
		else if(val=='password')
			$('.change_pswd').removeClass('d-none');
		else if(val=='address')
			$('.person_adrs').removeClass('d-none');
		else if(val=='delete')
			$('.del_account').removeClass('d-none');	
	}
	Component('profile');

	const db_state = `{{$shoper->state}}`;
	const db_city = `{{$shoper->city}}`;
	$('[name="state"]').val(db_state).change();
		
	//This function we have to fix in livewire...
	setTimeout(function(){
		$('[name="city"]').val(db_city).change();
	},2000);
	

	function find_city(state){
		const city_option = $('[name="city"]')[0];
		$.ajax({
			url:'/find_city/'+state, 
			method: 'GET',
			success:function(res){
				const city = JSON.parse(res);
				city_option.innerHTML = "";
				for(let i = 0; i< city.length; i++){
					city_option.innerHTML += "<option value='"+city[i]['city']+"'>"+city[i]['city']+"</option>";				
				}
			}
		});
	}

</script>
@endsection