@extends('admin.index')

@section('page')

@if(session()->has('success'))
<script>
    Swal.fire('Data Save Successfully...','','success');
</script>
@endif

<main class="contact_details">
    <form action="{{url('/contact_details/upload')}}" method="POST">
        @csrf
        <p class="py-3 h5 text-center bg-dark text-light">Contact Details</p>
        <div class="p-4">
            <div class="form-group">
                <label class="h6 m-0">Mobile Number</label>
                <input class="form-control" type="text" name="mobile" value="{{$mobile}}" required="require">
            </div>
            <div class="form-group">
                <label class="h6 m-0">Email Address</label>
                <input class="form-control" type="text" name="email" value="{{$email}}" required="require">
            </div>
            <button class="btn btn-primary mr-3">
                <span class="h6">SAVE</span>
            </button>
        </div>
    </form>
</main>
@endsection