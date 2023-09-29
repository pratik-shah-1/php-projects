@extends('admin.master')
@section('title','Admin')
@section('content')
@if(session()->has('signin'))
	<script>swal('Admin Login Successfully...','','success');</script>
@endif

<main>
	<div class="admin_cards">
		<div>
			<a href="/admin/slider"><i class="far fa-images text-info"></i><p>{{$slider}}</p><p>Slider Offers</p></a></div>
		<div >
			<a href="/admin/product_category"><i class="fas fa-th text-success"></i><p>{{$p_category}}</p><p>Product Category</p></a></div>
		<div>
			<a href="/admin/edu_category"><i class="fas fa-university text-secondary"></i><p>{{$e_category}}</p><p>Edu Category</p></a></div>
		<div>
			<a href="/admin/coupons"><i class="text-primary fas fa-gifts"></i><p>{{$coupons}}</p><p>Coupon Code</p></a></div>
		<div>
			<a href="/admin/complaints"><i class="text-danger fas fa-exclamation"></i><p>{{$complaints}}</p><p>Complaint</p></a></div>
		<div>
			<a href="/admin/orders"><i class="text-primary fas fa-shopping-bag"></i><p>{{$orders}}</p><p>Orders</p></a></div>
		<div>
			<a href="/admin/products"><i class="text-warning fas fa-swatchbook"></i><p>{{$products}}</p><p>Products</p></a></div>
		<div>
			<a href="/admin/shopers"><i class="text-info fas fa-store"></i><p>{{$shopers}}</p><p>Shopers</p></a></div>
		<div>
			<a href="/admin/users"><i class="text-warning fas fa-users"></i><p>{{$users}}</p><p>Users</p></a></div>
		<div>
			<a href="#"><i class="text-success fas fa-layer-group"></i><p>{{$selling}}</p><p>Selling</p></a></div>
	</div>
</main>
@endsection