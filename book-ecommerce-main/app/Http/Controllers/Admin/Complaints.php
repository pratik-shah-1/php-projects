<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Complaints extends Controller{
    
    public function view(){
    	$res = DB::table('complaints')->get();
    	return view('admin.complaints',['complaints'=>$res]);
    }
    public function delete($id){
    	$res = DB::table('complaints')->where('id',$id)->delete();
    	return redirect('/admin/complaints');
    }
}
