@extends('admin.master')
@section('title','Admin-Users')
@section('content')
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th class="font-weight-normal h5">Index</th>
				<th class="font-weight-normal h5">Name</th>
				<th class="font-weight-normal h5">Wishlist</th>
				<th class="font-weight-normal h5">Orders</th>
				<th class="font-weight-normal h5">Disable Account</th>
			</tr>
		</thead>
		<tbody>
			@php
				$i=0;
			@endphp
			@foreach($users as $user)
			<tr>
				<td class="font-weight-normal h5">{{++$i}}</td>
				<td class="font-weight-normal h5">{{$user->name}}</td>
				<td class="font-weight-normal h5">{{$user->wishlist}}</td>
				<td class="font-weight-normal h5">{{$user->orders}}</td>
				<td>
						@if($user->disable=="")
						<a href="/admin/users/disable/{{$user->id}}" class="btn btn-success">Enable</a>
						@else
						<a href="/admin/users/enable/{{$user->id}}" class="btn btn-danger">Disable</a>
						@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection