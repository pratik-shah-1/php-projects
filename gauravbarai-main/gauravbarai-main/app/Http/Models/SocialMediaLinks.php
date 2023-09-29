<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLinks extends Model{

    use HasFactory;
    protected $table = 'social_media_links';
    protected $fillable = array('title', 'index', 'social_media_id', 'link');
}
