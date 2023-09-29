@extends('admin.master')
@section('title','Admin-Shopers')
@section('content')
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th class="font-weight-normal h5">Index</th>
				<th class="font-weight-normal h5">Name</th>
				<th class="font-weight-normal h5">Products</th>
				<th class="font-weight-normal h5">Orders</th>
				<th class="font-weight-normal h5">Disable Account</th>
			</tr>
		</thead>
		<tbody>
			@php
				$i=0;
			@endphp
			@foreach($shopers as $shoper)
			<tr>
				<td class="font-weight-normal h5">{{++$i}}</td>
				<td class="font-weight-normal h5">{{$shoper->name}}</td>
				<td class="font-weight-normal h5">{{$shoper->products}}</td>
				<td class="font-weight-normal h5">{{$shoper->orders}}</td>
				<td>
						@if($shoper->disable=="")
						<a href="/admin/shopers/disable/{{$shoper->id}}" class="btn btn-success">Enable</a>
						@else
						<a href="/admin/shopers/enable/{{$shoper->id}}" class="btn btn-danger">Disable</a>
						@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection