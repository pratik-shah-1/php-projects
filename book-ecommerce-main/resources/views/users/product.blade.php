@extends('users.master')
@section('title','MyBooks-Product')
@section('content')
<main class="container my-5 ">
	<div class="product_view rounded">
		<div class="product_info">
			<div class="product_img">
				<img src="{{asset($book->img)}}" class='img-fluid'>		
			</div>
			<div class="product_name">
				<div> <p>Book Name</p> <span>:</span> <p>{{$book->name}}</p> </div>
				<div> <p>Author</p> <span>:</span> <p>{{$book->author}}</p> </div>
				<div> <p>Language</p> <span>:</span> <p>{{$book->lang}}</p> </div>
				<div> <p>Pages</p> <span>:</span> <p>{{$book->pages}}</p> </div>
				<div class="rating">
					<p>Rate</p> <span>:</span>
					<i class="text-warning fas fa-star"></i>
					<i class="ml-3 text-warning fas fa-star"></i>
					<i class="ml-3 text-warning fas fa-star"></i>
					<i class="ml-3 text-secondary fas fa-star"></i>
					<i class="ml-3 text-secondary fas fa-star"></i>
				</div>
				<div> <p>Price</p> <span>:</span> <p>₹ {{$book->price}}</p> </div>
				<div>
					<form class="d-flex" method="GET" action="/cart/item/add/{{$book->id}}">
						<div> <p>Quantity</p> <span>:</span> </div>
						<div>
							<input class="text-center border mr-3 rounded" type="text" style="width:30px;" value="1" readonly="read">
							<button class="btn-sm shodow-0 border-0 btn-primary py-1 ad_btn">Add to Cart</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="product_details">
			<p>Product Description</p>
			<p>{{$book->details}}</p>
		</div>
	</div>
</main>
@endsection