<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopPortfolio extends Model{

    use HasFactory;
    protected $table = 'top_portfolio';
    protected $fillable = array('index');

}
