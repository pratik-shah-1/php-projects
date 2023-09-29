@extends('admin.master')
@section('title','Admin-Products')
@section('content')
<main>

	<div class="manage_product_top">
		<form id="search">
			<select name="book_category">
			@foreach($category as $c)
				<option value="{{$c->category}}">{{$c->category}}</option>
			@endforeach
			</select>
			<input type="text" placeholder="Search Product By Title or Author Category">
			<button><i class="fas fa-search"></i></button>			
		</form>
	</div>

	<!-- Product Container -->
    <div class='product_container'>
    @if(count($products)==0)
		<p class='display-4'>You Haven't Any Product Please Add Product...</p>
	@endif
	@foreach($products as $p)		
		<form onsubmit="return false;" mathod='POST' class='product'>
			<div> <a href="/admin/product/view/{{$p->id}}">
				  <img src='{{asset($p->img)}}' alt=''></a> </div>
			<div>
				<p>{{$p->name}}</p>
				<p>{{$p->details}}</p>
				<p>Price : ₹{{$p->price}} </p>
				@if($p->orders==0)
					<button class='btn btn-light'>No Orders</button>
				@else
					<button class='btn btn-dark'>{{$p->orders}} : Orders</button>
				@endif
			</div>
		</form>
	@endforeach
    </div>
</main>
@endsection