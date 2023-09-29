<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\IntroCard as IntroCard_Model;

class IntroCard extends Controller{

    public function view(){
        $intro = '';
        if(IntroCard_Model::first()){
            $intro = IntroCard_Model::first();
            $intro = $intro->details;
        }
        return view('admin.intro_card', ['intro'=>$intro]);

    }

    public function upload(Request $req){
        $intro = IntroCard_Model::first();
        if($intro)
            IntroCard_Model::first()->update(['details'=>$req->intro]);
        else
            IntroCard_Model::create(['details'=>$req->intro]);
        
        return redirect('/admin/intro-card')->with('success',true);
    }

}
