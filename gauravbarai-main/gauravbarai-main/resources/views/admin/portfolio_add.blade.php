@extends('admin.index')

@section('page')

@if(session()->has('add'))
    <script>Swal.fire('Porfolio added successfully...','','success');</script>
@endif
<main class="porfolio my-5">
    <p class="bg-dark text-light py-3 text-center h5">Porfolio</p>
    <form onsubmit="return checkValidation();" action="{{url('/portfolio/upload')}}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        <div class="custom-file mb-3">
            <label class="custom-file-label">
                <span class="h6">Background Image <span class="text-danger">*</span></span>
            </label>
            <input class="custom-file-input" type="file" name="background" accept="image/*" required>
        </div>
        <hr>
        <div class="mb-3">
            <label class="h6" for="">Title <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="title" placeholder="Title" required>
        </div>
        <div class="custom-file mb-3">
            <label class="custom-file-label">
                <span class="h6">Icon Image <span class="text-danger">*</span></span>
            </label>
            <input class="custom-file-input" type="file" name="icon" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label class="h6" for="">Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="description" placeholder="Description" maxlength="210" style="height:100px;" required></textarea>
        </div>
        <hr>
        <div>
            <label class="h6" for="">Choose Multiple Images <span class="text-danger">*</span></label>
            <div class="d-flex py-3">
                <div class="d-flex align-items-center">
                    <label class="h6 m-0 pr-2" for="vertical">Vertical</label>
                    <input type="radio" name="slider_type" value="vertical" id="vertical" required checked>  
                </div>
                <div class="ml-3 d-flex align-items-center">
                    <label class="h6 m-0 pr-2" for="horizontal">Horizontal</label>
                    <input type="radio" name="slider_type" value="horizontal" id="horizontal"> 
                </div>
            </div>
            <div class="custom-file mb-3">
                <label class="custom-file-label">
                    <span class="h6">Slider Images <span class="text-danger">*</span></span>
                </label>
                <input class="custom-file-input" type="file" name="slider_images[]" multiple="multiple" required>
            </div>  
        </div>
        <hr>
        <div class="mb-3">
            <label class="h6" for="">Credits</label>
            <div class="p-3">
                <div class="mb-3">
                    <label class="h6 d-flex align-items-center"><span style="width:90px">Designers<span class="text-danger">*</span></span><a onclick="add_designer(this)" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a></label>
                    <div class="mb-2">
                        <input class="form-control" type="text" placeholder="Name" name="designer_name[]" required>    
                        <input class="form-control mt-2" type="text" placeholder="Website" name="designer_link[]">  
                    </div>
                </div>
                <div class="mb-3">
                    <label class="h6 d-flex align-items-center"><span style="width:90px">Developers<span class="text-danger">*</span></span> <a onclick="add_developer(this)" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a></label>
                    <div class="mb-2">
                        <input class="form-control" type="text" placeholder="Name" name="developer_name[]" required>    
                        <input class="form-control mt-2" type="text" placeholder="Website" name="developer_link[]">     
                    </div>
                </div>
                <div class="mb-3">
                    <label class="h6 d-flex align-items-center"><span style="width:90px">Artists</span><a onclick="add_artist(this)" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a></label>
                    <div class="mb-2">
                        <input class="form-control" type="text" placeholder="Name" name="artist_name[]">    
                        <input class="form-control mt-2" type="text" placeholder="Website" name="artist_link[]">    
                    </div>
                </div>                
            </div>
        </div>
        <hr>
        <div>
            <label class="h6" for="">Button Links <span class="text-danger">*</span></label>
            <p class="m-0 pb-1 small text-danger">* Download button before WebGL button *</p>
            <p class="small text-danger">* All button value must be different *</p>
            @for($i=0; $i<4; $i++)
            <div class="d-flex justify-content-between mb-3">
                <select class="custom-select w-50" name="btn_title[]">
                    <option value="download">Download</option>
                    <option value="youtube">YouTube</option>
                    <option value="playstore">PlayStore</option>
                    <option value="webgl">WebGL</option>
                    <option value="gdd">GDD</option>
                </select>
                <input class="form-control" type="text" placeholder="Download" name="btn_link[]" required>
            </div>
            @endfor
        </div>
        <button class="btn btn-primary">
            <span class="h6">ADD</span>
        </button>
    </form>
</main>

<script>

function checkValidation(){
    var btnArr = [];
    var breakVar = false;
    const btn = $('[name="btn_title[]"]');
    for(let i=0; i<btn.length; i++){
        btnArr.push(btn[i].value);
    }

    // CHECK ALL BUTTON MUST BE DIFFERENT...
    var checkDownloadBtn;
    var checkWebGLBtn;
    for(let i=0; i<btnArr.length; i++){
        if(btnArr[i]=='download'){
            checkDownloadBtn = i;
        }
        if(btnArr[i]=='webgl'){
            checkWegGLBtn = i;
        }
        for(let j=0; j<btnArr.length && j!==i; j++){
            if(btnArr[i]==btnArr[j]){
                breakVar = true;
                break;
            }
        }
        if(breakVar==true){
            Swal.fire('All button must be different','','warning');
            return false;
        }
    }
    if(checkDownloadBtn>checkWegGLBtn){
        Swal.fire('Download must be before WebGL','','warning');
        return false;
    }
}    

function add_developer(element){
    Swal.fire({
        title: 'Are you conscious?',
        showCancelButton: true,
    })
    .then((res)=>{
        if(res.isConfirmed){
            const html = `
                    <input class="form-control" type="text" placeholder="Name" name="developer_name[]" required>    
                    <input class="form-control mt-2" type="text" placeholder="Website" name="developer_link[]">`;
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = html;
            element.parentElement.parentElement.appendChild(div);
        }
    });
}

function add_artist(element){
    Swal.fire({
        title: 'Are you conscious?',
        showCancelButton: true,
    })
    .then((res)=>{
        if(res.isConfirmed){
            const html = `
                    <input class="form-control" type="text" placeholder="Name" name="artist_name[]" required>    
                    <input class="form-control mt-2" type="text" placeholder="Website" name="artist_link[]">`;
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = html;
            element.parentElement.parentElement.appendChild(div);
        }
    });
}

function add_designer(element){
    Swal.fire({
        title: 'Are you conscious?',
        showCancelButton: true,
    })
    .then((res)=>{
        if(res.isConfirmed){
            const html = `
                    <input class="form-control" type="text" placeholder="Name" name="designer_name[]" required>    
                    <input class="form-control mt-2" type="text" placeholder="Website" name="designer_link[]">`;
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = html;
            element.parentElement.parentElement.appendChild(div);
        }
    });
}

</script>

@endsection