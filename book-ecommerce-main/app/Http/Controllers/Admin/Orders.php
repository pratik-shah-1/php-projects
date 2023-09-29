<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Orders extends Controller{
	public function view(){
		$res = DB::table('orders')
		->leftjoin('users','users.id','=','orders.user_id')
		->leftjoin('products','products.id','=','orders.product_id')
		->leftjoin('delivery','delivery.order_id','=','orders.id')
		->select('users.name as uname',
				 'products.name as pname',
				 'orders.quantity as quantity',
				 'orders.order_time',
				 'orders.payment_status',
				 'delivery.delivery_status')
		->get();
		for($i=0;$i<count($res);$i++){
			if($res[$i]->delivery_status==1)
				$res[$i]->delivery_status = 'Pick UP';
			if($res[$i]->delivery_status==2)
				$res[$i]->delivery_status = 'Transit';
			if($res[$i]->delivery_status==3)
				$res[$i]->delivery_status = 'Out For Delivery';
			if($res[$i]->delivery_status==4)
				$res[$i]->delivery_status = 'Delivered';
		}
		// echo "<pre>";
		// echo json_encode($res,JSON_PRETTY_PRINT);
		return view('admin.orders',['orders'=>$res]);
	}
}
