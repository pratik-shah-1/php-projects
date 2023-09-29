@extends('admin.index')

@section('page')
<main class="social_media_links my-auto container">
    <div class="row">
        <!-- Add Social Media Links -->
        <div class="col-12 col-sm-6">
            <form action="{{url('social_media_links/add')}}" method="POST" class="shadow rounded overflow-hidden my-5 my-sm-0">
                @csrf
                <p class="py-3 h5 text-center bg-dark text-light">Add Social Media Links</p>
                <div class="p-4">
                    <select name="social_media_title" class="custom-select mb-3">
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="twitter">Twitter</option>
                        <option value="github">Github</option>
                        <option value="quora">Quora</option>
                        <option value="stackoverflow">Stackoverflow</option>
                        <option value="medium">Medium</option>
                        <option value="skype">Skype</option>
                        <option value="website">Website</option>
                    </select>
                    <input class="form-control mb-3" type="text" placeholder="Enter Label/ID" name="social_media_id" required="require">
                    <input class="form-control mb-3" type="text" placeholder="Link" name="social_media_link" required="require">
                    <button class="btn btn-primary mr-3">
                        <span class="h6">ADD</span>
                    </button>
                </div>
            </form>	
        </div>

        @if($sml)
        <!-- List of Social Media Links -->
        <div class="col-12 col-sm-6">
            <div class="shadow rounded overflow-hidden mb-5 mb-sm-0">
                <p class="bg-dark h5 text-light text-center py-3">Links</p>
                <div class="p-4 overflow-auto" style="height:350px;" id="arrange_social_media">
                    @foreach($sml as $sm)
                        <form action="{{url('/social_media_links/edit/'.$sm->id)}}" method="POST" class="mb-3 p-4 shadow">
                            @csrf
                            <input type="hidden" name="arrange[]" value='{{$sm->id}}'>
                            <select name="social_media_title" class="custom-select mb-3" id="sm_{{$sm->id}}">
                                <option value="instagram">Instagram</option>
                                <option value="facebook">Facebook</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="twitter">Twitter</option>
                                <option value="github">Github</option>
                                <option value="quora">Quora</option>
                                <option value="stackoverflow">Stackoverflow</option>
                                <option value="medium">Medium</option>
                                <option value="skype">Skype</option>
                                <option value="website">Website</option>
                            </select>
                            <script>
                                $('#sm_{{$sm->id}}').val(`{{$sm->title}}`).change(); 
                            </script>
                            <input class="form-control mb-3" type="text" value="{{$sm->social_media_id}}" name="social_media_id" required="require">
                            <input class="form-control mb-3" type="text" value="{{$sm->link}}" name="social_media_link" required="require">
                            <button class="btn btn-warning">
                                <span class="h6">UPDATE</span>
                            </button>
                            <a class="ml-3 btn btn-danger" onclick="delete_social_media(`{{$sm->id}}`)">
                                <span class="h6">DELETE</span>
                            </a>
                            <script>
                                function delete_social_media(id){
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        showCancelButton: true,
                                    })
                                    .then((result) => {
                                        if(result.isConfirmed){
                                            window.location = `{{url('/social_media_links/remove/'.$sm->id)}}`;
                                        }
                                    });
                                }
                            </script>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</main>

<script>
    new Sortable(arrange_social_media, {
        animation : 100,
        store : {
            set : function(){
                const element = $('[name="arrange[]"]');
                var order = [];
                const _token = $('[name="_token"]').val();
                for(let i=0; i<element.length; i++){
                    order.push(element[i].value);
                }
                $.ajax({
                    url : '/social_media_links/arrange',
                    method : 'POST',
                    data : {order, _token},
                    success : function(data){
                        console.log(data);
                    }
                })
            }
        }
    })
</script>

@if(session()->has('add'))
<script>
    Swal.fire('Social-Media-Link Added Successfully...','','success');
</script>
@endif

@if(session()->has('update'))
<script>
    Swal.fire('Social-Media-Link Updated Successfully...','','success');
</script>
@endif

@if(session()->has('remove'))
<script>
    Swal.fire('Social-Media-Link Deleted Successfully...','','success');
</script>
@endif


@endsection