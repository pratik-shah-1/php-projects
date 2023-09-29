<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Account extends Controller{
    
    public function signin(Request $req){
    	$res = DB::table('admin')->where('email',$req->email)->where('pswd',$req->pswd)->get();
        $req->session()->put('ALogged',true);
        $req->session()->flash('signin',true);
    	return redirect('/admin');
    }

    public function counts(){
       $slider = DB::table('slider')->count();
       $p_category = DB::table('product_category')->count();
       $field = DB::table('field')->count();
       $coupons = DB::table('coupons')->count();
       $complaints = DB::table('complaints')->count();
       $orders = DB::table('orders')->count();
       $products = DB::table('products')->count();
       $shopers = DB::table('shopers')->count();
       $users = DB::table('users')->count();
        $arr = ['slider'=>$slider,
                'p_category'=>$p_category,
                'e_category'=>$field,
                'coupons'=>$coupons,
                'complaints'=>$complaints,
                'orders'=>$orders,
                'products'=>$products,
                'shopers'=>$shopers,
                'users'=>$users,
                'selling'=>0];
        return view('admin.index',$arr);
    }

    public function signout(){
    	session()->pull('ALogged');
    	return redirect('/admin/login');
    }

}
