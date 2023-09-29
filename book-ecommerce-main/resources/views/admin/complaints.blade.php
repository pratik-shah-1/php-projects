@extends('admin.master')
@section('title','Admin-Comment')
@section('content')
@if(count($complaints)==0)
	<p class="display-4 text-center mt-5 pt-5">No Complaint</p>
@endif
@foreach($complaints as $c)
<div class="shadow-sm p-3 mt-3 mx-5 rounded border">
	<p class="h4 font-weight-normal">{{$c->complaint}}</p>
	<p class="h5 font-weight-normal">{{$c->email}}</p>
	<a href="/admin/complaint/delete/{{$c->id}}" class="btn btn-danger">Delete</a>
</div>
@endforeach
@endsection