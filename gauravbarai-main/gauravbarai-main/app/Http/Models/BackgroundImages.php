<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundImages extends Model{

    use HasFactory;
    protected $table = 'background_images';
    protected $fillable = array('section', 'image');

}
