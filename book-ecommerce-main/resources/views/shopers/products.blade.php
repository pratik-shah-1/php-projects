@extends('shopers.master')

@section('title','Shopers-Products')

@section('content')

@if(session()->has('update'))
	<script>swal('Product Updated  Successfully','','success');</script>
@endif

@if(session()->has('add'))
	<script>swal('Product Added  Successfully','','success');</script>
@endif

<!-- Main Container -->
<main>
	<!-- Product Manage Top -->
	<div class="manage_product_top">
		<form id="search">
			<select name="book_category" id="">
				@foreach($category as $i)
					<option value="{{$i->category}}">{{$i->category}}</option>
				@endforeach
			</select>
			<input type="text" placeholder="Search Product By Title or Author Category">
			<button><i class="fas fa-search"></i></button>			
		</form>
	</div>

    <div class='product_container'>

    	@if(count($books)==0)
			<p class="text-center display-4 mt-5">You Haven't Any Products</p>
    	@endif

    	@foreach($books as $book)		
		<form onsubmit="return false;" mathod='GET' class='product'>
			<div>
				<a href="/shoper/product/view/{{$book->product_id}}">
				<img src="{{asset($book->img)}}" alt=''></a></div>
			<div>
				<p>{{$book->name}}</p>
				<p>{{$book->details}}</p>
				<p>Price : ₹ {{$book->price}}</p>
				<div class='product_dropdown'>
					<!-- Here p_d_m_ meand Product_Dropdown_Menu... -->
					<button class='btn btn-warning product_dropdown_btn' data-toggle='collapse' data-target='#p_d_m_{{$book->product_id}}'>Action</button>
					<div class='product_dropdown_menu collapse' id='p_d_m_{{$book->product_id}}'>
						<ul>
							<li><a href='/shoper/product/update_form/{{$book->product_id}}'>Update</a></li>
							<li><a href='/shoper/product/delete/{{$book->product_id}}'>Delete</a></li>
						</ul>
					</div>
				</div>
			</div>
		</form>
		@endforeach
    </div>
</main>
@endsection