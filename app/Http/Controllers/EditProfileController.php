<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function updateUserPassword(Request $req){
        $user = Auth::user();
        $validate = Validator::make($req->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'old_password' => ['required', 'string'],
        ]);

        $password = $req['password'];
        $old_password = $req['old_password'];

        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($password);
            $user->save();
            return redirect()->back()->withSuccess('Пароль был успешно изменен');
        }
        $validate->errors()->add('field', 'Неверный пароль');
        return redirect()->back()->withErrors($validate);
    }
}
