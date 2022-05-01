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
                return ['checkTariff' => true, 'userTariff'=>$userTariff, 'tariff'=>$tariff];  //есть тариф и лимит
            }
            else
              return  ['checkTariff' => false, 'userTariff'=>$userTariff, 'tariff'=>$tariff]; // тариф есть, лимит закончился
        }
        else{
            return null; // нет тарифа
        }
    }

    public function getUserTariffLimit($user_id){
        $checkTariff = $this->checkTariffLimit($user_id);

        if(isset($checkTariff) && $checkTariff['checkTariff'] == true){

            $limit = $checkTariff['tariff']->limit - $checkTariff['userTariff']->until_limit;
            return $limit;
        }
        elseif (isset($checkTariff) && $checkTariff['checkTariff'] == false){

            return 0;
        }
        elseif ($checkTariff == null){

            return null;
        }
    }
}
