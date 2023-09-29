@extends('admin.index')

@section('page')

@if(session()->has('arrange'))
<script>
    Swal.fire('Arrange Portfolio Successfully...','','success');
</script>
@endif

<main class="arrange_portfolio">
	<p class="py-3 text-center text-light h5 bg-dark">Arrage Portfolio</p>
	<form action="{{url('/portfolio/arrange')}}" method="POST" class="p-4 " id="arrange_portfolio">
		@csrf
		@foreach($portfolio as $p)
		<div class="shadow-sm mb-2 rounded border">
			<input type="hidden" name="arrange[]" value="{{$p->id}}">
			<p class="p-3 h6 m-0 text-capitalize">{{$p->title}}</p>
		</div>
		@endforeach
		<button class="btn btn-primary">
			<span class="h6">Save</span>
		</button>
	</form>
</main>

<script>
	new Sortable(arrange_portfolio, {
		animation: 100,
	})
</script>
@endsection