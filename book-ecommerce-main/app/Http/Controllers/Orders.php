<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Orders extends Controller{

	public function proceed($oid){
		DB::table('delivery')->insert(['order_id'=>$oid,'delivery_status'=>1]);
		return redirect('/shoper/orders');
	}

	public function shoper_orders(){
		$s_id = session()->get("SLogged");
		$res = DB::table('orders')
		->leftjoin('shopers','orders.shoper_id','=','shopers.id')
		->leftjoin('users','orders.user_id','=','users.id')
		->leftjoin('products','products.id','=','orders.product_id')
		->leftjoin('delivery','orders.id','=','delivery.order_id')
		->select('orders.id as oid',
				 'products.id as pid',
				 'products.name as pname',
				 'users.name as uname',
				 'orders.quantity AS oquantity',
				 'delivery.delivery_status',
				 'products.price')
		->where('shoper_id',$s_id)->get();
		for($i=0;$i<count($res);$i++){			
			if($res[$i]->delivery_status==1){
				$res[$i]->btn_class = 'btn btn-primary';
				$res[$i]->delivery_status_name = 'Pick Up';
			}
			if($res[$i]->delivery_status==2){
				$res[$i]->btn_class = 'btn-secondary';
				$res[$i]->delivery_status_name = 'Transit';
			}
			if($res[$i]->delivery_status==3){
				$res[$i]->btn_class = 'btn-info';
				$res[$i]->delivery_status_name = 'Out For Delivery';
			}
			if($res[$i]->delivery_status==4){
				$res[$i]->btn_class = 'btn-success';
				$res[$i]->delivery_status_name = 'Delivered';
			}
		}
		// echo "<pre>";
		// echo json_encode($res,JSON_PRETTY_PRINT);
		return view('shopers.orders',['orders'=>$res]);		
	}

	public function user_orders(){
		$u_id = session()->get("Logged");
		$res = DB::table('orders')
		->leftjoin('delivery','orders.id','=','delivery.order_id')
		->select('orders.*','delivery.delivery_status')
		->where('user_id',$u_id)
		->get();
		for($i=0;$i<count($res);$i++){
			//This Below Variable is not from database we manually assigned...
			$res[$i]->status1="";
			$res[$i]->status2="";
			$res[$i]->status3="";
			$res[$i]->status4="";

			if($res[$i]->delivery_status==4){
				$res[$i]->status1="text-primary";
				$res[$i]->status2="text-primary";
				$res[$i]->status3="text-primary";
				$res[$i]->status4="text-primary";				
			}
			if($res[$i]->delivery_status==3){
				$res[$i]->status1="text-primary";
				$res[$i]->status2="text-primary";
				$res[$i]->status3="text-primary";
			}
			else if($res[$i]->delivery_status==2){
				$res[$i]->status1="text-primary";
				$res[$i]->status2="text-primary";
			}
			else if($res[$i]->delivery_status==1){
				$res[$i]->status1="text-primary";
			}

		}
		return view('users.orders',['orders'=>$res]);
	}

}




