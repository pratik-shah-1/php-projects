<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Checkout extends Controller{
    
	public function checkout_form(Request $req){
		$u_id = session()->get('Logged');
		$res = DB::table('users')->where('users.id',$u_id)->leftjoin('users_address','users.id','=','users_address.id')->get();
		$arr = ['user' => $res[0], 
		        'total_amount' => $req->total_amount, 
		        'coupon_code' => $req->coupon_code];
		return view('users.checkout',$arr);
	}

	public function checkout_process(Request $req){
		$u_id = session()->get('Logged');
		$res = DB::table('users_address')->where('id',$u_id)->exists();
		$arr = ['state'=>'', 
		        'city'=>'', 
		        'address'=>$req->address, 
		        'zcode'=>$req->zcode];
		if($res==""){
			$arr['id'] = $u_id;
			DB::table('users_address')->insert($arr);
		}
		else{
			DB::table('users_address')->where('id',$u_id)->update($arr);			
		}
		$this->set_orders($req->coupon_code, $req->total_amount, $req->payment_method);			return redirect('/cart');
	}

	public function set_orders($c_code, $t_amount, $p_method){
		//Will Make Auto delete data from sql database after certain time...
		$u_id = session()->get('Logged');
		$payment_status = 'Online';
		if($p_method=='cod')
			$payment_status = 'COD';
		$arr = DB::table('carts')
		->leftjoin('products','carts.product_id','=','products.id')
		->leftjoin('shopers_products','products.id','=','shopers_products.product_id')
		->select('products.*',
				 'carts.quantity AS cquantity',
				 'products.id AS pid',
				 'shopers_products.id AS sid')
		->where('carts.id', $u_id)
		->get();

		$total_amount = 0;
		for($i=0; $i<count($arr); $i++){
			$total_amount+= $arr[$i]->cquantity * $arr[$i]->price;
			$inner_arr = ['user_id'=>$u_id,
				    'shoper_id'=>$arr[$i]->sid,
				    'product_id'=>$arr[$i]->pid,
				    'quantity'=>$arr[$i]->cquantity,
				    'payment_status'=>$payment_status,
				    'order_time'=>date('d-m-y')];
		    DB::table('orders')->insert($inner_arr);
		    DB::table('carts')
		    ->where('id',$u_id)
		    ->where('product_id',$arr[$i]->pid)
		    ->delete();
		}
	    session()->put('cart_items',0);
		// if($total_amount<500){
		// 	$total_amount+=50;//For Delivery Charge..
		// }

		// if($total_amount == $t_amount){
		// 	if($c_code!="" && $total_amount>=500){
		// 		$res = DB::table('coupons')->where('code', $c_code)->get();
		// 		if($res[0]->id!="" && $res[0]->discount!=""){
		// 			$total_amount -= (float)((int)$res[0]->discount/100)*$total_amount;
		// 		}
		// 	}
		// }
		//For Apply Coupons...
		//Total amount we can be put in order table because of user don't know from which shopers he buy products he assume that he's buying from one store but actually it's different different store...		

	}

	public function online_payment(Request $req){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
		            array("X-Api-Key:test_e4457b650e7193c659c84f80bb0",
		                  "X-Auth-Token:test_798acc65adfa557ac962813b47d"));
		$payload = Array(
		    'purpose' => 'Book Buying',
		    'amount' => $req->total_amount,
		    'phone' => $req->mobile,
		    'buyer_name' => $req->name,
		    'redirect_url' => 'http://localhost:8000/after_checkout/online',
		    'email'=>'pratikjadav29@gmail.com',
		    'send_email' => true,
		    'allow_repeated_payments' => false
		);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
		$response = curl_exec($ch);
		curl_close($ch); 
		return redirect('https://test.instamojo.com/@pratikjadav29/126c6d0c45834ac79aeede0dc36902a3');
	}

}
