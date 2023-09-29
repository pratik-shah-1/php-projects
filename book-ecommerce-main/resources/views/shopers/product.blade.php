@extends('shopers.master')

@section('title','Shopers-Product')

@section('content')
<main class="container py-5">
	<div class='product_view rounded'>
		<div class='product_dropdown'>
			<button class='btn btn-warning product_dropdown_btn' data-toggle='collapse' data-target='#p_id_{{$book->id}}'>Action</button>
			<div class='product_dropdown_menu collapse' id='p_id_{{$book->id}}'>
				<ul>
					<li><a href='/shoper/product/update_form/{{$book->id}}'>Update</a></li>
					<li><a href='/shoper/product/delete/{{$book->id}}'>Delete</a></li>
				</ul>
			</div>
		</div>			
		<div class='product_info'>
			<div class='product_img'> 
				<img src='{{asset($book->img)}}'>
			</div>
			<div class='product_name'><!-- Inner Div For Info of Product -->
				<div> <p>Book Name</p> <span>:</span> <p>{{$book->name}}</p></div>
				<div> <p>Author</p> <span>:</span> <p>{{$book->author}}</p> </div>
				<div> <p>ISBN</p> <span>:</span> <p>{{$book->isbn}}</p> </div>
				<div> <p>Pages</p> <span>:</span> <p>{{$book->pages}}</p> </div>
				<div> <p>Language</p> <span>:</span> <p>{{$book->lang}}</p> </div>
				<div> <p>Quantity</p> <span>:</span> <p>{{$book->quantity}}</p> </div>
				<div> <p>Price</p> <span>:</span> <p>{{$book->price}}</p> </div>
				<div><!-- This div is For Not Affects Css to a Price Div--></div>
			</div>
		</div>
		<div class='product_details'>
			<p>Product Description</p>
			<p>{{$book->details}}</p>
		</div>
	</div>
</main>
@endsection