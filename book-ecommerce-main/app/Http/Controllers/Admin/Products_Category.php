<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products_Category extends Controller{

	public function view(){
		$arr = DB::table('product_category')->get();
		return view('admin.product_category',['category'=>$arr]);
	}

	public function action(Request $req){
		$arr = ['category'=>$req->category];
		if($req->btn!='ADD' && $req->id!='')
			DB::table('product_category')->where('id',$req->id)->update($arr);
		else
			DB::table('product_category')->insert($arr);
		return redirect('/admin/product_category');
	}
	public function delete($id){
		DB::table('product_category')->where('id',$id)->delete();
		return redirect('/admin/product_category');
	}

}
