<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function SupportForm(Request $req){

        $user = Auth::user();

        $validate = $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone-demo' => 'required|max:15',
            'message' => 'required|max:1500',
        ]);

        $name = $validate['name'];
        $email = $validate['email'];
        $phone = $validate['phone-demo'];
        $message = $validate['message'];

        $contact = new Support();

        $contact->name = $name;
        $contact->email = $email;
        $contact->user_id = $user->id;
        $contact->phone = $phone;
        $contact->message = $message;
        $contact->save();

        return redirect()->back()->withSuccess('Ваше сообщение отправлено');
    }
}
