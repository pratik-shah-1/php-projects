@php 
 	use \App\Http\Models\Resume;
 	$resume = Resume::first();
 	$resume = $resume->resume;

	$home = '';
	$portfolio = '';
	$contact = '';

	if(Request::path()=='/')
		$home = 'nav_barder_bottom';
	else if(Request::path()=='portfolio')
		$portfolio = 'nav_barder_bottom';
	else if(Request::path()=='contact')
		$contact = 'nav_barder_bottom';
		
@endphp

<nav class="navbar">
	<div class="logo">
		<a href="{{url('/')}}">Gaurav Barai</a>
	</div>
	<div class="menu">
		<ul>
			<li class="{{$home}}"><a href="{{url('/')}}">Home</a></li>
			<li class="{{$portfolio}}"><a href="{{url('/portfolio')}}">Portfolio</a></li>
			<li class="{{$contact}}"><a href="{{url('/contact')}}">Contact</a></li>
			<li><a href="{{url($resume)}}" target="_blank">Resume <i class="bi bi-download"></i></a></li>
		</ul>				
	</div>
</nav>