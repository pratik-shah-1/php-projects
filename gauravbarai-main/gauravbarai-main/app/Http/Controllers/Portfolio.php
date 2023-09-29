<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Portfolio as Portfolio_Model;

class Portfolio extends Controller{

    // VIEW_ADD PORTFORLIO 
    public function add_view(){
        return view('admin.portfolio_add');
    }

    // VIEW_ALL PORTFORLIO 
    public function list_view(){
        $portfolio;
        if(Portfolio_Model::all()){
            $portfolio = Portfolio_Model::all();
            // DECODE ALL JSON DATA...
            for($i=0; $i<count($portfolio); $i++){
                $portfolio[$i]->credits = json_decode($portfolio[$i]->credits);
                $portfolio[$i]->button_links = json_decode($portfolio[$i]->button_links);
                $portfolio[$i]->slider_images = json_decode($portfolio[$i]->slider_images);
            }            
        }
        return view('admin.portfolio_view', ['portfolio'=>$portfolio]);
    }

    // VIEW_EDIT PORTFORLIO 
    public function edit_view($id){
        if(Portfolio_Model::find($id)){
            $portfolio = Portfolio_Model::find($id);
            // DECODE ALL JSON DATA...
            $portfolio->credits = json_decode($portfolio->credits);
            $portfolio->button_links = json_decode($portfolio->button_links);
            $portfolio->slider_images = json_decode($portfolio->slider_images);
            return view('admin.portfolio_edit', ['portfolio'=>$portfolio]);
        }
    }



    public function add(Request $req){

        $title = $req->title;
        $index = 99999;
        $background = $req->background;         //----Image
        $icon = $req->icon;                     //----Image
        $description = $req->description;
        $slider_type = $req->slider_type;
        $slider_images = $req->slider_images;   //----Images
        $btn_title = $req->btn_title;
        $btn_link = $req->btn_link;

        // CREDITS..
        $credits = array();
        $button_links = array();
        $slider_path = array();

        // LISTS OF DESIGNERS
        if(count($req->designer_name)>0){
            $designer = array();
            for($i=0; $i<count($req->designer_name); $i++){
                if($req->designer_name[$i]!==null){
                    $designer[$i] = array('name'=>$req->designer_name[$i], 
                                              'link'=>$req->designer_link[$i]);
                }
            }
           if(!empty($designer[0]['name']))
                $credits['designer'] = $designer;
        }

        // LISTS OF DEVELOPERS...
        if(count($req->developer_name)>0){
            $developer = array();
            for($i=0; $i<count($req->developer_name); $i++){
                if($req->developer_name[$i]!==null){
                    $developer[$i] = array('name'=>$req->developer_name[$i], 
                                          'link'=>$req->developer_link[$i]);
                }
            }
           if(!empty($developer[0]['name']))
                $credits['developer'] = $developer;            
        }
        
        // LISTS OF ARTISTS...
        if(count($req->artist_name)>0){
            $artist = array();
            for($i=0; $i<count($req->artist_name); $i++){
                if($req->artist_name[$i]!==null){
                    $artist[$i] = array('name'=>$req->artist_name[$i], 
                                        'link'=>$req->artist_link[$i]);
                }
            }
            if(!empty($artist[0]['name']))
                $credits['artist'] = $artist;
        }

        // BUTTON LIKNS...
        for($i=0; $i<4; $i++){
            $button_links[$i] = array('title' => $btn_title[$i],
                                      'link' => $btn_link[$i]);
        }

        // UPLOAD BACKGROUND IMAGE...
        $background->move(public_path('/upload/portfolio/'.$title.'/'), 'background_'.$title);
        // UPLOAD ICON...
        $icon->move(public_path('/upload/portfolio/'.$title.'/'), 'icon_'.$title);
        // UPLOAD SLIDER IMAGES...
        for($i=0; $i<count($slider_images); $i++){
            $slider_images[$i]->move(public_path('/upload/portfolio/'.$title.'/slider/'), 'slider_'.$i);
            $slider_path[$i] = '/upload/portfolio/'.$title.'/slider/slider_'.$i;
        }

        $icon_path = '/upload/portfolio/'.$title.'/icon_'.$title;
        $background_path = '/upload/portfolio/'.$title.'/background_'.$title;

        // CONVERT ALL ARRAY INTO JSON FORMAT...
        $slider_path = json_encode($slider_path);
        $credits = json_encode($credits);
        $button_links = json_encode($button_links);

        $portfolio =  Portfolio_Model::create([
            'title' => $title,
            'index' => $index,
            'icon' => $icon_path,
            'background' => $background_path,
            'description' => $description,
            'credits' => $credits,
            'button_links' => $button_links,
            'slider_type' => $slider_type,
            'slider_images' => $slider_path
        ]);
        // SET INDEX NUMBER SAME AS GENERTED ID...
        Portfolio_Model::find($portfolio->id)->update(['index'=>$portfolio->id]);

        return redirect('/admin/portfolio/view')->with('add', true);
    }



