<?php

namespace App\Http\Controllers;

// use App\Http\Models\Resume;
// use App\Http\Models\BackgroundImages;
// use App\Http\Models\Introcard;
// use App\Http\Models\Portfolio;
// use App\Http\Models\TopPortfolio;
// use App\Http\Models\SocialMediaLinks;
// use App\Http\Models\ContactDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class General extends Controller{

    public function home_view(){
        $backgrounds = DB::table('background_images')->get();
        $intro_card = DB::table('intro_card')->first();
        $top_portfolio = DB::table('top_portfolio')->get();
        $sml = DB::table('social_media_links')->get()->sortBy('index'); 
        $contact = DB::table('contact_details')->first(); 
        $portfolio = array();
        for($i=0; $i<count($top_portfolio); $i++){
            if(DB::table('portfolio')->where('id',$top_portfolio[$i]->index)->first())
            { 
                $tmp = DB::table('portfolio')->where('id',$top_portfolio[$i]->index)->first();
                $tmp->button_links = json_decode($tmp->button_links);
                $portfolio[$i] = $tmp;                
            }
        }
        $arr = ['backgrounds' => $backgrounds,
                'intro_card' => $intro_card,
                'portfolio' => $portfolio,
                'sml' => $sml,
                'contact' => $contact];

        return view('general.home', $arr);
    }

    public function portfolio_view(){
        $portfolio = DB::table('portfolio')->get()->sortBy('index');
        for($i=0; $i<count($portfolio); $i++){
            $portfolio[$i]->slider_images = json_decode($portfolio[$i]->slider_images);
            $portfolio[$i]->button_links = json_decode($portfolio[$i]->button_links);
            $portfolio[$i]->credits = json_decode($portfolio[$i]->credits);
        }
        return view('general.portfolio', ['portfolio'=>$portfolio]);
    }

    public function contact_view(){
        $sml = DB::table('social_media_links')->get()->sortBy('index');;
        $contact = DB::table('contact_details')->first();
        $background = DB::table('background_images')->where(['section'=>'contact_page'])->first();
        $arr = ['sml'=>$sml, 'contact'=>$contact, 'background'=>$background];
        return view('general.contact', $arr);
    }

}
