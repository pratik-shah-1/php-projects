<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\FooterText as FooterText_Model;

class FooterText extends Controller{

    public function view(){
        $footer_text = '';
        if(FooterText_Model::first()){
            $footer_text = FooterText_Model::first();
            $footer_text = $footer_text->footer_text;
        }
        return view('admin.footer_text', ['footer_text'=>$footer_text]);
    }

    public function upload(Request $req){
        $db_footer_text = FooterText_Model::first();
        if($db_footer_text)
            FooterText_Model::first()->update(['footer_text'=> $req->footer_text]);
        else
            FooterText_Model::create(['footer_text'=> $req->footer_text]);            

        return redirect('/admin/footer-text')->with('success',true);

    }


}
