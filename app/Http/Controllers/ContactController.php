<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function ContactForm(Request $req){
        $contact = new Contact();

        $validate = $req->validate([
            'name' => 'required',
            'email' => 'required',
            'phone-demo' => 'required',
            'message' => 'nullable|max:255',
        ]);
        $name = $validate['name'];
        $email = $validate['email'];
        $phone = $validate['phone-demo'];
        $message = $validate['message'];

        $contact->name = $name;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->message = $message;
        $contact->save();

        return view('pages/support');
    }
}
