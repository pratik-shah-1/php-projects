<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Portfolio;

class ArrangePortfolio extends Controller{

    public function view(){
        $portfolio = Portfolio::all()->sortBy('index');
        return view('admin.arrange', ['portfolio'=>$portfolio]);   
    }

    public function arrange(Request $req){
        for($i=0; $i<count($req->arrange); $i++){
            Portfolio::find($req->arrange[$i])->update(['index'=>$i+1]);
        }
        return redirect('admin/portfolio/arrange')->with('arrange',true);
    }

}
