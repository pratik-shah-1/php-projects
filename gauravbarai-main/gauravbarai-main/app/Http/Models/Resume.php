<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model{
    use HasFactory;
    protected $table = 'resume';
    protected $fillable = array('resume');
}
