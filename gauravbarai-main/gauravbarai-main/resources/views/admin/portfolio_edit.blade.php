@extends('admin.index')

@section('page')

<main class="porfolio my-5">
    <p class="bg-dark text-light py-3 text-center h5">Porfolio Edit</p>
    <form onsubmit="return checkValidation();" action="{{url('/portfolio/edit/'.$portfolio->id)}}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        <div class="custom-file mb-3">
            <label class="custom-file-label">
                <span class="h6">Background Image</span>
            </label>
            <input class="custom-file-input" type="file" name="background" accept="image/*">
        </div>
        <hr>
        <div class="mb-3">
            <label class="h6" for="">Title</label>
            <input class="form-control" type="text" name="title" placeholder="Title" required value="{{$portfolio->title}}">
        </div>
        <div class="custom-file mb-3">
            <label class="custom-file-label">
                <span class="h6">Icon Image</span>
            </label>
            <input class="custom-file-input" type="file" name="icon" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="h6" for="">Description</label>
            <textarea class="form-control" name="description" placeholder="Description" maxlength="210" style="height:100px;" required>{{$portfolio->description}}</textarea>
        </div>
        <hr>
        <div>
            <label class="h6" for="">Choose Multiple Images</label>
            <div class="d-flex py-3">
                @php
                    $vertical = '';
                    $horizontal = '';
                    if($portfolio->slider_type=='vertical')
                        $vertical = 'checked';
                    else if($portfolio->slider_type=='horizontal')
                        $horizontal = 'checked';
                @endphp
                <div class="d-flex align-items-center">
                    <label class="h6 m-0 pr-2" for="vertical">Vertical</label>
                    <input type="radio" name="slider_type" value="vertical" id="vertical" {{$vertical}} required>  
                </div>
                <div class="ml-3 d-flex align-items-center">
                    <label class="h6 m-0 pr-2" for="horizontal">Horizontal</label>
                    <input type="radio" name="slider_type" value="horizontal" id="horizontal" {{$horizontal}}> 
                </div>
            </div>
            <div class="custom-file mb-3">
                <label class="custom-file-label">
                    <span class="h6">Slider Images</span>
                </label>
                <input class="custom-file-input" type="file" name="slider_images[]" multiple="multiple">
            </div>  
        </div>
        <hr>
        <div class="mb-3">
            <label class="h6" for="">Credits</label>
            <div class="p-3">
                <div class="mb-3">
                    <label class="h6 d-flex">
                        <span style="width:90px">Designers<span class="text-danger">*</span></span> 
                        <a onclick="add_designer(this)" class="btn btn-sm btn-warning">
                            <i class="fas fa-plus"></i>
                        </a>
                    </label>
                    @if(isset($portfolio->credits->designer))
                        @foreach($portfolio->credits->designer as $designer)
                            <div class="mb-2">
                                <input class="form-control" type="text" placeholder="Name" name="designer_name[]" value="{{$designer->name}}">
                                <input class="form-control mt-2" type="text" placeholder="Website" name="designer_link[]" value="{{$designer->link}}">
                            </div>
                        @endforeach
                    @else
                        <div class="mb-2">
                            <input class="form-control" type="text" placeholder="Name" name="designer_name[]">
                            <input class="form-control mt-2" type="text" placeholder="Website" name="designer_link[]">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="h6 d-flex" for="">
                        <span style="width:90px">Developers<span class="text-danger">*</span></span> 
                        <a onclick="add_developer(this)" class="btn btn-sm btn-warning">
                            <i class="fas fa-plus"></i>
                        </a>
                    </label>
                    @if(isset($portfolio->credits->developer))
                        @foreach($portfolio->credits->developer as $developer)
                            <div class="mb-2">
                                <input class="form-control" type="text" placeholder="Name" name="developer_name[]" value="{{$developer->name}}">
                                <input class="form-control mt-2" type="text" placeholder="Website" name="developer_link[]" value="{{$developer->link}}">
                            </div>
                        @endforeach                
                    @else
                        <div class="mb-2">
                            <input class="form-control" type="text" placeholder="Name" name="developer_name[]">
                            <input class="form-control mt-2" type="text" placeholder="Website" name="developer_link[]">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="d-flex h6" for="">
                        <span style="width:90px">Artists<span class="text-danger">*</span></span> 
                        <a onclick="add_developer(this)" class="btn btn-sm btn-warning">
                            <i class="fas fa-plus"></i>
                        </a>
                    </label>
                    @if(isset($portfolio->credits->artist))
                        @foreach($portfolio->credits->artist as $artist)
                            <div class="mb-2">
                                <input class="form-control" type="text" placeholder="Name" name="artist_name[]" value="{{$artist->name}}">
                                <input class="form-control mt-2" type="text" placeholder="Website" name="artist_link[]" value="{{$artist->link}}">
                            </div>
                        @endforeach 
                    @else
                        <div class="mb-2">
                            <input class="form-control" type="text" placeholder="Name" name="artist_name[]">
                            <input class="form-control mt-2" type="text" placeholder="Website" name="artist_link[]">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <div>
            <label class="h6" for="">Buttons Link</label>
            <p class="m-0 pb-1 small text-danger">* Download button before WebGL button *</p>
            <p class="small text-danger">* All button value must be different *</p>
            @for($i=0; $i<4; $i++)
                @php
                    $download = '';
                    $youtube = '';
                    $webgl = '';
                    $gdd = '';
                    $playstore = '';
                    $btn_link = '';
                    if($portfolio->button_links[$i]->title=='playstore'){
                        $playstore = 'selected';
                        $btn_link = $portfolio->button_links[$i]->link;
                    }
                    else if($portfolio->button_links[$i]->title=='youtube'){
                        $youtube = 'selected';
                        $btn_link = $portfolio->button_links[$i]->link;
                    }
                    else if($portfolio->button_links[$i]->title=='download'){
                        $download = 'selected';
                        $btn_link = $portfolio->button_links[$i]->link;
                    }
                    else if($portfolio->button_links[$i]->title=='webgl'){
                        $webgl = 'selected';
                        $btn_link = $portfolio->button_links[$i]->link;
                    }
                    else if($portfolio->button_links[$i]->title=='gdd'){
                        $gdd = 'selected';
                        $btn_link = $portfolio->button_links[$i]->link;
                    }
                @endphp
            <div class="d-flex justify-content-between mb-3">
                <select class="custom-select w-50" name="btn_title[]">
                    <option {{$download}} value="download">Download</option>
                    <option {{$youtube}} value="youtube">YouTube</option>
                    <option {{$playstore}} value="playstore">PlayStore</option>
                    <option {{$webgl}} value="webgl">WebGL</option>
                    <option {{$gdd}} value="gdd">GDD</option>
                </select>
                <input class="form-control" type="text" placeholder="Download" name="btn_link[]" value="{{$btn_link}}" required>
            </div>
            @endfor
        </div>
        <button class="btn btn-primary">
            <span class="h6">UPDATE</span>
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