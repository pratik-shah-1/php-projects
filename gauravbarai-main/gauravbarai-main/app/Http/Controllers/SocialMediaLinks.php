<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\SocialMediaLinks as SocialMediaLinks_Model;

class SocialMediaLinks extends Controller{

    public function view(){
        $sml = '';
        $data = SocialMediaLinks_Model::all()->sortBy('index');
        if(count($data)>0){
            $sml = $data;
        }
        return view('admin.social_media_links', ['sml'=>$sml]);
    }

    public function remove($id){
        SocialMediaLinks_Model::find($id)->delete();
        return redirect('admin/social-media-links')->with('remove', true);
    }

    public function edit(Request $req, $id){
        $title = $req->social_media_title;
        $sid = $req->social_media_id;
        $link = $req->social_media_link;
        SocialMediaLinks_Model::find($id)
        ->update([
            'title' => $title,
            'social_media_id' => $sid,
            'link' => $link
        ]);
        return redirect('/admin/social-media-links')->with('update',true);
    }

    public function arrange(Request $req){
        for($i=0; $i<count($req->order); $i++){
            SocialMediaLinks_Model::find($req->order[$i])->update(['index'=>$i]);
        }
    }
    
    public function add(Request $req){
        $title = $req->social_media_title;
        $id = $req->social_media_id;
        $link = $req->social_media_link;
        $insertData = SocialMediaLinks_Model::create([
            'title' => $title,
            'index' => 9999,
            'social_media_id' => $id,
            'link' => $link
        ]);
        SocialMediaLinks_Model::find($insertData->id)->update(['index'=>$insertData->id]);
        return redirect('/admin/social-media-links')->with('add',true);
    }


}
