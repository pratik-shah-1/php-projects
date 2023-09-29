@extends('general.index')

@section('page')
<!-- Section-1 -->
<div class="section_1">
	<!-- Section1 Background -->
	<div class="img_of_section_1">
		<img src="{{$backgrounds[0]->image}}" alt="">
	</div>
	<!-- Card-of-Section-1 -->
	<div class="card_of_section_1" data-aos="fade-up" data-aos-duration="1000">
		<div>
			<p style="white-space: pre-line">{{$intro_card->details}}</p>
		</div>
	</div>
</div>

<!-- Section-2 -->
<div class="section_2">

	<div class="img_of_section_2">
		<img  src="{{$backgrounds[1]->image}}" alt="">
	</div>

	<p class="title_of_section_2">Personal projects</p>

	<div class="cards_of_section_2">
		@php
			$delay = 500;
			$temp = 500;
		@endphp

		@foreach($portfolio as $p)
		<div class="card_of_section_2" data-aos="fade-up" data-aos-duration="500" data-aos-delay="{{$delay = $delay+$temp}}">  
			<p>{{$p->title}}</p>
			<p>{{$p->description}}</p>
			<div>
				@foreach($p->button_links as $btn)
					@if($btn->title=='download')
						<a href="{{$btn->link}}" target="_blank">Download</a>
					@elseif($btn->title=='webgl')
						<a href="{{$btn->link}}" target="_blank">WebGL</a>
					@endif
				@endforeach
			</div>
		</div>
		@endforeach
	</div>

	<a href="{{url('/portfolio')}}">View all projects</a>

</div>


<!-- Section-3 -->
<div class="section_3">

	<div class="img_of_section_3">
		<img  src="{{$backgrounds[2]->image}}" alt="">
	</div>


	<!-- Contact Section -->
	<div  data-aos="fade" data-aos-duration="1000" data-aos-delay="1000">
		
		<div class="contact_form">
			<p>Get in Touch</p>
			<form id="contact_form">
				@csrf
				<input type="text" placeholder="Full Name" name="name" required>
				<input type="email" placeholder="Email" name="email" required>
				<textarea placeholder="Message" name="message" required></textarea>
				<button name="contact_submit">Submit</button>
			</form>
		</div>

		<!-- AJAX SCRIPT FOR CONTACT FORM -->
		<script>
			$('#contact_form').submit(function(e){
				e.preventDefault();
				$.ajax({
					url : `{{url('/send_mail')}}`,
					method : 'POST',
					data : $('#contact_form').serialize(),
					beforeSend : function(){
						$('[name="contact_submit"]').attr('disabled','disabled');
						$('[name="contact_submit"]').text('Sending');
					},
					success : function(res){
						if(res==1){
				    		// Swal.fire('Mail Sent Successfully...','','success');
				    		$('[name="contact_submit"]').removeAttr('disabled');
							$('[name="contact_submit"]').text('Submit');
				    		$('#contact_form').trigger('reset');
							$('[name="contact_submit"]').text('Sent Successfully').
							animate({ width: '150px'});
							setTimeout(()=>{
								$('[name="contact_submit"]').text('Submit').animate({width:'100px'});
							}, 2000);						
						}
					},
					error : function(xhr, status, error){
			    		Swal.fire('Something Went Wrong...','','error');		
						$('[name="contact_submit"]').text('Submit');
			    		$('[name="contact_submit"]').removeAttr('disabled');
					}
				});				
			});
		</script>

		<div class="contact_details">
			<p>Contact</p>
			<div>
				<p>{{$contact->mobile}}</p>
				<br>
				<p><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></p>
			</div>
			@php 
				$github_icon = 'fab fa-github';
				$insta_icon = 'fab fa-instagram';
				$linkedin_icon = 'fab fa-linkedin';
				$twitter_icon = 'fab fa-twitter';
				$stack_overflow_icon = 'fab fa-stack-overflow';
				$skype_icon = 'fab fa-skype';
				$fb_icon = 'fab fa-facebook-square';
				$quora_icon = 'fab fa-quora';
				$medium_icon = 'fab fa-medium';
				$website_icon = 'fas fa-globe';
			@endphp
			<div class="social_media_links">				
				@foreach($sml as $s)
					@if($s->title=='instagram')
						<a href="{{$s->link}}"><i class="{{$insta_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='twitter')
						<a href="{{$s->link}}"><i class="{{$twitter_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='github')
						<a href="{{$s->link}}"><i class="{{$github_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='medium')
						<a href="{{$s->link}}"><i class="{{$medium_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='quora')
						<a href="{{$s->link}}"><i class="{{$quora_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='linkedin')
						<a href="{{$s->link}}"><i class="{{$linkedin_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='facebook')
						<a href="{{$s->link}}"><i class="{{$fb_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='website')
						<a href="{{$s->link}}"><i class="{{$website_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='skype')
						<a href="{{$s->link}}"><i class="{{$skype_icon}}"></i> {{$s->social_media_id}}</a>
					@elseif($s->title=='stackoverflow')
						<a href="{{$s->link}}"><i class="{{$stack_overflow_icon}}"></i> {{$s->social_media_id}}</a>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
