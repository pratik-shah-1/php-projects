@extends('admin.index')

@section('page')

@if(session()->has('success'))
<script>
    Swal.fire('Data Save Successfully...','','success');
</script>
@endif


<main class="footer">
    <p class="py-3 text-center text-light bg-dark h5">Footer Text</p>
    <form action="{{url('/footer_text/upload')}}" method="POST" class="p-4">
        @csrf
        <input class="form-control" type="text" name="footer_text" value="{{$footer_text}}" placeholder="Write" required="require">
        <button class="mt-3 btn btn-primary">
            <span class="h6">SAVE</span>
        </button>
    </form>
</main>
@endsection