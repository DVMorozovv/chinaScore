<?php

namespace App\Services;

use App\Models\Tariff;
use App\Models\UserTariff;

class TariffService
{

    public function checkTariffLimit($user_id){
        $userTariff = UserTariff::getUserTariff($user_id);

        if($userTariff){
            $tariff = Tariff::getTariff($userTariff->tariff_id);
            if($tariff->limit > $userTariff->until_limit) {
                $userTariff->until_limit += 1;
                $userTariff->save();
                $result = true;
                return $result;
            }
            else
                $result = false;
            return $result;
        }
        else{
            return null;
        }
    }

}
