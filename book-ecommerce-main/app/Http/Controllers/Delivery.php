<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Delivery extends Controller{

	public function change_status($oid, $status){
		$arr = ['delivery_status'=>$status];
		DB::table('delivery')->where('order_id',$oid)->update($arr);
		return redirect('/delivery/');
	}

	public function view(){
		$res = DB::table('delivery')
		->join('orders','orders.id','=','delivery.order_id')
		->join('users','users.id','=','orders.user_id')
		->leftjoin('users_address','users.id','=','users_address.id')
		->join('products','products.id','=','orders.product_id')
		->select('users.name AS uname',
				'users_address.address',
				'users_address.zcode',
				'products.name as pname',
				'orders.payment_status',
				'orders.order_time',
				'orders.quantity',
				'products.price',
				'orders.id',
				'delivery.delivery_status')
		->get();
		// echo "<pre>";
		// echo json_encode($res,JSON_PRETTY_PRINT);
		return view('delivery.index',['orders'=>$res]);
	}

}
