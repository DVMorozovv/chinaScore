<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
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

}
