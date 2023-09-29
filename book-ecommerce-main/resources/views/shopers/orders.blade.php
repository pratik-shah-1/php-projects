@extends('shopers.master')
@section('title','Shoper-Orders')
@section('content')
<main>
	@if(count($orders)==0)
		<p class="text-center display-4 mt-5">You Not Have Any Orders</p>
	@else
	<div class="shoper_orders">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Index</th>
					<th>Customer Name</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Quantity * Price = Total Price</th>
					<th>Pack / Pass Order</th>
				</tr>
			</thead>
			<tbody>
				@php $i=0; @endphp
				@foreach($orders as $order)
				<tr>
					<td>{{++$i}}</td>
					<td>{{$order->uname}}</td>
					<td><a href="/shoper/product/view/{{$order->pid}}">{{$order->pname}}</a></td>
					<td>{{$order->oquantity}}</td>
					<td>{{$order->oquantity}} * {{$order->price}} = {{$order->oquantity*$order->price}}</td>
					<td>
						@if($order->delivery_status!=null)
						<button class="btn {{$order->btn_class}}">{{$order->delivery_status_name}}</button>
						@else
						<a href="/shoper/order/proceed/{{$order->oid}}" class="w-100 btn btn-warning">Proceed</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
</main>
@endsection