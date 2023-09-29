@extends('admin.master')
@section('title','Admin-Login')
@section('content')
<form action="/admin/signin" method="POST" class="admin_login mt-5">
	@csrf
    <p>Admin Login</p>
    <div>
        <input type="text" name="email" placeholder="Email Address or Username" required>
        <input type="password" name="pswd" placeholder="Password" required>
        <button class="btn btn-outline-primary">LOGIN</button>              
    </div>
</form>
@endsection