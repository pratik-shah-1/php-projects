<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Products extends Controller{

    public function products(){
    	$res = DB::table('products')
    	->leftjoin('orders','products.id','=','orders.product_id')
    	->select('products.img','products.name','products.id','products.price','products.details')
    	->selectRaw('count(orders.product_id) as orders')
    	->groupBy('products.img','products.id','products.name','products.price','products.details')
    	->get();
    	// echo "<pre>";
    	// echo json_encode($res,JSON_PRETTY_PRINT);
    	$category = DB::table('product_category')->select('category')->get();
    	return view('admin.products',['products'=>$res,'category'=>$category]);
    }
    public function product_details($id){
    	$res = DB::table('products')->where('id',$id)->get();
    	return view('admin.product',['product'=>$res[0]]);
    }
}
