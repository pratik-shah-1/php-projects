<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Shopers extends Controller{
    
    public function view(){

    	$arr1 = DB::table('shopers')
        ->leftjoin('shopers_products','shopers.id','=','shopers_products.id')
        ->select('shopers.id','shopers.name','shopers.disable',)
        ->selectRaw('count(shopers.id) as products')
        ->groupBy('shopers.id','shopers.name','shopers.disable')
    	->get();

        $arr2 = DB::table('shopers')
        ->leftjoin('orders','shopers.id','=','orders.shoper_id')
        ->select('shopers.id')
        ->selectRaw('count(orders.shoper_id) as orders')
        ->groupBy('shopers.id')
        ->get();

        for($i=0;$i<count($arr1);$i++){
            if($arr1[$i]->id == $arr2[$i]->id){
                $arr1[$i]->orders = $arr2[$i]->orders;
            }        
        }
    	return view('admin.shopers',['shopers'=>$arr1]);
        //This is Above code is Totally Wrong... 
        //You Have to Change. it...
    }

    public function disable($id){
    	DB::table('shopers')->where('id',$id)->update(['disable'=>true]);
    	return redirect('/admin/shopers');
    }

    public function enable($id){
    	DB::table('shopers')->where('id',$id)->update(['disable'=>'']);
    	return redirect('/admin/shopers');
    }


}
