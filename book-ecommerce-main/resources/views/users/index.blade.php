@extends('users.master')
@section('title','MyBooks')
@section('content')
@if(count($slider)!=0)
<div class="swiper-container">
    <div class="swiper-wrapper">
    	@foreach($slider as $s)
      	<div class="swiper-slide">
      		<img src="{{$s->img}}" alt="">
      	</div>
      	@endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<script>
var swiper = new Swiper('.swiper-container', {
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
</script>
@endif

<main>
	<div class="index_right">
		<div class='product_container'>
			@foreach($books as $book)
			<div class='product'>
				<div> <a href='product/view/{{$book->id}}'> <img src="{{asset($book->img)}}" alt=''> </a> </div>
				<div>
					<p>{{$book->name}}</p>
					<p>{{$book->details}}</p>
					<p>Price : ₹ {{$book->price}}</p>
					<button class='btn btn-outline-primary' onclick='AddToCart(`{{$book->id}}`);'><span class="h6">Add to Cart</span><i class='fas fa-shopping-cart'></i></button>
				</div>
			</div>
			@endforeach
		</div><!-- End of Book-Container -->	
	</div>
</main>
@endsection

<!-- 		<div class="mt-4 ml-sm-5 ml-4 mr-sm-5 mr-4 swiper-container" style='z-index:1;'>
			<div class="swiper-wrapper">
				@foreach($books as $book)
				<div class='product swiper-slide'>
					<div> <a href="product/view/{{$book->id}}"> <img src="{{asset($book->img)}}" alt=''> </a> </div>
					<div>
						<p>{{$book->name}}</p>
						<p>{{$book->details}}</p>
						<p>Price : ₹ {{$book->price}}</p>
						<button class='btn btn-outline-primary' onclick="AddToCart(`{{$book->id}}`);">Add to Cart<i class='fas fa-shopping-cart'></i></button>
					</div>
				</div>
				@endforeach
			</div>
			<div class='mt-3'></div> For getting margin top something... -->
		  	<!-- <div class="swiper-pagination"></div> -->
		<!-- </div> -->