@extends('admin.index')

@section('page')
<main class="login">
	<div>
		<p class="py-3 text-center text-light bg-dark h5">ADMIN LOGIN</p>
		@if(session('error'))
			<div class="m-0 mt-3 mx-4 alert alert-danger">
				<p class="h6 m-0">Username or Password is not match!!!</p>
			</div>
		@endif
		<form action="{{url('/admin/auth')}}" method="POST" class="p-4">
			@csrf
			<input type="text" class="form-control mb-3" placeholder='Email Address or Username' name="username">
			<input type="password" class="form-control mb-3" placeholder='Password' name="password">
			<button class="btn btn-dark">
				<span class="h6">LOGIN</span>
			</button>
		</form>
	</div>
</main>
@endsection