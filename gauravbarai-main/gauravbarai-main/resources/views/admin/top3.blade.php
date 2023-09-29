@extends('admin.index')

@section('page')

@if(session()->has('error'))
<script>
    Swal.fire('Something Went wrong','','error');
</script>
@endif

@if(session()->has('set'))
<script>
    Swal.fire('TOP-3 Set Successfully...','','success');
</script>
@endif

<main class="top_3_portfolio">
    <p class="py-3 bg-dark text-center h5 text-light">SELECT TOP 3 </p>
    <form action="{{url('/portfolio/set_top3')}}" method="POST" class="p-4">
        @csrf
        @for($i=0; $i<3; $i++)
        <div class="d-flex align-items-center mb-3">
            <label class="h6 m-0 pr-3" for="">Top-{{$i+1}}</label>
            <select class="w-50 custom-select" name="top_portfolio[]" id="">
                @foreach($portfolio as $p)
                    @if($top_portfolio[$i]->index===$p->id)
                        <option value="{{$p->id}}" selected>{{$p->title}}</option>
                    @else
                        <option value="{{$p->id}}">{{$p->title}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        @endfor
        <button class="btn btn-primary">
            <span class="h6">SAVE</span>
        </button>
    </form>
</main>
@endsection