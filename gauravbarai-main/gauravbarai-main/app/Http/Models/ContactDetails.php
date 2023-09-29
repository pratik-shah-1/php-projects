<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetails extends Model{

    use HasFactory;
    protected $table = 'contact_details';
    protected $fillable = array('email', 'mobile');

}
