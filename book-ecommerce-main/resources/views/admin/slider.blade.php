@extends('admin.master')
@section('title','Admin-Slider')
@section('content')

<div class="py-2 position-fixed" style="bottom:10px;right:30px;">
  <form action="/admin/slider/add" method="POST" id="slider_form" enctype="multipart/form-data" >
    @csrf
    <label class="btn btn-primary rounded-circle" for="img">
      <i class="fas fa-plus"></i></label>
    <input type="file" id="img" name="img" accept="image/*" onchange="$('#slider_form').submit();" class="d-none">
  </form>
</div>

<div class="overflow-auto">
  <table class="table table-striped">
      <thead class="thead-dark">
          <tr>
              <th class="h5 font-weight-normal">Index</th>
              <th class="h5 font-weight-normal">View</th>
              <th class="h5 font-weight-normal">Action</th>
          </tr>
      </thead>
      <tbody>
          @php
            $i=0;
          @endphp
          @foreach($slider as $s)
          <tr>
              <td>{{++$i}}</td>
              <td><img class="rounded" src="{{asset($s->img)}}" alt=""style="width:250px;height:100px"></td>
              <td class="d-flex align-items-center">
                  <form method="POST" action="/admin/slider/update/{{$s->id}}" enctype="multipart/form-data" id="u_form_{{$s->id}}">
                    @csrf
                    <label for="u_img_{{$s->id}}" class="btn btn-warning m-0">
                      <i class="far fa-edit"></i></label>                  
                    <input type="file" id="u_img_{{$s->id}}" name="img" class="d-none" onchange="$('#u_form_{{$s->id}}').submit();">
                  </form>
                  <a href="/admin/slider/delete/{{$s->id}}" class="ml-3 btn btn-danger">
                    <i class="fas fa-times"></i></a>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
@endsection