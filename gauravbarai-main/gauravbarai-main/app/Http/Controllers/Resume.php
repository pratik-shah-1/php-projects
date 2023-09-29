<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Resume as Resume_Model;

class Resume extends Controller{

    public function view(){
        $resume = '';
        if(Resume_Model::first()){
            $resume = Resume_Model::first();
            $resume = $resume->resume;
        }
        return view('admin.resume', ['resume'=>$resume]);
    }

    public function upload(Request $req){
        // UPLOAD 
        $filename = 'Gaurav_Resume.pdf';
        $req->resume->move(public_path('/upload/resume/'), $filename);

        // CHECK IN DATEBASE...
        $resume = Resume_Model::first();
        if($resume)
            Resume_Model::first()->update(['resume'=>'/upload/resume/'.$filename]);
        else
            Resume_Model::create([ 'resume' => '/upload/resume/'.$filename ]);

        return redirect('/admin/resume');
    }

}

            // NOT NEED TO DELETE BECAUSE New FILE OVERWRITE on OLD FILE...
            // if(file_exists(public_path().$resume->resume)){
            //     unlink(public_path().$resume->resume);
            // }