    public function edit(Request $req, $id){
        $old_data = Portfolio_Model::find($id);
        $old_data->slider_images = json_decode($old_data->slider_images);

        $new_data = array('title' => $req->title,
                     'description' => $req->description,
                     'slider_type' => $req->slider_type);

        // BUTTON LINKS...
        $btn_title = $req->btn_title;
        $btn_link = $req->btn_link;
        $button_links = array();        
        for($i=0; $i<4; $i++){
            $button_links[$i] = array('title' => $btn_title[$i],
                                      'link' => $btn_link[$i]);
        }
        $new_data['button_links'] = json_encode($button_links);

        // CREDITS..
        $credits = array();

        // LISTS OF DESIGNERS
        if(count($req->designer_name)>0){
            $designer = array();
            for($i=0; $i<count($req->designer_name); $i++){
                if($req->designer_name[$i]!==null){
                    $designer[$i] = array('name'=>$req->designer_name[$i], 
                                          'link'=>$req->designer_link[$i]);                
                }
            }
           if(!empty($designer[0]['name']))
                $credits['designer'] = $designer;
        }

        // LISTS OF DEVELOPERS...
        if(count($req->developer_name)>0){
            $developer = array();
            for($i=0; $i<count($req->developer_name); $i++){
                if($req->developer_name[$i]!==null){
                    $developer[$i] = array('name'=>$req->developer_name[$i], 
                                          'link'=>$req->developer_link[$i]);
                }
            }
           if(!empty($developer[0]['name']))
                $credits['developer'] = $developer;            
        }
        
        // LISTS OF ARTISTS...
        if(count($req->artist_name)>0){
            $artist = array();
            for($i=0; $i<count($req->artist_name); $i++){
                if($req->artist_name[$i]!==null){
                    $artist[$i] = array('name'=>$req->artist_name[$i], 
                                        'link'=>$req->artist_link[$i]);
                }
            }
            if(!empty($artist[0]['name']))
                $credits['artist'] = $artist;
        }
        $new_data['credits'] = json_encode($credits, JSON_PRETTY_PRINT);


        // UPLOAD BACKGROUND IMAGE...
        if($req->background!==null){
            if( file_exists( public_path().$old_data->background ) ){
                unlink(public_path().$old_data->background);
            }
            $req->background->move(public_path('/upload/portfolio/'.$req->title.'/'), 'background_'.$req->title);
            $new_data['background'] = '/upload/portfolio/'.$req->title.'/background_'.$req->title;
        }

        // UPLOAD ICON...
        if($req->icon!==null){
            if( file_exists( public_path().$old_data->icon ) ){
                unlink(public_path().$old_data->icon);
            }
            $req->icon->move(public_path('/upload/portfolio/'.$req->title.'/'), 'icon_'.$req->title);
            $new_data['icon'] = '/upload/portfolio/'.$req->title.'/icon_'.$req->title;
        }

        // UPLOAD SLIDER IMAGES...
        if($req->slider_images!==null){
            // DELETE OLD IMAGES...
            for($i=0; $i<count($old_data->slider_images); $i++){
                if( file_exists( public_path().$old_data->slider_images[$i]) ){
                    unlink(public_path().$old_data->slider_images[$i] );
                }
            }
            // UPLOAD LATEST IMAGES...
            $slider_path = array();
            for($i=0; $i<count($req->slider_images); $i++){
                $req->slider_images[$i]->move(public_path('/upload/portfolio/'.$req->title.'/slider/'), 'slider_'.$i);
                $slider_path[$i] = '/upload/portfolio/'.$req->title.'/slider/slider_'.$i;
            }
            // SAVE LATEST IMAGE PATH IN DATABASE...
            $new_data['slider_images'] = json_encode($slider_path);
        }

        // Save Updated Data in Database...
        Portfolio_Model::find($id)->update($new_data);

        return redirect('/admin/portfolio/view')->with('edit', true);

    }

    public function remove($id){
        $data = Portfolio_Model::find($id);
        // DELETE SLIDER ....
        if(file_exists(public_path('/upload/portfolio/'.$data['title'].'/slider'))){
            $files = glob(public_path('/upload/portfolio/'.$data['title']).'/slider/*', GLOB_MARK);
            foreach ($files as $file){
                unlink($file);
            }
            if(public_path('/upload/portfolio/'.$data['title'].'/slider')){
                rmdir(public_path('/upload/portfolio/'.$data['title'].'/slider'));
            }            
        }

        // DELETE BACKGROUND IMAGES AND ICON...
        if(file_exists(public_path('/upload/portfolio/'.$data['title'].'/'))){
            $files = glob(public_path('/upload/portfolio/'.$data['title']).'/*', GLOB_MARK);
            foreach ($files as $file){
                unlink($file);
            }
            rmdir(public_path('/upload/portfolio/'.$data['title']));            
        }
        $data->delete();
        return redirect('/admin/portfolio/view')->with('remove', true);
    }


}
