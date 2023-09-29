<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterText extends Model{
    use HasFactory;
    protected $table = 'footer_line';
    protected $fillable = array('footer_text');    
}
