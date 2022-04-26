<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\Balance;
use App\Models\ReferalPayment;
use App\Models\ReferalSystemConfig;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;

class PaymentService
{

    public function getClient() :Client{

        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));
        return $client;
    }

    public function createPayment(float $amount, string $descriptions, array $options = []){

        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB',
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('payment'),
            ],
            'metadata' => [
                'transaction_id' => $options['transaction_id'],
                'user_id' => Auth::user()->getAuthIdentifier(),
            ],
            'description' => $descriptions,
        ], uniqid('', true));

        return $payment->getConfirmation()->getConfirmationUrl();
    }


    public function buyExcel(){
        $sum = 200;
        $user_id = Auth::user()->getAuthIdentifier();
        $balance = Balance::getBalance($user_id);

        if($balance >= $sum){

            $sumRequest ='-'.$sum;

            $transaction = new Transaction();
            $transaction->amount = $sumRequest;
            $transaction->description = PaymentTypeEnum::BUY_EXCEL;
            $transaction->status = PaymentStatusEnum::CONFIRMED;
            $transaction->user_id = $user_id;
            $transaction->save();

            Balance::changeBalance($user_id, $sumRequest);

            $referrerFirst = Auth::user()->getReferrer();
            if ($referrerFirst) {
                $this->payReferrer($referrerFirst, Auth::user(), 1, $sum);
            }
        }
    }

    public function payReferrer(User $referrer, User $referral, int $level, float $sum){
        try {
            if ($referrer) {
                $percent = ReferalSystemConfig::getPercent($level);
                $pofitReferrer = $sum * $percent;

                $refer_transaction = new Transaction();
                $refer_transaction->amount = $pofitReferrer;
                $refer_transaction->description = PaymentTypeEnum::REFERRAL_INCOME;
                $refer_transaction->status = PaymentStatusEnum::CONFIRMED;
                $refer_transaction->user_id = $referrer->getAuthIdentifier();
                $refer_transaction->save();

                Balance::changeBalance($referrer->getAuthIdentifier(), $pofitReferrer);

                $referalPayment = new ReferalPayment();
                $referalPayment->payment_id = $refer_transaction->id;
                $referalPayment->referal_id = $referral->id;
                $referalPayment->save();

                log::info('Создана запись выплаты рефереру', ['user' => $referrer->getAuthIdentifier(), 'sum' => $pofitReferrer]);
            }
        }
        catch (QueryException $exception){
            log::error('Ошибка выплаты рефереру', ['user' => $referrer->getAuthIdentifier(), 'exception'=>$exception->getMessage()]);
        }
    }
}
