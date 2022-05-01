<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Models\UserTariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TariffController extends Controller
{
    public function index(){

        $tariffs = Tariff::select()->where('is_active', '=', '1')->get();
        $user_tariff = UserTariff::getUserTariff(Auth::User()->getAuthIdentifier());
        if(empty($user_tariff)){
            return view('pages/tariff', ['tariffs'=>$tariffs]);
        }
        else
            return view('pages/tariff', ['tariffs'=>$tariffs, 'user_tariff'=>$user_tariff]);
    }
}
