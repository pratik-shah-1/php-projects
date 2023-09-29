<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Users extends Controller{

	public function view(Request $req){
		$arr = DB::table('users')
			->leftjoin('carts','users.id','=','carts.id')
			->leftjoin('orders','users.id','=','orders.user_id')
			->select('users.id','users.name','users.disable')
			->selectRaw('count(carts.id) as wishlist')
			->selectRaw('count(orders.user_id) as orders')
			->groupBy('users.id','users.name','users.disable')
			->get();
		// echo "<pre>";
		// echo json_encode($arr,JSON_PRETTY_PRINT);
		return view('admin.users',['users'=>$arr]);
	}

    public function disable($id){
    	DB::table('users')->where('id',$id)->update(['disable'=>true]);
    	return redirect('/admin/users');
    }

    public function enable($id){
    	DB::table('users')->where('id',$id)->update(['disable'=>'']);
    	return redirect('/admin/users');
    }

}
