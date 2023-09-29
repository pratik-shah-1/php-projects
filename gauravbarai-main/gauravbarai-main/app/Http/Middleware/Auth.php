<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth{

    public function handle(Request $req, Closure $next){
        if($req->session()->has('ADMIN'))
            return $next($req);
        else
            return redirect()->route('login');
    }
}
