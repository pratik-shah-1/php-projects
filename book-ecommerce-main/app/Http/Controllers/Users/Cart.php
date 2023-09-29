<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cart extends Controller{

	public function add(Request $req, $p_id){
		$u_id = $req->session()->get('Logged');
		$res = DB::table('carts')->where('id',$u_id)->where('product_id',$p_id)->get();
		if(count($res)==0){
			DB::table('carts')->insert([
				'id' => $u_id,
				'product_id' => $p_id,
				'quantity' => 1
			]);		
		}
		else if($res[0]->quantity>=0 && $res[0]->quantity<=4){
			DB::table('carts')->where('id',$u_id)->where('product_id',$p_id)->update([ 'quantity' => $res[0]->quantity + 1 ]);
		}

		//For Session Set...
		$req->session()->pull('cart_items');
		$res = DB::table('carts')->where('id',$u_id)->get();
		if(count($res)!=0){
            $cart_items = 0;
            for($i=0;$i<count($res);$i++){
                $cart_items+= (int)$res[$i]->quantity;
            }
            $req->session()->put('cart_items',$cart_items);
        }
		$req->session()->flash('add','success');
		return redirect('/');
	}

	public function items(Request $req){
		$u_id = $req->session()->get('Logged');
		$total_amount = 0;
		$delivery_charge = 0;
		$disable = '';
		//Because of if Amount is Zero then Checkout button must be disabled...
		$arr = DB::table('carts')->join('products','carts.product_id','=','products.id')->select('products.*','carts.quantity AS cquantity')->where('carts.id',$u_id)->get();
		for($i=0; $i<count($arr);$i++){
			$total_amount+= $arr[$i]->cquantity * $arr[$i]->price;
		}
		if($total_amount==0){
			$disable = 'disabled';
		}
		else if($total_amount<500 && $total_amount!=0){
			$delivery_charge = 50;
			$total_amount += $delivery_charge;
		}
		$arrr = ['items'=>$arr, 'total_amount'=>$total_amount, 'delivery_charge'=>$delivery_charge,'disable'=>$disable];
		return view('users.cart',$arrr);
		//How to Exclude of Except Specific column in Laravel or SQL Query...
	}

	public function increase(Request $req, $id){
		$u_id = $req->session()->get('Logged');
		$res = DB::table('carts')->where('id',$u_id)->where('product_id',$id)->get();
		if($res[0]->quantity>=0 && $res[0]->quantity<=4){
			DB::table('carts')->where('id',$u_id)->where('product_id',$id)->update(['quantity' => $res[0]->quantity + 1 ]);
		}
		//For Session Set...
		$req->session()->pull('cart_items');
		$res = DB::table('carts')->where('id',$u_id)->get();
		if(count($res)!=0){
            $cart_items = 0;
            for($i=0;$i<count($res);$i++){
                $cart_items+= (int)$res[$i]->quantity;
            }
            $req->session()->put('cart_items',$cart_items);
        }
		return redirect('/cart');
	}

	public function decrease(Request $req, $id){
		$u_id = $req->session()->get('Logged');
		$data = DB::table('carts')->where('id',$u_id)->where('product_id',$id)->get();
		if($data[0]->quantity<=5 && $data[0]->quantity>=2){
			DB::table('carts')->where('id',$u_id)->where('product_id',$id)->update(['quantity' => $data[0]->quantity - 1 ]);
		}
		//For Session Set...
		$req->session()->pull('cart_items');
		$data = DB::table('carts')->where('id',$u_id)->get();
		if(count($data)!=0){
            $cart_items = 0;
            for($i=0;$i<count($data);$i++){
                $cart_items+= (int)$data[$i]->quantity;
            }
            $req->session()->put('cart_items',$cart_items);
        }
		return redirect('/cart');
	}	

	public function remove(Request $req, $id){
		$u_id = $req->session()->get('Logged');
		$data = DB::table('carts')->where('id',$u_id)->where('product_id',$id)->delete();
		$req->session()->pull('cart_items');
		$data = DB::table('carts')->where('id',$u_id)->get();
		if(count($data)!=0){
            $cart_items = 0;
            for($i=0;$i<count($data);$i++){
                $cart_items+= (int)$data[$i]->quantity;
            }
            $req->session()->put('cart_items',$cart_items);
        }
		return redirect('/cart');
	}

}
