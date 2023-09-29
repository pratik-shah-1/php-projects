<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{asset('assets/admin/css/index.css')}}">

	<!-- FavIcon -->
	<link rel="icon" href="{{ asset('/assets/img/logo.svg') }}" type="image/gif">

	<!-- Fontawesome Icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">	

	<!-- Jquery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- SweetAlert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--Owl Carousel -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

	<!-- Sortable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>
<body>

@if(session()->has('login'))
	<script> Swal.fire('Login Successfully...','','success');</script>
@endif

@if(session()->has('logout'))
	<script> Swal.fire('Logout Successfully...','','success');</script>
@endif

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg bg-dark shadow-sm">
		<div class="container-fluid">
			<a class="navbar-brand h5 m-0 text-light" href="{{url('/admin')}}">ADMIN</a>
			<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navmenu">
			  	<i class="fas fa-bars text-light"></i>
			</button>	  
			<div class="collapse navbar-collapse" id="navmenu">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/intro-card')}}">Intro</a>
					</li>
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/backgrounds')}}">Backgrounds</a>
					</li>
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/footer-text')}}">Footer</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3 dropdown-toggle" type="button" data-toggle="dropdown">Portfolio</a>
						  <div class="dropdown-menu">
						    <a class="dropdown-item" href="{{url('/admin/portfolio/add')}}"><span class="h6">ADD</span></a>
						    <a class="dropdown-item" href="{{url('/admin/portfolio/view')}}"><span class="h6">VIEW</span></a>				
						    <a class="dropdown-item" href="{{url('/admin/portfolio/arrange')}}"><span class="h6">ARRANGE</span></a>				
						    <a class="dropdown-item" href="{{url('/admin/portfolio/top-3')}}"><span class="h6">TOP3</span></a>
						  </div>
					</li>
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/contact-details')}}">Contact</a>
					</li>
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/social-media-links')}}">Social Media</a>
					</li>
					<li class="nav-item">
						<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/resume')}}">Resume</a>
					</li>
					@if(session()->has('ADMIN'))
						<li class="nav-item">
							<a class="nav-link h6 m-0 text-light text-uppercase mx-lg-3" href="{{url('/admin/logout')}}">Logout</a>
						</li>
					@endif
				</ul>	
			</div>
		</div>
	</nav>

	@yield('page')
	
	<footer>
		<p class="m-0 py-3 bg-dark text-center text-light h6">Copyright © <span class="year"></span> by Gaurav Barai</p>
	</footer>

	<script>
		const current_year = new Date().getFullYear();
		$('.year').html(current_year);		
	</script>
</body>
</html>