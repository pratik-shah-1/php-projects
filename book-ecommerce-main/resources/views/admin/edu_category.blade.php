@extends('admin.master')
@section('title','Admin-Product-Category')

@section('content')
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<th class="h5 font-weight-normal">Index</th>
			<th class="h5 font-weight-normal">Field Name</th>
			<th class="h5 font-weight-normal">Branch</th>
			<th class="h5 font-weight-normal">Action</th>
		</thead>
		<tbody>
			@php $i=0; @endphp
			@foreach($field as $f)
			<tr>
				<td class="h5 font-weight-normal">{{++$i}}</td>
				<td class="h5 font-weight-normal">{{$f->field}}</td>
				<td class="h5 font-weight-normal">
					@php
						$branch = DB::table('branch')->where('field',$f->field)->get()
					@endphp
					<select class="form-control">
						@foreach($branch as $b)
						<option value="{{$b->branch}}">{{$b->branch}}</option>
						@endforeach
					</select>
				</td>
				<td>
					<div class="d-flex">
						<button class="btn btn-warning" onclick="edit_field(`{{$f->id}}`)"><i class="fas fa-edit"></i></button>
						<a class="ml-2 btn btn-danger" href="/admin/edu_category/field/delete/{{$f->field}}"><i class="fas fa-times"></i></a>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="add_field_form d-none">
	<!-- Title -->
	<div class="bg-dark">
		<h5 class="pl-3 text-light m-0" name='title'>Add New </h5>	
		<button class="btn add_field_form_close_btn"><i class="fas fa-times text-danger"></i></button>	
	</div>
	<!-- Form -->
	<form action="/admin/edu_category/field/action" method="POST">
		@csrf
		<!-- Field  -->
		<h6>Field</h6>
		<input type="text" placeholder="Field Name" name="field" required>
		<!-- Branches -->
		<h6>Branches</h6>
		<!-- Dynamiclly input field generated inside input_branch class -->
		<div class="input_branch"></div>
		<div>
		<!-- Add more button for more input field -->
			<span class="btn btn-outline-warning add_more_btn"><i class="fas fa-plus"></i></span>		
			<button class="btn btn-primary" name="btn">Submit</button>			
		</div>
	</form>
</div>

<button class="btn btn-primary rounded-circle position-fixed add_field_btn" style="bottom:30px;right:30px">
	<i class="fas fa-plus"></i>
</button>



<script>

	$('.add_field_btn').click(function(){
		$('.random').addClass('backlight');
		$('.add_field_form').removeClass('d-none');
		$('[name="title"]').html('Add New');
		$('[name="field"]').val('');
		$('.input_branch').html(`<input type='text' placeholder='Branch Name' name='branch[]' required> `);	
		$('[name="btn"]').html('ADD');
	});

	$('.add_field_form_close_btn').click(function(){
		$('.random').removeClass('backlight');
		$('.add_field_form').addClass('d-none');
	});

	$('.add_more_btn').click(function(){
		$('.input_branch').append(`<input type="text" placeholder="Branch Name" name='branch[]'>`);
		$('.add_field_form').animate({scrollTop: $('.add_field_form')[0].scrollHeight}, "slow");
	});

	function edit_field(id){
		$.ajax({
			url:'/admin/edu_category/field/view/'+id,
			method:"GET",
			success:function(data){
				const d = JSON.parse(data);
				var input = "<input class='d-none' type='text' name='id' value='"+id+"'>";
				for(let i=0;i<d.length;i++){
					input += "<input type='text' value='"+d[i].branch+"' name='branch[]'>"; 
				}
				$('.random').addClass('backlight');
				$('.add_field_form').removeClass('d-none');
				$('[name="title"]').html('Update Field and Branch');
				$('[name="field"]').val(d[0].field);
				$('.input_branch').html(input);
				$('[name="btn"]').html('UPDATE');
			}
		});

	}
</script>
@endsection