@extends('users.master')
@section('title','MyBooks-Cart')
@section('content')
<!-- Main -->
<main class="my-5">
	<!-- Cart -->
	<div class="cart container-md container-fluid">
		<!-- Cart-Header -->
		<div class="cart_header"><p>Cart</p>
			<p><span class="badge badge-light rounded-circle mr-2">{{session()->get('cart_items')}}</span>Items</p>
		</div>
		<!-- Cart-Main -->
		<div class="cart_main">
			<div class="cart_left">
				@if(count($items)==0)
					<p class="text-center display-4 mt-5">You Have't add Any Items Yet</p>
				@endif
				@foreach($items as $item)
				<div class="cart_product">
					<div class="cart_product_img"><img src="{{asset($item->img )}}"></div>
					<div class="cart_product_info">
						<div class="cart_product_info_inner_1">
							<div> <p>Name</p> <span>:</span> <p>{{$item->name}}</p> </div>
							<div> <p>Pages</p> <span>:</span> <p>{{$item->pages}}</p> </div>
							<div> <p>Author</p> <span>:</span> <p>{{$item->author}}</p> </div>
							<div> <p>ISBN NO</p> <span>:</span> <p>{{$item->isbn}}</p> </div>
							<div> <p>Available</p> <span>:</span> <p>Abhi Thik Karna Hai</p> </div>
						</div>
						<div class="cart_product_info_inner_2">
							<div>
								<button class="decrease_item" onclick="DecreaseItem(`{{$item->id}}`);"><i class="fas fa-minus"></i></button>
								<input class="item_quantity" type="text" value="{{$item->cquantity}}" readonly>
								<button class="increase_item" onclick='IncreaseItem(`{{$item->id}}`);'><i class="fas fa-plus"></i></button>
								</div>
							<div> <button onclick="RemoveItem(`{{$item->id}}`);"  ><i class="fas fa-trash-alt"></i></button> </div>
							<div> <p>Rs.{{$item->price}}</p> </div>
							<div> <p>Shipping on 22,March</p> </div>
						</div>
					</div><!-- End Cart_Product-Info -->
				</div><!-- End Cart_Product -->				
				@endforeach
			</div><!-- End Cart_Left -->

			<!-- Right -->
			<div class="cart_right">
				<p>Price Details</p>
				<div class="cart_right_inner pb-0">
					<div><p>Product Amount <span>:</span></p><p>Rs.
					@if($delivery_charge==50)
						{{$total_amount-50}}
					@else
						{{$total_amount}}
					@endif</p></div>
					<div><p>Delivery Charge <span>:</span></p> <p>Rs.{{$delivery_charge}}</p></div>
					<div><p>GST Chagrge <span>:</span></p><p>Rs.0</p></div>
					<div>
						<div data-target="#coupon" data-toggle="collapse">
							<p>Apply Coupon Code <span>:</span></p><i class="fas fa-angle-double-down"></i>
						</div>
						<form class="collapse" id="coupon">
							<input  type="text" placeholder="Apply Code" name="coupon" value="MBOOK" onfocus="">							
						</form>
					</div>
					<div> <p>Total Price <span>:</span></p> <p>Rs.{{$total_amount}}</p> </div>
					<div>
						<form action="{{url('/checkout_form')}}" class="w-100" method="POST">
							@csrf
							<input type="text" name="total_amount" class="d-none" value="{{$total_amount}}">
							<input type="text" name="coupon_code" class="d-none">
							<button class="btn btn-primary w-100" {{$disable}}>CHECKOUT</button>
						</form> 
					</div>
				</div><!--End-inner Right -->			
			</div><!-- End-Right -->
		</div><!-- End Cart Main -->
	</div><!-- End-Cart -->
</main><!-- End Main -->

<script>
	var code = $('[name="coupon"]').val();
	$('[name="coupon_code"]').val(code);

	$('[name="coupon"]').focusout(function(){
		code = $(this).val();
		$('[name="coupon_code"]').val(code);
	});

	function IncreaseItem(p_id){
		window.location.href = '/cart/item/increase/'+p_id;
	}

	function DecreaseItem(p_id){
		window.location.href = '/cart/item/decrease/'+p_id;		
	}

	function RemoveItem(p_id){
		window.location.href = 'cart/item/remove/'+p_id;
	}

</script>
@endsection