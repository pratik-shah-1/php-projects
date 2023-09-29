<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\ContactDetails as ContactDetails_Model;

class ContactDetails extends Controller{

    public function view(){
        $email = '';
        $mobile = '';
        if(ContactDetails_Model::first()){
            $data = ContactDetails_Model::first();
            $email = $data->email;
            $mobile = $data->mobile;
        }
        return view('admin.contact_details', ['email'=>$email, 'mobile'=>$mobile]);
    }

    public function upload(Request $req){
        $contact_details = ContactDetails_Model::first();
        if($contact_details){
            ContactDetails_Model::first()->update([
                'email' => $req->email,
                'mobile' => $req->mobile
            ]);            
        }
        else{
            ContactDetails_Model::create([
                'email' => $req->email,
                'mobile' => $req->mobile
            ]);
        }
        return redirect('/admin/contact-details')->with('success',true);
    }

}
