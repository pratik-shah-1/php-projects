@extends('admin.index')

@section('page')

@if(session()->has('success'))
<script>
    Swal.fire('Upload Successfully...','','success');
</script>
@endif

<main class="upload_resume">
    <p class="py-3 text-light text-center h5 bg-dark">Upload Resume</p>
    <form action="{{url('/resume/upload')}}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        <div class="custom-file">
            <label class="custom-file-label" for="">
                <span class="h6">Upload Resume</span>
            </label>
            <input class="custom-file-input" type="file" name="resume" accept="application/pdf">	
        </div>
        <button class="mt-3 btn btn-primary">
            <span class="h6">UPLOAD</span>
        </button>
        @if($resume)
            <div class="mt-3 text-center">
                <a class="h6" href="{{url($resume)}}" target="_blank">View</a>
            </div>
        @endif
    </form>
</main>
@endsection