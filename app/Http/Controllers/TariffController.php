<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index(){

        $tariffs = Tariff::all();

        return view('pages/tariff', ['tariffs'=>$tariffs]);
    }
}
