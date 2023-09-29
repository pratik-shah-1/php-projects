@extends('users.master')
@section('title','MyBooks-Orders')
@section('content')
<main class="pt-5">
	@if(count($orders)==0)
		<p class="mt-5 text-center display-4">Not Orders Yet</p>
	@endif
	@foreach($orders as $order)
	<div class="order">
		<!-- Product_ID -->
		<a class="h5 ml-5 pl-5 text-primary" href="{{url('/product/view/'.$order->product_id)}}">Product ID : #MB{{rand(100,999).$order->product_id}}</a>
		<div class="tracking_order">
			<!-- Order Track Big_Icon -->
			<!-- Here status1,2,3,4 are basicallly color class of bootstrap -->
			<div><i class="fas fa-people-carry {{$order->status1}}"></i>
				<p class="{{$order->status1}}">Picked Up</p></div>
			<div><i class="fas fa-truck-moving {{$order->status2}}"></i>
				<p class="{{$order->status2}}">Transit</p></div>
			<div><i class="fas fa-biking {{$order->status3}}"></i>
				<p class="{{$order->status3}}">Our For Delivery</p></div>
			<div><i class="fas fa-home {{$order->status4}}"></i>
				<p class="{{$order->status4}}">Delivery</p></div>
			<!-- Progress TickMark -->
			<div class="order_progress">
				<div>
					<i class="fas fa-check-circle {{$order->status1}}"></i>
					<span class="track_progress {{$order->status2}}"></span> </div>
				<div>
					<i class="fas fa-check-circle {{$order->status2}}"></i>
					<span class="track_progress {{$order->status3}}"></span> </div>
				<div>
					<i class="fas fa-check-circle {{$order->status3}}"></i>
					<span class="track_progress {{$order->status4}}"></span> </div>		
				<div><i class="fas fa-check-circle {{$order->status4}}"></i> </div>
			</div>					
			<!-- Progress Line -->
			<div class="progress_line"></div>
		</div><!-- End of Track_Orders -->
	</div><!-- End Order -->
	@endforeach
</main>
@endsection