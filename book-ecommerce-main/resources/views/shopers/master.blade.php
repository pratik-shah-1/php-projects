<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('assets/img/dark.jpg')}}" type="image/gif" sizes="16x16">
    <!------------------ CSS FILES ------------------>
    <!-- Bootstrap v4.5.0 -->
    <!-- FontAwesome v5.13.1 -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/index.css')}}">    
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/swiper/swiper-bundle.css')}}">    
    
    <!------------------ JS FILES ------------------>
    <script type="text/javascript" src="{{asset('assets/lib/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/lib/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/lib/swiper/swiper-bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/lib/sweetalert/sweetalert.min.js')}}"></script>  
</head>
<body>

@php
    $sname = 'Unknown';
    $simg = asset('assets/img/blank_user.jpg');

    if(session()->has('sname'))
        $sname = session()->get('sname');
    
    if(session()->has('simg'))
        $simg = asset(session()->get('simg'));        
@endphp


<!-- For Backlight -->
<div class='random'></div>

<!-- Header -->
<div class="header border-bottom">
    <!-- Sidenav Button---->
    <button class='shoper_sidenav_btn'><img src="{{$simg}}"></button>
    <!-- Side Navbar-------->
    <sidenav class='sidenav'>
        <ul>
            <li><img src='{{$simg}}'><p>{{$sname}}</p></li>
            <li><a href='/shoper/account/'><i class='far fa-user'></i>Your Profile</a></li>
            <li><a href='/shoper/account/'><i class='fas fa-lock'></i>Change Password</a></li>
            <li><a href='/shoper/account/'><i class='fas fa-map-marker-alt'></i>Address</a></li>
            <li><a href='/shoper/account/'><i class='fas fa-user-friends'></i>Manage Customers</a></li>
            <li><a href='/shoper/account/'><i class='far fa-envelope'></i>Mails</a></li>
            <li><a href='/shoper/account/'><i class='far fa-trash-alt'></i>Delete Account</a></li>
            <li><a href='/shoper/signout/'><i class='fas fa-sign-out-alt'></i>Logout</a></li>
        </ul>
    </sidenav>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg text-secondary shoper_nav">
        <button class="navbar-toggler ml-auto" data-toggle="collapse" data-target="#shoper_menu"><i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse ml-auto" id="shoper_menu">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-4">
                    <a class="nav-link" href="/shoper/product/add_form">Add Product</a></li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="/shoper/products">Products</a></li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="/shoper/orders">Orders</a></li>
                @if(session()->has('SLogged'))
                  <li class='nav-item mr-4'>
                    <a class='nav-link' href='/shoper/signout'>
                        <i class='fas fa-sign-out-alt'></i>Logout</a></li>
                @else
                    <li class='nav-item mr-4'><a class='nav-link' href='/shoper'>Login</a></li>
                @endif
            </ul>
        </div>        
    </nav><!-- NavbarEnd Here.... -->
</div><!-- End Header -->

<script>

    $('.shoper_sidenav_btn').click(function(){
        $('.sidenav').addClass('show_sidenav');
        $('.random').addClass('backlight');
    });

    $('.random').click(function(){
        $('.sidenav').removeClass('show_sidenav');
        $('.random').removeClass('backlight');
    });

</script>

@yield('content')

</body>
</html>  