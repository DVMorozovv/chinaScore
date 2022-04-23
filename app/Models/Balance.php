<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];


    public static function getBalance($user_id){
        $balance = Balance::select()->where('user_id', '=', $user_id)->pluck('balance')->first();
        return $balance;
    }

    public static function changeBalance($user_id, $amount){
        $balance = Balance::select()->where('user_id', '=', $user_id)->first();
        $balance->balance += $amount;
        $balance->save();
    }


}
