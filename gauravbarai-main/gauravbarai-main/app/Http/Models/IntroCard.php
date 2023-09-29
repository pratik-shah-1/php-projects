<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroCard extends Model{
    use HasFactory;
    protected $table = 'intro_card';
    protected $fillable = array('details');
}
