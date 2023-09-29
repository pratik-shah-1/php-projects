<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Account extends Controller{

    public function signin(Request $req){
        $res = DB::table('users')->where(['email'=>$req->email,'pswd'=>$req->pswd])->get();
        if(isset($res[0]->id) && $res[0]->disable==""){
            $img = "assets/img/blank_user.jpg";
            if($res[0]->img!="")
                $img = $res[0]->img;
            $req->session()->put('Logged',$res[0]->id);
            $req->session()->put('name',$res[0]->name);
            $req->session()->put('img',$img);
            $data = DB::table('carts')->where('id',$res[0]->id)->get();
            $cart_items = 0;
            if(count($data)!=0){
                for($i=0;$i<count($data);$i++){
                    $cart_items+= (int)$data[$i]->quantity;
                }
            }
            $req->session()->put('cart_items',$cart_items);
            $req->session()->flash('signin',true);
            return redirect('/');
        }
        else if($res[0]->disable!=""){
            $req->session()->flash('disable',true);
            return redirect('/login');            
        }
        else{
            $req->session()->flash('wrong',true);
            return redirect('/login');
        }
    }

    public function signup(Request $req){
        if($req->pswd == $req->cpswd){
            DB::table('users')->insert([
                'name' => $req->name,
                'mobile' => $req->mobile,
                'email' => $req->email,
                'img' => '',
                'pswd' => $req->pswd,
                'disable'=>''
            ]);
            $req->session()->flash('signup',true);
        }
        else
            $req->session()->flash('wrong',true);
        return redirect('/login');                      
    }

    public function signout(){
        if(session()->has('Logged')){
            session()->pull('Logged');
            session()->pull('name');
            session()->pull('img');
            session()->pull('cart_items');
            session()->flash('signout',true);
        }
        return redirect('/');
    }

    function view_profile(Request $req){
    	$u_id = $req->session()->get('Logged');	
		$user = DB::table('users')->leftjoin('users_address','users.id','=','users_address.id')->where('users.id',$u_id)->get();
    	$state = DB::table('state_city')->select('state')->distinct()->get();
        $temp = $user[0]->state!=null ? $user[0]->state : $state[0]->state ;
        $city = DB::table('state_city')->select('city')->where('state',$temp)->get();
        return view('users.account',['user' => $user[0], 'state' => $state, 'city' => $city ]);
    }

    function update_profile(Request $req){
    	$u_id = $req->session()->get('Logged');    
        $arr = ['name' => $req->name,'mobile' => $req->mobile];
        if($req->img!=""){
            $imgObj = $req->img;
            $file_name = time()."_".rand(1000,9999).'_'.rand(10,99);
            $imgObj->move(public_path('upload/users/'.$u_id.'/'), $file_name);
            $img_loc = 'upload/users/'.$u_id.'/'.$file_name;            
            $arr['img'] = $img_loc;
        }
        DB::table('users')->where('id',$u_id)->update($arr);
        $res = DB::table('users')->where('id',$u_id)->get();
        $req->session()->pull('name');//because of we update name
        $req->session()->pull('img');//because of we update img_loc
        $req->session()->put('name',$res[0]->name);
        $req->session()->put('img',$res[0]->img);
        $req->session()->flash('update',true);
        return redirect('/account');        
    }

    function update_password(Request $req){
    	$u_id = $req->session()->get('Logged');    
        $res = DB::table('users')->select(['pswd','name'])->where('id',$u_id)->get();
        if($req->pswd==$res[0]->pswd){
            if($req->npswd==$req->cpswd){
                DB::table('users')->where('id',$u_id)->update(['pswd' => $req->cpswd]);
                $req->session()->flash('update',true);
                return redirect('/account');                
            }
        }
    }

    function action_address(Request $req){
        $u_id = $req->session()->get('Logged');
        $arr = ['state'=> $req->state,
                'city'=>$req->city,
                'address'=>$req->address,
                'zcode'=>$req->zcode];
        if($req->btn=='UPDATE'){
            DB::table('users_address')->where('id',$u_id)->update($arr);
            $req->session()->flash('update',true);
        }
        else{
            $arr['id'] = $u_id;
            DB::table('users_address')->insert($arr);
            $req->session()->flash('add',true);
        }
        return redirect('/account');                
    }

    function delete_account(Request $req){
    	$u_id = $req->session()->get('Logged');
        $res = DB::table('users')->where('id',$u_id)->where('pswd',$req->pswd)->get();
        if(count($res)>=0){
            $data = DB::table('users')->where('id',$u_id)->where('pswd',$req->pswd)->get();
            if(count($data)!=0){
                DB::table('carts')->where('id',$u_id)->delete();
                DB::table('users_address')->where('id',$u_id)->delete();
                DB::table('users')->where('id',$u_id)->delete();            
            }
            $req->session()->pull('Logged');
            $req->session()->pull('name');
            $req->session()->pull('img');
            $req->session()->pull('cart_items');
            return view('users.bye');                
        }
    }

    function find_city($state){
        $city = DB::table('state_city')
        ->select('city')
        ->where('state',$state)
        ->get();        
        echo json_encode($city);
    }

    function find_branches($field){
        $branches = DB::table('branch')
        ->select('branch')
        ->where('field',$field)
        ->get();        
        echo json_encode($branches);
    }

}
