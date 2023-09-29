@extends('admin.index')

@section('page')

@if(session()->has('remove'))
    <script>Swal.fire('Porfolio Deleted successfully...','','success');</script>
@endif

@if(session()->has('add'))
    <script>Swal.fire('Porfolio Added successfully...','','success');</script>
@endif

@if(session()->has('edit'))
    <script>Swal.fire('Porfolio Updated successfully...','','success');</script>
@endif

@if(isset($portfolio))
    @foreach($portfolio as $p)
    <div class="shadow position-relative w-100 h-100 overflow-hidden">
        <!-- Background -->

        <div class="position-absolute" style="z-index:-1;">
            <img style="opacity:50%; object-fit:contain;"  src="{{$p->background}}" alt="">
        </div>

        <div class="bg-light rounded mx-sm-auto  mx-3 my-5" style="max-width:400px;">

            <!-- Title -->
            <div class="py-4 d-flex align-items-center justify-content-center">
                <img class="rounded-circle" style="width:32px;height:32px" src="{{$p->icon}}" alt="">
                <p class="m-0 pl-2 h6">{{$p->title}}</p>
            </div>

            <!-- Slider Images -->
            <div class="owl-carousel owl-theme">
                @for($i=0; $i<count($p->slider_images); $i++)
                    @if($p->slider_type=='horizontal')
                        <div class="item" style="width:250px;margin:auto;">
                            <img  src="{{$p->slider_images[$i]}}" >
                        </div>
                    @elseif($p->slider_type=='vertical')
                        <div class="item" style="width:150px;margin:auto;">
                            <img  src="{{$p->slider_images[$i]}}" >
                        </div>                    
                    @endif
                @endfor
            </div>      

            <!-- Details -->
            <div class="px-4 py-2">
                <p class="overflow-auto" style="height:150px;font-size:14px;">
                    {{$p->description}}
                </p>

                <div class="credits">
                    <p class="h5">Credits</p>
                    
                    <!-- Designers -->
                    @isset($p->credits->designer)
                    <div class="d-flex align-items-center mb-2">
                        <p class="h6 m-0">Designed By</p>
                        <span class="px-2">:</span>
                        @foreach($p->credits->designer as $designer)
                            @if($designer->link!==null)
                                <a class="h6 m-0" href="{{$designer->link}}">{{$designer->name}}</a>&nbsp;
                            @else
                                <p class="h6 m-0">{{$designer->name}}</p>&nbsp;
                            @endif
                        @endforeach
                    </div>
                    @endisset

                    <!-- Developers -->
                    @isset($p->credits->developer)
                    <div class="d-flex align-items-center mb-2">
                        <p class="h6 m-0">Developed By</p>
                        <span class="px-2">:</span>
                        @foreach($p->credits->developer as $developer)
                            @if($developer->link!==null)
                                <a class="h6 m-0" href="{{$developer->link}}">{{$developer->name}}</a>&nbsp;
                            @else
                                <p class="h6 m-0">{{$developer->name}}</p>&nbsp;
                            @endif
                        @endforeach
                    </div>
                    @endisset
                    <!-- Artists -->
                    @isset($p->credits->artist)
                    <div class="d-flex align-items-center mb-2">
                        <p class="h6 m-0">Artist By</p>
                        <span class="px-2">:</span>
                        @foreach($p->credits->artist as $artist)
                            @if($artist->link!==null)
                                <a class="h6 m-0" href="{{$artist->link}}">{{$artist->name}}</a>&nbsp;
                            @else
                                <p class="h6 m-0">{{$artist->name}}</p>&nbsp;
                            @endif
                        @endforeach
                    </div>
                    @endisset
                </div>
                <!-- Buttons -->
                <div class="py-3 d-flex flex-column flex-sm-row justify-content-between">
                    @for($i=0; $i<4; $i++)
                        @if($p->button_links[$i]->title=='download')
                        <a href="{{url($p->button_links[$i]->link)}}" class="btn btn-sm btn-primary mb-2 mx-auto">
                            <span class="h6">Download</span>
                        </a>
                        @elseif($p->button_links[$i]->title=='playstore')
                        <a href="{{url($p->button_links[$i]->link)}}" class="btn btn-sm btn-primary mb-2 mx-auto">
                            <span class="h6">PlayStore</span>
                        </a>
                        @elseif($p->button_links[$i]->title=='youtube')
                        <a href="{{url($p->button_links[$i]->link)}}" class="btn btn-sm btn-primary mb-2 mx-auto">
                            <span class="h6">YouTube</span>
                        </a>
                        @elseif($p->button_links[$i]->title=='gdd')
                        <a href="{{url($p->button_links[$i]->link)}}" class="btn btn-sm btn-primary mb-2 mx-auto">
                            <span class="h6">GDD</span>
                        </a>
                        @elseif($p->button_links[$i]->title=='webgl')
                        <a href="{{url($p->button_links[$i]->link)}}" class="btn btn-sm btn-primary mb-2 mx-auto">
                            <span class="h6">WebGL</span>
                        </a>
                        @endif
                    @endfor
                </div>
                <!-- Edit Delete Buttons -->
                <div class="d-flex justify-content-center py-3">
                    <a href="{{url('admin/portfolio/edit/'.$p->id)}}" class="btn btn-warning">
                        <span class="h6">EDIT</span>
                    </a>
                    <a class="mx-2 btn btn-danger" onclick="delete_portfolio(`{{$p->id}}`)">
                        <span class="h6">DELETE</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
<script>
    function delete_portfolio(id){
        Swal.fire({
            title: 'Are you sure?',
            showCancelButton: true
        })
        .then((result) => {
            if(result.isConfirmed){
                window.location = `{{url('/portfolio/remove/${id}')}}`;
            }
        });
    }
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        navText:[
                "<div class='nav-btn prev-slide'><i class='fas fa-chevron-circle-left'></i></div>",
                "<div class='nav-btn next-slide'><i class='fas fa-chevron-circle-right'></i></div>"],
        items:1
    });
</script>

@endsection
