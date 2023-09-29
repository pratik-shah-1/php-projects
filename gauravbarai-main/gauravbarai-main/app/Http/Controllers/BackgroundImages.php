<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Models\BackgroundImages as BackgroundImages_Model;

class BackgroundImages extends Controller{

    public function view(){
        $backgrounds = '';
        if(BackgroundImages_Model::all())
            $backgrounds = BackgroundImages_Model::all();
        return view('admin.backgrounds', ['backgrounds'=>$backgrounds]);
    }

    // UPLOAD IMAGES...
    public function upload(Request $req){               

        if($req->section1)
            $this->upload_image($req->section1, 1);            
        if($req->section2)
            $this->upload_image($req->section2, 2);            
        if($req->section3)
            $this->upload_image($req->section3, 3);            
        if($req->contact_page)
            $this->upload_image($req->contact_page, 'contact_page');            
        return redirect('/admin/backgrounds')->with('success','');

    }

    public function upload_image($image, $section){
        // CHECK PATH OF IMAGE IN DB...
        $dbimg = BackgroundImages_Model::where('section', $section)->get();
        if(count($dbimg)>0){
            if( file_exists(public_path($dbimg[0]->image)) ){
                unlink( public_path($dbimg[0]->image) );
            }
            // UPLOAD IMAGE...
            $filename = 'background_'.$section;
            $image->move(public_path('/upload/portfolio/backgrounds/'), $filename);

            BackgroundImages_Model::where('id', $dbimg[0]->id)
            ->update(['image'=>'/upload/portfolio/backgrounds/'.$filename]);
        }
        else{
            // UPLOAD IMAGE...
            $filename = 'background_'.$section;
            $image->move(public_path('/upload/portfolio/backgrounds/'), $filename);
            BackgroundImages_Model::create([
                'section' => $section,
                'image' => '/upload/portfolio/backgrounds/'.$filename
            ]);            
        }

    }




}
