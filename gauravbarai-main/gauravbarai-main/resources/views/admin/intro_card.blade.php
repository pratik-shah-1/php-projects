@extends('admin.index')

@section('page')

@if(session()->has('success'))
<script>
    Swal.fire('Data Save Successfully...','','success');
</script>
@endif
<main class="intro_card">
	<p class="py-3 text-center text-light bg-dark h5">INTRO CARD</p>
	<form action="{{url('/intro_card/upload')}}" method="POST" class="p-4">
		@csrf
		<textarea class="form-control" placeholder="Write your intro" name="intro" style="height:150px;" required="require">{{$intro}}</textarea>
		<button class="mt-3 btn btn-primary">
			<span class="h6">SAVE</span>
		</button>
	</form>
</main>
@endsection