<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Models\Balance;
use App\Models\ReferalPayment;
use App\Models\ReferalSystemConfig;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTariff;
use App\Services\PaymentService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{

    /**
     * @var PaymentService
     */
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function index(){
        $balance = Balance::getBalance(Auth::user()->getAuthIdentifier());
        $transactions = Transaction::select()->where('user_id', '=', Auth::user()->getAuthIdentifier())->orderBy('id', 'desc')->get();
        return view('pages.payment-yoo', ['transactions'=>$transactions, 'balance' => $balance]);
    }

    public function callback(Request $req){
        $source = file_get_contents('php://input');
//        log::error($source);
        $requestBody = json_decode($source, true);

        $notification = (isset($requestBody['event']) && $requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationWaitingForCapture($requestBody);
        $payment = $notification->getObject();

        if(isset($payment->status) && $payment->status === 'waiting_for_capture'){
            $this->paymentService->getClient()->capturePayment([
                'amount' => $payment->amount,
            ], $payment->id, uniqid('', true));
        }

        if(isset($payment->status) && $payment->status === 'succeeded'){
            if((bool)$payment->paid === true){
                $metadata = (object)$payment->metadata;
                if(isset($metadata->transaction_id)){
                    $transactionId = (int)$metadata->transaction_id;
                    $transaction = Transaction::find($transactionId);
                    $transaction->status = PaymentStatusEnum::CONFIRMED;
                    $transaction->save();

                    Balance::changeBalance((int)$metadata->user_id, (float)$payment->amount->value);

                }
            }

        }

    }

    public function create(Request $req){
        $validate = $req->validate([
            'amount' => 'required|numeric|min:1'
        ]);
        $amount = $validate['amount'];
//        $amount = $req->input('amount');
        $description = $req->input('description');

        $user_id = Auth::user()->getAuthIdentifier();

        $transaction = Transaction::create([
            'amount' => $amount,
            'description' => $description,
            'user_id' => $user_id,
        ]);

        if($transaction){
            $link = $this->paymentService->createPayment($amount, $description, [
                'transaction_id' => $transaction->id,
            ]);
        }
        return redirect()->away($link);

    }


    public function buyTariff(Request $req){

        $user_id = Auth::user()->getAuthIdentifier();
        $balance = Balance::getBalance($user_id);

        $tariff_id = $req->get('tariff_id');
        $tariff = Tariff::find($tariff_id);

        $sum = $tariff->price;

        if($balance >= $tariff->price){

            $sumRequest ='-'.$sum;

            $transaction = new Transaction();
            $transaction->amount = $sumRequest;
            $transaction->description = PaymentTypeEnum::BUY;
            $transaction->status = PaymentStatusEnum::CONFIRMED;
            $transaction->user_id = $user_id;
            $transaction->save();

            $user_tariff = new UserTariff();
            $user_tariff->user_id = $user_id;
            $user_tariff->tariff_id = $tariff_id;
            $user_tariff->payment_id = $transaction->id;
            $user_tariff->status = 1;
            $user_tariff->days_end_sub = $tariff->duration;
            $user_tariff->save();

            Balance::changeBalance($user_id, $sumRequest);

            $referrerFirst = Auth::user()->getReferrer();
            if ($referrerFirst) {
                $this->paymentService->payReferrer($referrerFirst, Auth::user(), 1, $sum);
            }

            return redirect()->back()->withSuccess('Подписка успешно куплена');
        }else {
            return redirect()->back()->withSuccess('Ошибка');
        }
    }


}
