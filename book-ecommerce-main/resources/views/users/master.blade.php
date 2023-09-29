<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.0.0/turbolinks.js"></script>
	<script>Turbolinks.start();</script>	
<style>
  	*{margin:0;padding:0;}
    .swiper-container {
	  z-index:1;
	  margin-top:-5px;
      width: 100%;
      height: 450px;
    }
    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .swiper-slide img{
    	/*object-fit:contain;*/
    	width:100%;
    	height:100%;
	}
	@media screen and (max-width:767px){
    	.swiper-container{
			height:200px; 	
    	} 
    	.swiper-slide img{
    		height:100%;
    		object-fit:cover;
		}
	} 
</style>
</head>
<body>
	
@if(session()->has('add'))
	<script> swal('Added Successfully','','success'); </script>
@endif

@if(session()->has('signout'))
	<script> swal('Signout Successfully...','','success'); </script>
@endif
<!-- We are Not Use Logged Here Because of Every time Page Refresh it show msg... -->
@if(session()->has('signin'))
	<script> swal('Login Successfully...','','success'); </script>
@endif

@php
	$name = 'Unknown';
	$img = asset('assets/img/blank_user.jpg');
	$cart_items = "";

	if(session()->has('name'))
		$name = session()->get('name');
	
	if(session()->has('img'))
		$img = asset(session()->get('img'));
	
	if(session()->has('cart_items'))
		$cart_items = session()->get('cart_items');
	
@endphp

<!-- Backlight -->
<div class='random'></div>
<!-- SideNav --------->
<aside class="sidenav">
	<ul>
		<li> <img src="{{$img}}"><p>{{$name}}</p> </li>
     	<li> <a href='/account' ><i class='far fa-user'></i>Your Profile</a></li>
     	<li> <a href='/account'><i class='fas fa-lock'></i>Change Password</a></li>
     	<li> <a href='/cart'><i class="fas fa-shopping-cart"></i><span class="mr-2 badge badge-secondary cart_items"></span>Cart</a></li>
    	<li> <a href='/orders'><i class='fas fa-tag'></i>Orders</a></li>
    	<li> <a href='/account'><i class='fas fa-map-marker-alt'></i>Address</a></li>
    	<li> <a href='/account'><i class='far fa-trash-alt'></i>Delete Account</a></li>
     	<li> <a href='/signout'><i class='fas fa-sign-out-alt'></i>Logout</a></li>
	</ul>
</aside>

<!-- Header -->
<header>

	<!-- Sidenav Button -->
	<button class='user_sidenav_btn'><i class="fas fa-bars"></i></button>
	
	<!-- Cart Button For 992px Responsive -->
	<a class="only_nav_cart mt-2 mr-3" href='/cart/'><i class='fas fa-shopping-cart'><span class="badge badge-secondary rounded-circle cart_items">{{$cart_items}}</span></i></a>

	<!-- Navbar -->
	<nav class="container-lg container-md container-fluid user_nav px-4 px-md-0">

	  	<!-- Logo -->
	  	<a class="logo" href="/">My<span>Books</span></a>

	  	<button class="filter_btn btn text-light">Filter Books <i class="fas fa-angle-down"></i></button>

		<!-- Search -->
		<form class="search_container">
			<select onchange="ChangePlaceholder(this.value);">
				<option value="name">Book Name</option>
				<option value="author">Author</option>
				<option value="isbn">ISBN NO.</option>
				<option value="publication">Publication</option>
			</select>
			<input type="text" placeholder="Search by Title" class='search'> 
			<button><i class="fas fa-search"></i></button>
		</form><!-- End Search_Container -->
  		
  		<!-- Menu -->
		<div class="menu">
		    <ul>
		    	<li> <a href="/cart"> <i class="fas fa-shopping-cart"> <span class="badge badge-secondary rounded-circle cart_items">{{$cart_items}}</span> </i> </a> </li>
				<li> <a href="/orders"><i class="fas fa-truck"></i></a> </li>
				@if(session()->has('Logged'))
				<li class="ml-3"><a class="d-flex align-items-center" href='/signout'><i class='fas fa-sign-out-alt mr-1'></i><span class="h6 mb-1">LOGOUT</span></a></li>
				@else
				<li><a href="/login"><span class="h6">LOGIN</span></a></li>
			    @endif			
		    </ul>
		</div><!-- End Menu -->
	</nav><!-- End Navbar -->

	<div class="filter">

		<div class="f_category">
			<h6>Category</h6>
			<select>
				<option value="">Small</option>
				<option value="">Big</option>
				<option value="">Average</option>
			</select>
		</div>

		<div class="f_sub_category">
			<h6>Sub Category</h6>
			<div>
				<p>Field</p>
				<select name="" id="">
					<option value="">Option1</option>
					<option value="">Option1</option>
					<option value="">Option1</option>
				</select>
			</div>
			<div>
				<p>Branch</p>
				<select name="" id="">
					<option value="">Option1</option>
					<option value="">Option1</option>
					<option value="">Option1</option>
				</select>
			</div>
			<div>
				<p>University</p>
				<select>
					<option value="">Small</option>
					<option value="">Big</option>
					<option value="">Average</option>
				</select>	
			</div>
			<div>
				<p>Semester/Standard</p>
				<select name="" id="">
					<option value="">Stander1</option>
					<option value="">Stander2</option>
					<option value="">Semester1</option>
				</select>
			</div>
		</div>

		<div class="f_lang">
			<h6>Language</h6>
			<div><label for="">Hindi</label><input type="checkbox"></div>
			<div><label for="">English</label><input type="checkbox"></div>
			<div><label for="">Gujarati</label><input type="checkbox"></div>
			<div><label for="">German</label><input type="checkbox"></div>
		</div>

		<div class="f_earlier">
			<h6>Earlier Published</h6>
			<div><label for="">5 Days Ago</label><input type="checkbox"></div>
			<div><label for="">4 Days Ago</label><input type="checkbox"></div>
			<div><label for="">3 Days Ago</label><input type="checkbox"></div>
		</div>

		<div class="f_format">
			<h6>Format</h6>
			<div><label>Paper Cover</label><input type="checkbox"></div>
			<div><label>Softcopy (PDF)</label><input type="checkbox"></div>
		</div>

		<div class="f_condition">
			<h6>Condition</h6>
			<div><label>Used</label><input type="radio"></div>
			<div><label>New</label><input type="radio"></div>
			<div><label>Both</label><input type="checkbox"></div>
		</div>

		<div class="f_price">
			<h6>Price</h6>
			<div>
				<input type="text" placeholder="From Low">
				<input type="text" placeholder="To High">
			</div>
		</div>

		<div class="f_rating">
			<h6>Rating</h6>
			<div>
				<a href="">
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
				</a>
				<a href="">
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
				</a>
				<a href="">
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
				</a>
				<a href="">
					<i class="fas fa-star text-warning"></i>
					<i class="fas fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
				</a>
				<a href="">
					<i class="fas fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
					<i class="far fa-star text-warning"></i>
				</a>
				
			</div>
		</div>
		
		<div class="f_discount">
			<h6>Discount</h6>
			<div><label>80% and above 406</label><input type="checkbox"></div>
			<div><label>70% and above 1949</label><input type="checkbox"></div>
			<div><label>60% and above 4199</label><input type="checkbox"></div>
			<div><label>50% and above 5708</label><input type="checkbox"></div>
			<div><label>40% and above 6279</label><input type="checkbox"></div>
		</div>

	</div>

