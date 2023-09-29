<?php

namespace App\Http\Controllers\Shopers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Account extends Controller{

    //Form
    public function form(){
        if(session()->has('SLogged')){
            return redirect('/shoper/products');
        }
        else{
            $state = DB::table('state_city')->select('state')->distinct()->get();
            $city = DB::table('state_city')->select('city')
            ->where('state',$state[0]->state)->get();
            return view('shopers/index',['state'=>$state,'city'=>$city]);            
        }
    }

    //Login
    public function signin(Request $req){
        $res = DB::table('shopers')->where(['email'=>$req->email, 'pswd'=>$req->pswd])->get();
        if(isset($res[0]->id) && $res[0]->disable==""){
            $img = 'assets/img/blank_user.jpg';
            if($res[0]->img!="")
                $img = $res[0]->img;
            $req->session()->put('SLogged',$res[0]->id);
            $req->session()->put('sname',$res[0]->name);
            $req->session()->put('simg',$img);
            $req->session()->flash('signin',true);
            return redirect('/shoper/products');
        }
        else if($res[0]->disable!=""){
            $req->session()->flash('disable',true);
            return redirect('/shoper');
        }
        else{
            $req->session()->flash('wrong',true);
            return 'Login Failed!!!';
        }
    }

    public function signup(Request $req){

        if($req->pswd == $req->cpswd){
            DB::table('shopers')->insert([
                'name' => $req->name,
                'mobile' => $req->mobile,
                'email' => $req->email,
                'disable'=>'',
                'img' => '',
                'pswd' => $req->pswd]);
            
            $res = DB::table('shopers')
            ->where('email',$req->email)
            ->where('pswd',$req->pswd)->get();

            DB::table('shopers_address')->insert([
                'id'=>$res[0]->id,
                'state'=>$req->state,
                'city'=>$req->city,
                'address'=>$req->adrs,
                'zcode'=>$req->zcode
            ]);
            $req->session()->flash('signup',true);
        }
        else{
            $req->session()->flash('wrong',true);
        }
        return redirect('/shoper');                      
    }

    public function signout(){
        if(session()->has('SLogged')){
            session()->pull('SLogged');
            session()->pull('sname');
            session()->pull('simg');
            session()->flash('signout',true);
            return redirect('/shoper');
        }
    }

    function view_profile(Request $req){
    	$s_id = $req->session()->get('SLogged');	
		$shoper = DB::table('shopers')->join('shopers_address','shopers.id','=','shopers_address.id')->where('shopers.id',$s_id)->get();
    	$state = DB::table('state_city')->select('state')->distinct()->get();
        $temp = $shoper[0]->state!="" ? $shoper[0]->state : $state[0]->state;
        $city = DB::table('state_city')->select('city')->where('state',$temp)->get();
        $arr = ['shoper' =>$shoper[0], 'state' => $state, 'city' => $city ];
        return view('shopers.account', $arr);
    }

    function update_profile(Request $req){
    	$s_id = $req->session()->get('SLogged');    
        $arr = ['name' => $req->name, 'mobile' => $req->mobile];
        if($req->img!=""){
            $imgObj = $req->img;
            $file_name = time()."_".rand(1000,9999)."_".rand(10,99);
            $imgObj->move(public_path('upload/shopers/'.$s_id.'/'), $file_name);
            $img_loc = 'upload/shopers/'.$s_id.'/'.$file_name;
            $arr['img'] = $img_loc;
        }
        DB::table('shopers')->where('id',$s_id)->update($arr);
        //First Unset and Then Reset...
        $res = DB::table('shopers')->where('id',$s_id)->get();
        $req->session()->pull('sname');
        $req->session()->pull('simg');
        $req->session()->put('sname',$res[0]->name);
        $req->session()->put('simg',$res[0]->img);
        $req->session()->flash('update',true);
        return redirect('/shoper/account');        
    }

    function update_password(Request $req){
    	$s_id = $req->session()->get('SLogged');    
        $res = DB::table('shopers')->select(['pswd','name'])->where('id',$s_id)->get();
        if($req->pswd==$res[0]->pswd){
            if($req->npswd==$req->cpswd){
                DB::table('shopers')->where('id',$s_id)->update(['pswd' => $req->cpswd]);
                $req->session()->flash('update',true);
                return redirect('shoper/account');                
            }
        }
    }

    function update_address(Request $req){
        $s_id = $req->session()->get('SLogged');
        $arr = ['state'=> $req->state,'city'=>$req->city,'address'=>$req->address,'zcode'=>$req->zcode];
        DB::table('shopers_address')->where('id',$s_id)->update($arr);
        $req->session()->flash('update',true);
        return redirect('shoper/account');                
    }

    function delete_account(Request $req){
    	$s_id = $req->session()->get('SLogged');
        $res = DB::table('shopers')->where('id',$s_id)->where('pswd',$req->pswd)->get();
        if(count($res)>=0){
            $data = DB::table('shopers_products')->where('id',$s_id)->get();
            if(count($data)!=0){
                for($i=0;$i<count($data);$i++){
                    DB::table('products')->where('id',$data[$i]->product_id)->delete();
                    DB::table('sub_category')->where('id',$data[$i]->product_id)->delete();
                }
                DB::table('shopers_products')->where('id',$s_id)->delete();
                DB::table('shopers_address')->where('id',$s_id)->delete();
                DB::table('shopers')->where('id',$s_id)->delete();            
            }        
            $req->session()->pull('SLogged');
            $req->session()->pull('sname');
            $req->session()->pull('simg');
            return view('shopers.bye');                
        }
    }
    
}
