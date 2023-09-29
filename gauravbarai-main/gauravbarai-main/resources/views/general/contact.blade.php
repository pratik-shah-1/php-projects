@extends('general.index')

@section('page')
<div class="contact_section">

	<div class="img_of_contact_section">
		<img  src="{{$background->image}}" alt="">
	</div>

    <div class="contact_form" data-aos="fade-left" data-aos-duration="1000">
        <p>Get in Touch</p>
        <form id="contact_form">
        	@csrf
            <input type="text" placeholder="Full Name" name="name" required>
            <input type="text" placeholder="Email" name="email" required>
            <textarea placeholder="Message" name="message" required></textarea>
            <button name="contact_submit">Submit</button>
        </form>
	    
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
							$('[name="contact_submit"]').text('Sent Successfully').animate({ width: '150px', transform:'scale(1.2)'});
							setTimeout(()=>{
								$('[name="contact_submit"]').text('Submit').animate({width:'100px',transform:'scale(1)'});
							}, 2000);						
				    		$('#contact_form').trigger('reset');
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
    </div>

	<div class="contact_details" data-aos="fade">
		<div>
			<p>{{$contact->mobile}}</p>
			<p><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></p>
		</div>
		@php 
			$github_icon = 'fab fa-github';
			$insta_icon = 'fab fa-instagram';
			$linkedin_icon = 'fab fa-linkedin';
			$twitter_icon = 'fab fa-twitter';
			$stack_overflow_icon = 'fab fa-stack-overflow';
			$skype_icon = 'fab fa-skype';
			$fb_icon = 'fab fa-facebook';
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
@endsection