</header><!-- End Header -->

@yield('content')

<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">			
			<div class="col-lg-3 col-md-4 col-sm-6">
				<div class="footer_content">
					<p data-target="#f_div_1" data-toggle="collapse">AboutUs	
						<i class="fas fa-angle-down d-sm-none"></i>
					</p>
					<div id="f_div_1">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima quam debitis officia ratione maxime dolor. Itaque molestias maiores nesciunt suscipit doloribus eius harum facere nihil vel ipsa.</p>
					</div>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-4 col-sm-6">
				<div class="footer_content">
					<p data-target="#f_div_2" data-toggle="collapse">Useful Links
						<i class="fas fa-angle-down d-sm-none"></i>
					</p>	
					<ul id="f_div_2" >
						<li><a href="#">AboutUs</a></li>
						<li><a href="#">ContactUs</a></li>
						<li><a href="#">Help</a></li>
						<li><a href="#">Support</a></li>
					</ul>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-4 col-sm-6">
				<div class="footer_content">
					<p data-target="#f_div_3" data-toggle="collapse">Follow Us
						<i class="fas fa-angle-down  d-sm-none"></i>
					</p>
					<ul id="f_div_3" >
						<li><a href="#">Facebook</a></li>
						<li><a href="#">Instagram</a></li>
						<li><a href="#">Twitter</a></li>
						<li><a href="#">Linked-in</a></li>
					</ul>
				</div> 
			</div>
			
			<div class="col-lg-5 col-md-12 col-sm-6">
				<div class="footer_content">
					<p data-target="#f_div_4" data-toggle="collapse">Get in Touch
						<i class="fas fa-angle-down  d-sm-none"></i>
					</p>
					<div id="f_div_4">
						<form>
							<input type="Email" placeholder="Enter Email Address">
							<input type="submit">
						</form>	
					</div>
				</div>
			</div>
		</div><!-- End Row -->
	</div><!-- End Container -->
</footer>

<script>

	if ($(window).width() <= 575) {
		$('#f_div_1').addClass('collapse');
		$('#f_div_2').addClass('collapse');
		$('#f_div_3').addClass('collapse');
		$('#f_div_4').addClass('collapse');
	}
	else{
		$('#f_div_1').removeClass('collapse');
		$('#f_div_2').removeClass('collapse');
		$('#f_div_3').removeClass('collapse');
		$('#f_div_4').removeClass('collapse');	
	}

    function AddToCart(p_id){
    	window.location.href = 'cart/item/add/'+p_id;
    }
	
	$('.user_sidenav_btn').click(function(){
		$('.sidenav').addClass('show_sidenav');
		$('.random').addClass('backlight');
		$('body').css('overflow','hidden');
	});

	$('.random').click(function(){
		$('.random').removeClass('backlight');
		$('.sidenav').removeClass('show_sidenav');
		$('body').css('overflow','auto');
	});	

	function ChangePlaceholder(val){
		if(val=='name') 
			$(".search").attr("placeholder", "Search by Title");
		else if(val=='isbn') 
			$(".search").attr("placeholder", "Search by ISBN");
		else if(val=='author') 
			$(".search").attr("placeholder", "Search by Author");
		else if(val=='publication') 
			$(".search").attr("placeholder", "Search by Publication");
	}	

	var filter_btn_click = 0;
	if($(window).width() >=992){
		$('.filter_btn').click(function(){
			if(filter_btn_click==0){
				$('.filter').css('top','65px');
				filter_btn_click = 1;
			}
			else{
				$('.filter').css('top','-270px');
				filter_btn_click = 0;
			}
		});
	}
	else{
		$('.filter_btn').click(function(){
			if(filter_btn_click==0){
				$('.filter').css('top','110px');
				filter_btn_click = 1;
			}
			else{
				$('.filter').css('top','-270px');
				filter_btn_click = 0;
			}
		});
	}
</script>
</body>
</html>