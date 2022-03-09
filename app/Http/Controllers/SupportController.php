<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function SupportForm(Request $req){

        $validate = $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone-demo' => 'required|numeric',
            'message' => 'required|max:1500',
        ]);
        $name = $validate['name'];
        $email = $validate['email'];
        $phone = $validate['phone-demo'];
        $message = $validate['message'];

        $contact = new Contact();

        $contact->name = $name;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->message = $message;
        $contact->save();

        return redirect()->back()->withSuccess('Ваше сообщение отправлено');    }
}
