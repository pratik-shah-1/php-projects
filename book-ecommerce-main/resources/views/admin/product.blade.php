@extends('admin.master')
@section('title','Admin-Product-Details')
@section('content')
<main class="container py-5">
	<div class='product_view rounded'>
		<div class='product_info'>
			<div class='product_img'> 
				<img src='{{asset($product->img)}}'>
			</div>
			<div class='product_name'><!-- Inner Div For Info of Product -->
				<div> <p>Book Name</p> <span>:</span> <p>{{$product->name}}</p> </div>
				<div> <p>Author</p> <span>:</span> <p>{{$product->author}}</p> </div>
				<div> <p>ISBN</p> <span>:</span> <p>{{$product->isbn}}</p> </div>
				<div> <p>Pages</p> <span>:</span> <p>{{$product->pages}}</p> </div>
				<div> <p>Language</p> <span>:</span> <p>{{$product->lang}}</p></div>
				<div> <p>Quantity</p> <span>:</span> <p>{{$product->quantity}}</p></div>
				<div> <p>Price</p> <span>:</span> <p>{{$product->price}}</p></div>
				<div><!-- This div is For Not Affects Css to a Price Div--></div>
			</div>
		</div>
		<div class='product_details'>
			<p>Product Description</p>
			<p>{{$product->details}}</p>
		</div>
	</div>
</main>
@endsection