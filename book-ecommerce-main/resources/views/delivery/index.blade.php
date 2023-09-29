<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MyBooks-Delivery-System</title>
	<link rel="stylesheet" href="{{asset('assets/lib/bootstrap/bootstrap.min.css')}}">
	<script src="{{asset('assets/lib/jquery.js')}}"></script>
	<style>
		th,td{
			border:2px solid lightgray !important;
			min-width:200px !important;
		}
	</style>
</head>
<body>

<p class="text-center py-3 display-4 m-0">My Book Delivery System</p>
<div class="overflow-auto">
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th class="h5 font-weight-normal">Index</th>
				<th class="h5 font-weight-normal">Custome Name</th>
				<th class="h5 font-weight-normal">Product Name</th>
				<th class="h5 font-weight-normal">Quantity</th>
				<th class="h5 font-weight-normal">Total Amount in Rs.</th>
				<th class="h5 font-weight-normal">Order Time</th>
				<th class="h5 font-weight-normal">Delivery Address</th>
				<th class="h5 font-weight-normal">Zip Code</th>
				<th class="h5 font-weight-normal">Delivery Status</th>
			</tr>
		</thead>
		<tbody>
			@php $i=0; @endphp
			@foreach($orders as $o)
			<tr>
				<td class="h5 font-weight-normal">{{++$i}}</td>
				<td class="h5 font-weight-normal">{{$o->uname}}</td>
				<td class="h5 font-weight-normal">{{$o->pname}}</td>
				<td class="h5 font-weight-normal">{{$o->quantity}}</td>
				<td class="h5 font-weight-normal">{{$o->quantity}}*{{$o->price}}={{$o->quantity * $o->price}}</td>
				<td class="h5 font-weight-normal">{{$o->order_time}}</td>
				<td class="h5 font-weight-normal">{{$o->address}}</td>
				<td class="h5 font-weight-normal">{{$o->zcode}}</td>
				<td>
					<form class="d-flex align-items-center">
						@csrf
						<select class="form-control" name="dstatus_{{$o->id}}" onchange="change_status(`{{$o->id}}`, this.value)">
							<option value="1">PickUp</option>
							<option value="2">Transit</option>
							<option value="3">Out for Delivery</option>
							<option value="4">Delivered</option>
						</select>
					</form>
					<script>
							$('[name="dstatus_{{$o->id}}"]').val(`{{$o->delivery_status}}`).change();
					</script>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script>
	function change_status(oid,status){
		window.location.href = '/delivery/change/'+oid+"/"+status;
	}
</script>

</body>
</html>