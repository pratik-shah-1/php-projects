@php
	use \App\Http\Models\FooterText;
	$footer_text = FooterText::first();
	$footer_text = $footer_text->footer_text;
@endphp

<footer>
	<p>{{$footer_text}}</p>
</footer>

<script>
	//For Animate Div
	AOS.init();
</script>

