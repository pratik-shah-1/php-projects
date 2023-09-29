@extends('admin.master')
@section('title','Admin-Coupon')
@section('content')
<div class="overflow-auto">
	@if(count($coupons)==0)
		<p class="display-4 mt-5 text-center">No Coupons, Please Add!!!</p>			
	@endif
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th class="h5 font-weight-normal">Index</th>
				<th class="h5 font-weight-normal">Coupon Code</th>
				<th class="h5 font-weight-normal">Discount</th>
				<th class="h5 font-weight-normal">Expiry-YY/MM/DD</th>
				<th class="h5 font-weight-normal">Action</th>
			</tr>
		</thead>
		<tbody>
			@php
				$i=0;
			@endphp
			@foreach($coupons as $coupon)
			<tr>
				<td class="h5 font-weight-normal">{{++$i}}</td>
				<td class="h5 font-weight-normal">{{$coupon->code}}</td>
				<td class="h5 font-weight-normal">{{$coupon->discount}}%</td>
				<td class="h5 font-weight-normal">{{$coupon->expiry}}</td>
				<td class="d-flex">
					<a class="btn btn-warning mr-3" href="#" onclick="edit_coupon(`{{$coupon->id}}`,`{{$coupon->code}}`,`{{$coupon->discount}}`,`{{$coupon->expiry}}`);">Edit</a>
					<a class="btn btn-danger" href="/admin/coupon/delete/{{$coupon->id}}">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<br>
	<br>
</div>

<div class="coupon_code_form d-none">

	<div class="bg-dark">
		<h5 class="font-weight-normal m-0 px-3 text-light" name='title'>Coupon</h5>
		<button class="rounded-circle add_coupon_btn btn">
			<i class="fas fa-times text-danger"></i>
		</button>			
	</div>

	<form method="POST" action="/admin/coupon/action">
		@csrf
		<input type="text" name="id" hidden="hide">
		<input type="text" placeholder="New Coupon Code" name="code" required>
		<input type="text" placeholder="Discount? Enter only Number" name="discount" required>
		<input type="date" name="expiry" required>
		<!-- This is Below button for Update of Add Coupon Code -->
		<button class="btn" name="btn">ADD</button>		
	</form>
</div>

<!-- This is Below Button for Open Dilouge Box of Coupon Code  -->
<button class="position-fixed rounded-circle btn btn-primary add_coupon_btn" style="right:30px; bottom:30px">
	<i class="fas fa-plus"></i>
</button>

<script>	
	//Dilougue Box  Open for ADD ...
	$('.add_coupon_btn').click(function(){
		$('.coupon_code_form').toggleClass('d-none');
		$('.random').toggleClass('backlight');
		$('[name="id"]').val('');
		$('[name="code"]').val('');
		$('[name="discount"]').val('');
		$('[name="expiry"]').val('');
		$('[name="title"]').html('Add New Coupon');
		$('[name="btn"]').html('ADD');
	});

	function edit_coupon(id, code, discount, expiry){
		$('.coupon_code_form').toggleClass('d-none');
		$('.random').toggleClass('backlight');
		$('[name="id"]').val(id);
		$('[name="code"]').val(code);
		$('[name="discount"]').val(discount);
		$('[name="expiry"]').val(expiry);
		$('[name="title"]').html('Update Coupon');
		$('[name="btn"]').html('UPDATE');
	}

</script>
@endsection