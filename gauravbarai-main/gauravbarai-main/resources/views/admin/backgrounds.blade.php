@extends('admin.index')

@section('page')

@if(session()->has('success'))
<script>
    Swal.fire('Upload Successfully...','','success');
</script>
@endif

<main class="bg_images">
    <p class="bg-dark text-light h5 py-3 text-center">Background Images</p>
    <form action="{{url('/background_images/upload')}}" method="POST" class="p-4" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column mb-3">
            <div class="custom-file">
                <label class="custom-file-label">Section-1</label>
                <input class="custom-file-input" type="file" name="section1" accept="image/*">
            </div>
        </div>
        <div class="d-flex flex-column mb-3">
            <div class="custom-file">
                <label class="custom-file-label">Section-2</label>
                <input class="custom-file-input" type="file" name="section2" accept="image/*">
            </div>
        </div>
        <div class="d-flex flex-column mb-3">
            <div class="custom-file">
                <label class="custom-file-label">Section-3</label>
                <input class="custom-file-input" type="file" name="section3" accept="image/*">
            </div>
        </div>  
        <div class="d-flex flex-column mb-3">
            <div class="custom-file">
                <label class="custom-file-label">Contact-Page</label>
                <input class="custom-file-input" type="file" name="contact_page" accept="image/*">
            </div>
        </div>  
        <div>
            <button class="btn btn-primary">
                <span class="h6">UPLOAD</span>
            </button>
        </div>
    </form>

    @if($backgrounds)
        <!-- Background Images -->
        <div class="d-flex flex-column align-items-center justify-content-center my-3">
            @foreach($backgrounds as $bg)
            <div class="my-3" style="width:250px;height:auto;">
                <p class="h6 text-capitalize">Section-{{$bg->section}}</p>
                <img src="{{asset($bg->image)}}" class="img-fluid" alt="">
            </div>
            @endforeach
        </div>
    @endif

</main>


@endsection