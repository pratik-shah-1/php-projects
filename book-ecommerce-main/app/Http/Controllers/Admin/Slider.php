<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Slider extends Controller{

	public function view(){
		$res = DB::table('slider')->get();
		return view('admin.slider',['slider'=>$res]);
	}

	public function add(Request $req){
        $imgObj = $req->img;
        $file_name = time()."_".rand(1000,9999)."_".rand(10,99);
        $imgObj->move(public_path("upload/slider/"), $file_name);
        $img_loc = 'upload/slider/'.$file_name;
		DB::table('slider')->insert(['img'=>$img_loc]);
		return redirect('/admin/slider');
	}

	public function update(Request $req , $id){
        $imgObj = $req->img;
        $file_name = time()."_".rand(1000,9999)."_".rand(10,99);
        $imgObj->move(public_path("upload/slider/"), $file_name);
        $img_loc = 'upload/slider/'.$file_name;
		DB::table('slider')->where('id',$id)->update(['img'=>$img_loc]);
		return redirect('/admin/slider');
	}

	public function delete($id){
		DB::table('slider')->where('id',$id)->delete();
		return redirect('/admin/slider');
	}

}
