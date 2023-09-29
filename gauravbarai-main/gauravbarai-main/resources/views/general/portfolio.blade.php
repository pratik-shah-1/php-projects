@extends('general.index')
@section('page')
<!-- Portfolio -->
<div class="all_portfolio">

	@foreach($portfolio as $p)
		<div class="portfolio" >
			<!-- Portfolio background-Image -->
			<div class="img_of_portfolio">
				<img  src="{{$p->background}}" alt="">
			</div>		
			<!-- Portfolio-Card -->
			@php
				$horizontal_card = '';
				if($p->slider_type=='horizontal')
					$horizontal_card = 'horizontal_card';
			@endphp
			<div class="portfolio_card {{$horizontal_card}}" data-aos="fade-up" data-aos-duration="1000">
				<div class="title">
					<!-- Icon Image -->
					<img src="{{$p->icon}}" alt="">
					<p>{{$p->title}}</p>								
				</div>
				<!-- container of left & right -->
				<div>
					<div class="left">
						<div>
							<p>{{$p->description}}</p>
						</div>
						@if($p->slider_type=='horizontal')
						<div>
							<div>
								<p>Credits:</p>

								@if(isset($p->credits->designer))
								<p>Designed By  : 
									@foreach($p->credits->designer as $designer)
										@if($designer->link!=='#' && $designer->link!==null && $designer->link!=="")
											<a href="{{$designer->link}}" target="_blank">{{$designer->name}}</a>
										@else
											{{$designer->name}}
										@endif
									@endforeach
								</p>
								@endif

								@if(isset($p->credits->developer))
								<p>Developed By : 
									@foreach($p->credits->developer as $developer)
										@if($developer->link!=='#' && $developer->link!==null && $developer->link!=="")
											<a href="{{$developer->link}}" target="_blank">{{$developer->name}}</a>
										@else
											{{$developer->name}}
										@endif
									@endforeach
								</p>
								@endif

								@if(isset($p->credits->artist))
								<p>Artist by : 
									@foreach($p->credits->artist as $artist)
										@if($artist->link!=='#' && $artist->link!==null && $artist->link!=="")
											<a href="{{$artist->link}}" target="_blank">{{$artist->name}}</a>
										@else
											{{$artist->name}}
										@endif
									@endforeach
								</p>
								@endif
							</div>
							<div>
								@for($i=0; $i<4; $i++)
									@if($p->button_links[$i]->title=='youtube')
										<a href="{{$p->button_links[$i]->link}}"  target="_blank"><i class="fab fa-youtube"></i>&nbsp;&nbsp;YouTube</a>
									@elseif($p->button_links[$i]->title=='playstore')
										<a href="{{$p->button_links[$i]->link}}" target="_blank">
											<i class="fab fa-google-play"></i>&nbsp;&nbsp;PlayStore</a>
									@elseif($p->button_links[$i]->title=='gdd')
										<a href="{{$p->button_links[$i]->link}}" target="_blank">GDD</a>
									@elseif($p->button_links[$i]->title=='webgl')
										<a class="webgl_btn" href="{{$p->button_links[$i]->link}}" target="_blank">WebGL</a>
									@elseif($p->button_links[$i]->title=='download')
										<a href="{{$p->button_links[$i]->link}}" target="_blank">Download</a>
									@endif
								@endfor
							</div>							
						</div>
						@elseif($p->slider_type=='vertical')
							<div>
								<p>Credits:</p>

								@if(isset($p->credits->designer))
								<p>Designed By  : 
									@foreach($p->credits->designer as $designer)
										@if($designer->link!=='#' && $designer->link!==null && $designer->link!=="")
											<a href="{{$designer->link}}" target="_blank">{{$designer->name}}</a>
										@else
											{{$designer->name}}
										@endif
									@endforeach
								</p>
								@endif

								@if(isset($p->credits->developer))
								<p>Developed By : 
									@foreach($p->credits->developer as $developer)
										@if($developer->link!=='#' && $developer->link!==null && $developer->link!=="")
											<a href="{{$developer->link}}" target="_blank">{{$developer->name}}</a>
										@else
											{{$developer->name}}
										@endif
									@endforeach
								</p>
								@endif

								@if(isset($p->credits->artist))
								<p>Artist by : 
									@foreach($p->credits->artist as $artist)
										@if($artist->link!=='#' && $artist->link!==null && $artist->link!=="")
											<a href="{{$artist->link}}" target="_blank">{{$artist->name}}</a>
										@else
											{{$artist->name}}
										@endif
									@endforeach
								</p>
								@endif
							</div>
							<div>
								@for($i=0; $i<4; $i++)
									@if($p->button_links[$i]->title=='youtube')
										<a href="{{$p->button_links[$i]->link}}"  target="_blank"><i class="fab fa-youtube"></i>&nbsp;&nbsp;YouTube</a>
									@elseif($p->button_links[$i]->title=='playstore')
										<a href="{{$p->button_links[$i]->link}}"  target="_blank"><i class="fab fa-google-play"></i>&nbsp;&nbsp;PlayStore</a>
									@elseif($p->button_links[$i]->title=='gdd')
										<a href="{{$p->button_links[$i]->link}}" target="_blank">GDD</a>
									@elseif($p->button_links[$i]->title=='webgl')
										<a class="webgl_btn" href="{{$p->button_links[$i]->link}}" target="_blank">WebGL</a>
									@elseif($p->button_links[$i]->title=='download')
										<a href="{{$p->button_links[$i]->link}}" target="_blank">Download</a>
									@endif
								@endfor
							</div>							
						@endif
					</div>
					<div class="right">
						<div class="owl-carousel owl-theme">
							@for($i=0; $i<count($p->slider_images); $i++)
								<div class="item"><img src="{{$p->slider_images[$i]}}" alt=""></div>
							@endfor
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>


<script>
	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		navText:[
				"<div class='nav-btn prev-slide'><i class='fas fa-chevron-circle-left'></i></div>",
				"<div class='nav-btn next-slide'><i class='fas fa-chevron-circle-right'></i></div>"],
		items:1
	});
</script>

@endsection