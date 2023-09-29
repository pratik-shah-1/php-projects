<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Portfolio;
use App\Http\Models\TopPortfolio as TopPortfolio_Model;

class TopPortfolio extends Controller{

    public function view(){
        $top_portfolio = array();
        $portfolio = Portfolio::all();
        if(count(TopPortfolio_Model::all())==3){
            $top_portfolio = TopPortfolio_Model::all()->sortBy('index');
        }
        else{
            for($i=0; $i<3; $i++){
                TopPortfolio_Model::create([
                    'index'=>$portfolio[$i]->id
                ]);
                $top_portfolio[$i] = ['index'=>$portfolio[$i]->id];
            }
            $top_portfolio = json_encode($top_portfolio);
            $top_portfolio = json_decode($top_portfolio);
        }
        return view('admin.top3', ['portfolio'=>$portfolio, 'top_portfolio'=>$top_portfolio]);
    }

    public function set(Request $req){
        $portfolio = Portfolio::all();
        $old_top_portfolio = TopPortfolio_Model::all();
        $index =  $req->top_portfolio;

        if($index[0]!==$index[1] && $index[1]!==$index[2] && $index[0]!==$index[2]){
            if(count($old_top_portfolio)==3){
                for($i=0; $i<3; $i++){
                    $id = $old_top_portfolio[$i]->id;
                    TopPortfolio_Model::find($id)->update(['index'=> $index[$i]]);
                }                
            }
        }
        else{
            return redirect('/admin/portfolio/top-3')->with('error', true);
        }
        return redirect('/admin/portfolio/top-3')->with('set', true);
        
    }

}
