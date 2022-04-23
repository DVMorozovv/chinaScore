<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferalSystemConfig extends Model
{
    use HasFactory;

    public static function getPercent(int $level)
    {
        return ReferalSystemConfig::select()->where('referal_level','=', $level)->get()->first()->percent;
    }
}
