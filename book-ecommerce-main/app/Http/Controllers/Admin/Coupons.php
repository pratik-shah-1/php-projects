<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Coupons extends Controller{

	public function coupons(){
		$res = DB::table('coupons')->get();
		return view('admin.coupons',['coupons'=>$res]);
	}
    public function action(Request $req){
    	if($req->btn!="ADD" && $req->id!=""){
	    	$arr = ['code'=>$req->code, 'discount'=>$req->discount, 'expiry'=>$req->expiry];
	    	DB::table('coupons')->where('id',$req->id)->update($arr);
    	}
    	else{
	    	$arr = ['code'=>$req->code, 'discount'=>$req->discount, 'expiry'=>$req->expiry];
	    	DB::table('coupons')->insert($arr);
    	}
    	return redirect('/admin/coupons');    		
    }

    public function delete(Request $req, $id){
    	DB::table('coupons')->where('id',$id)->delete();
		return redirect('/admin/coupons');
    }
}
