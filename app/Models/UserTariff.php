<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTariff extends Model
{
    use HasFactory;

    /**
     *
     * @return BelongsTo
     */
    public function getSubscription(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id', 'id');
    }

    public static function getSubDay(int $idUser){
        $days = UserTariff::select()->where('user_id', '=', $idUser)
            ->where('status', '=', 1)->get()->first();
        if(!empty($days)){
            $result = $days->days_end_sub;
        }
        else{
            $result = null;
        }

        return $result;
    }

    public static function getUserTariff(int $idUser){
        $userTariff = UserTariff::select()->where('user_id', '=', $idUser)->where('status', '=', 1)->get()->first();
        if(!empty($userTariff)){
            $result = $userTariff;
        }
        else{
            $result = null;
        }

        return $result;
    }

    public static function incTariffLimit(int $idUser){
        $userTariff = self::getUserTariff($idUser);
        if (isset($userTariff)) {
            $userTariff->until_limit += 1;
            $userTariff->save();
        }
    }

    public static function getDefaultTariff(){
        return Tariff::select()->where('name', '=', 'default')->get()->first();
    }

}
