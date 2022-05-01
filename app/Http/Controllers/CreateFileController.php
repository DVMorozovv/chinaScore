<?php

namespace App\Http\Controllers;


use App\Models\Balance;
use App\Models\File;
use App\Models\Tariff;
use App\Models\UserTariff;
use App\Services\CreateExcelService;
use App\Services\DecodeJson;
use App\Services\FileService;
use App\Services\PaymentService;
use App\Services\SearchItemsService;
use App\Services\TariffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class CreateFileController extends Controller
{

    /**
     * @var FileService
     * @var CreateExcelService
     * @var PaymentService
     * @var TariffService
     */
    private $fileService;
    private $createExcelService;
    private $paymentService;
    private $tariffService;


    public function __construct(FileService $fileService, CreateExcelService $createExcelService, PaymentService $paymentService, TariffService $tariffService)
    {

        $this->fileService = $fileService;
        $this->createExcelService = $createExcelService;
        $this->paymentService = $paymentService;
        $this->tariffService = $tariffService;
    }


    public function checkForm(Request $req){

        $title = $req->title;
        $select = $req->filter;
        $isBuy = $req->isBuy;
        $range = $req->range;
        $id = $req->id;
//        dd($req);

        $userTariff = UserTariff::getUserTariff(Auth::user()->getAuthIdentifier());
        $defaultTariff = UserTariff::getDefaultTariff();
        $userBalance = Balance::getBalance(Auth::user()->getAuthIdentifier());

        if (isset($userTariff)){
            $userLimit = $this->tariffService->getUserTariffLimit(Auth::user()->getAuthIdentifier());
            $tariff = Tariff::getTariff($userTariff->tariff_id);
            $count_excel = ceil($range / $tariff->items_limit);
            $price = $count_excel*$defaultTariff->price;

            if($isBuy == true){
                if($userBalance >= $price){
                    $this->create_table($id, $title, $select, $isBuy, $range);
                    return redirect()->route('user-files');
                }
                else{
                    return redirect()->route('payment');
                }
            }
            else{

                if($count_excel > $userLimit){

                    return redirect()->route('payment');
                }
                else{
                    $this->create_table($id, $title, $select, $isBuy, $range);
                    return redirect()->route('user-files');
                }
            }

//            dd($userTariff, $userLimit, $tariff, $count_excel, $userBalance, $defaultTariff);
        }
        else{
            $count_excel = ceil($range / $defaultTariff->items_limit);
            $price = $count_excel*$defaultTariff->price;
            if($userBalance >= $price){
                $this->create_table($id, $title, $select, $isBuy, $range);
                return redirect()->route('user-files');
            }
            else{
                return redirect()->route('payment');
            }
//                        dd($userTariff, $defaultTariff,$userBalance,$count_excel,$price);

        }

    }


    public function create_table($id, $title, $select, $isBuy, $range){

        $frame_position = 0; // позиция товара с которой начинается создаваться эксель, летит в url

        $user_tariff = UserTariff::getUserTariff(Auth::user()->getAuthIdentifier());
        if(!$user_tariff==null){
            $tariff = Tariff::getTariff($user_tariff->tariff_id);
            $items_limit = $tariff->items_limit;
        }
        else{
            $items_limit = 1000;
        }

        if($range <= $items_limit){

            $data = $this->createExcelService->create_excel($title, $id, $select, $range, $frame_position);
            $file_name = $data['file_name'];

            if($isBuy == true){
                $this->paymentService->buyExcel();
            }

            UserTariff::incTariffLimit(Auth::user()->getAuthIdentifier());

            $this->fileService->saveFile("$file_name".".xlsx");
        }
        else {
            $items_count = $range;
            while($frame_position <= $range){

                if($items_count >= $items_limit){
                    $items_count -= $items_limit;
                }else
                    $items_limit = $items_count;

                $data = $this->createExcelService->create_excel($title, $id, $select, $items_limit, $frame_position);
                $frame_position = $data['frame_position'];

                $file_name = $data['file_name'];

                if($isBuy == true){
                    $this->paymentService->buyExcel();
                }

                UserTariff::incTariffLimit(Auth::user()->getAuthIdentifier());

                $this->fileService->saveFile("$file_name".".xlsx");


            }
        }

//        return redirect()->route('user-files');

    }
}
