@extends('admin.master')
@section('title','Admin-Product-Category')
@section('content')

<div class="bg-light d-flex justify-content-end py-2 align-center">
	<form class="d-flex mr-2" method="POST" action="/admin/product_category/action">
		@csrf
		<input type="text" name="id" hidden="hide">
		<input class="p-1 pl-2 border" type="text" placeholder="Add New Category" style="width:200px;border-radius:6px 0 0 6px;" name="category" required>
		<button class="btn btn-primary" style="border-radius:0 6px 6px 0;" name="btn">ADD</button>
	</form>
	<button class="mr-3 btn btn-danger d-none" name="cancel_btn" onclick="cancel();"><i class="fas fa-times"></i></button>
</div>

<script>
	function cancel(){
		$('[name="id"]').val('');
		$('[name="category"]').val('');
		$('[name="btn"]').html('ADD');		
		$('[name="cancel_btn"]').addClass('d-none');		
	}
	function edit_category(id,category){
		$(window).scrollTop(0);
		$('[name="id"]').val(id);
		$('[name="category"]').val(category);
		$('[name="btn"]').html('UPDATE');
		$('[name="cancel_btn"]').removeClass('d-none');		
	}
</script>
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<th class="h5 font-weight-normal">Index</th>
			<th class="h5 font-weight-normal">Category Name</th>
			<th class="h5 font-weight-normal">Action</th>
		</thead>
		<tbody>
			@php
				$i=0;
			@endphp
			@foreach($category as $c)
			<tr>
				<td class="h5 font-weight-normal">{{++$i}}</td>
				<td class="h5 font-weight-normal">{{$c->category}}</td>
				<td class="d-flex h5 font-weight-normal">
					<button class="btn btn-warning mr-3" onclick="edit_category(`{{$c->id}}`,`{{$c->category}}`);">Edit</button>
					<a href="/admin/product_category/delete/{{$c->id}}" class="btn btn-danger">Delete</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection