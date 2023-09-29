<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Admin as Admin_Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Controller{

    // ADMIN LOGIN VIEW
    public function login_view(Request $req){
        if(!$req->session()->has('ADMIN'))
            return view('admin.login');
        else
            return redirect()->route('welcome');
    }

    // ADMIN WELCOME VIEW
    public function welcome_view(Request $req){
        if($req->session()->has('ADMIN'))
            return view('admin.welcome');
        else
            return redirect()->route('login');
    }

    // AUTHENTICATION OF ADMIN...
    public function auth(Request $req){
        $admin = Admin_Model::where(['email'=>$req->username])->get();
        if(count($admin)==0){
            if($req->username=='gadmin@gmail.com' && $req->password=='Gadmin@123'){
                Admin_Model::create([
                    'email'=> $req->username,
                    'password'=> Hash::make($req->password)
                ]);
                $admin = Admin_Model::where(['email'=>$req->username])->get();
                if(Hash::check($req->password, $admin[0]->password)){
                    $req->session()->put('ADMIN',true);
                    return redirect()->route('welcome')->with('login',true);
                }                            
            }
            else{
                $req->session()->flash('error',true);
                return redirect()->route('login');                                
            }
        }
        else if(count($admin)>0){
            if(Hash::check($req->password, $admin[0]->password)){
                $req->session()->put('ADMIN',true);
                return redirect()->route('welcome')->with('login',true);
            }
            else{
                $req->session()->flash('error',true);
                return redirect()->route('login');                
            }
        }
        else{
            $req->session()->flash('error',true);
            return redirect()->route('login');
        }
    }

    // ADMIN LOGOUT
    public function logout(Request $req){
        if($req->session()->has('ADMIN')){
            $req->session()->pull('ADMIN');
            return redirect()->route('login')->with('logout',true);
        }
    }

}


