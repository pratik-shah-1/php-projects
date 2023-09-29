<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gaurav Barai</title>
	
	<!-- Custom Style -->
	<link rel="stylesheet" href="{{asset('/assets/general/css/index.css')}}">

	<!-- Fontawesome Icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<!-- FavIcon -->
	<link rel="icon" href="{{ asset('/assets/img/logo.svg') }}" type="image/gif">
	
	<!-- SweetAlert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Bootstrap Icon -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<!-- Jquery -->
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

	<!--Owl Carousel -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

	<!-- Animation AOS Libaray -->
	<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
</head>
<body>

	@include('general.header')

	@yield('page')

	@include('general.footer')

</body>
</html>