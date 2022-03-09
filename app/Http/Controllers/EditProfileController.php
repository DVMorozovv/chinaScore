<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditProfileController extends Controller
{
    public function RedactProfileForm(Request $req){
        $user_id = Auth::user()->getAuthIdentifier();
        $user = User::find($user_id);

        $validate = $req->validate([
            'name' => 'required|min:1|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);
        $name = $validate['name'];
        $email = $validate['email'];

        User::select()->find($user_id)->update(array('email' => $email, 'name' => $name));

        return redirect()->back()->withSuccess('Информация обновлена');
    }
}
