<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model{
    use HasFactory;
    protected $table = 'portfolio';
    
    protected $fillable = array('title',
                                'index',
                                'icon',
                                'background',
                                'description',
                                'credits',
                                'slider_type',
                                'slider_images',
                                'button_links');
}
