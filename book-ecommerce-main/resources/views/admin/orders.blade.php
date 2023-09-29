@extends('admin.master')
@section('title','Admin-Orders')
@section('content')
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th class="font-weight-normal h5">Index</th>
				<th class="font-weight-normal h5">Customer Name</th>
				<th class="font-weight-normal h5">Product Name</th>
				<th class="font-weight-normal h5">Quantity</th>
				<th class="font-weight-normal h5">Order Time</th>
				<th class="font-weight-normal h5">Payment Status</th>
				<th class="font-weight-normal h5">Delivery Status</th>
			</tr>
		</thead>
		<tbody>
			@php $i=0; @endphp
			@foreach($orders as $o)
			<tr>
				<td class="font-weight-normal h5">{{++$i}}</td>
				<td class="font-weight-normal h5">{{$o->uname}}</td>
				<td class="font-weight-normal h5">{{$o->pname}}</td>
				<td class="font-weight-normal h5">{{$o->quantity}}</td>
				<td class="font-weight-normal h5">{{$o->order_time}}</td>
				<td class="font-weight-normal h5"><span class="rounded-pill px-3 py-1 text-light bg-success">{{$o->payment_status}}</span></td>
				<td class="font-weight-normal h5">{{$o->delivery_status}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection