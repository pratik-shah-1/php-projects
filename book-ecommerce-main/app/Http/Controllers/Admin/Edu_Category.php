<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Edu_Category extends Controller{
    
	public function view(){
		$field = DB::table('field')->get();
		$sem = DB::table('sem')->get();
		return view('admin.edu_category',['field'=>$field, 'sem'=>$sem]);
	}

	public function view_branches($id){
		$res = DB::table('field')->join('branch','field.field','=','branch.field')->where('field.id',$id)->select('branch.branch','field.field')->get();
		echo json_encode($res,JSON_PRETTY_PRINT);
	}

	public function action(Request $req){
		if(!isset($req->id)){
			DB::table('field')->insertGetId(['field'=>$req->field]);
		}
		else{
			DB::table('field')->where('id',$req->id)->update(['field'=>$req->field]);
			DB::table('branch')->where('field',$req->field)->delete();
		}
		for($i=0;$i<count($req->branch);$i++){
			if($req->branch[$i]!=""){
				$arr = ['field'=>$req->field,'branch'=>$req->branch[$i]];
				DB::table('branch')->insert($arr);
			}
		}
		return redirect('/admin/edu_category');
	}

	public function delete($field){
		DB::table('field')->where('field',$field)->delete();
		DB::table('branch')->where('field',$field)->delete();
		return redirect('/admin/edu_category');
	}

}
