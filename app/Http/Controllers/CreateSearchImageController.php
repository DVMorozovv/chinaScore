<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\File;
use App\Models\Tariff;
use App\Models\UserTariff;
use App\Services\FileService;
use App\Services\PaymentService;
use App\Services\SearchItemsService;
use App\Services\TariffService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateSearchImageController extends Controller
{
    /**
     * @var FileService
     * @var SearchItemsService
     * @var PaymentService
     * @var TariffService
     */
    private $fileService;
    private $searchItemsService;
    private $paymentService;
    private $tariffService;

    public function __construct(FileService $fileService, SearchItemsService $searchItemsService, PaymentService $paymentService, TariffService $tariffService)
    {

        $this->fileService = $fileService;
        $this->searchItemsService = $searchItemsService;
        $this->paymentService = $paymentService;
        $this->tariffService = $tariffService;
    }

    public function checkForm(Request $req){

        $image = $req->image;
        $select = $req->filter;
        $isBuy = $req->isBuy;
        $range = $req->range;

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
                    $this->create_table($image, $select, $isBuy, $range);
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
                    $this->create_table($image, $select, $isBuy, $range);
                    return redirect()->route('user-files');
                }
            }

//            dd($userTariff, $userLimit, $tariff, $count_excel, $userBalance, $defaultTariff);
        }
        else{
            $count_excel = ceil($range / $defaultTariff->items_limit);
            $price = $count_excel*$defaultTariff->price;
            if($userBalance >= $price){
                $this->create_table($image, $select, $isBuy, $range);
                return redirect()->route('user-files');
            }
            else{
                return redirect()->route('payment');
            }
//                        dd($userTariff, $defaultTariff,$userBalance,$count_excel,$price);

        }

    }

    public function create_table( $image, $select, $isBuy, $range){


//    log::info('request', [$image, $select,$isBuy , $range]);

        $frame_position = 0; // позиция товара с которой начинается создаваться эксель, летит в url

        $user_tariff = UserTariff::getUserTariff(Auth::user()->getAuthIdentifier());
        if(!$user_tariff==null){
            $tariff = Tariff::getTariff($user_tariff->tariff_id);
            $items_limit = $tariff->items_limit;
        }
        else{
            $items_limit = 1000;
        }

//    log::info('check tariff', [$user_tariff, $items_limit]);

        if($range <= $items_limit){  //если юзер выбрал колво товаров меньше чем лимит по тарифу, создаем 1 эесель
//    log::info('create 1 excel');
            $data = $this->create_excel($image, $select, $range, $frame_position);
            $file_name = $data['file_name'];

            if($isBuy == true){
                $this->paymentService->buyExcel();
            }

            UserTariff::incTariffLimit(Auth::user()->getAuthIdentifier());

            $this->fileService->saveFile("$file_name".".xlsx");
        }
        else{
//    log::info('create many excels');
            $items_count = $range; // вводим для подсчета остатка товаров в последней эксель, передаем ее в url -> frame_size
            while($frame_position <= $range){  //
//    log::info(' while($frame_position <= $range)', [$frame_position, $range]);
//    log::info('param', ['$items_count'=>$items_count, '$items_limit' => $items_limit,$items_position]);
                if($items_count >= $items_limit){  //
                    $items_count -= $items_limit; // 41
                }else
                    $items_limit = $items_count; //
//    log::info('URL', [$image, $select, $items_limit, $items_position, $items_limit]);
                $data = $this->create_excel($image, $select, $items_limit, $frame_position);
                $frame_position = $data['frame_position'];
//    log::info('countable', ['$frame_position'=>$frame_position, '$items_count'=>$items_count, '$items_limit' => $items_limit, '$range' =>$range ]);
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


    public function create_excel($image, $select, $frame_limit, $items_position){

        switch ($select){
            case 0: //По умолчанию
                $order_by = '';
                break;
            case 1: //Объем продаж по убыванию
                $order_by = 'Volume%3Adesc';
                break;
            case 2: //Цена по убыванию
                $order_by = 'Price%3Adesc';
                break;
            case 3: //Цена по возрастанию
                $order_by = 'Price%3Aasc';
                break;
            case 4: //Рейтинг продавца по убыванию
                $order_by = 'VendorRating%3Adesc';
                break;
            default:
                $order_by = '';
        }

        $file_name = $this->fileService->fileName();
        $file_path = 'files/'.$file_name.'.xlsx';

        $frame_position = $items_position;
        $frame_size = 200;
        $items_limit = $frame_limit;

        $data = $this->searchItemsService->SearchItems_ByImage($image, $frame_position, $frame_size, $order_by);

        $items = $data['items'];
        $total_count = $data['total_count'];

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('items');

        $sheet->setCellValue('A1', "Id item");
        $sheet->setCellValue('B1', "Title");
        $sheet->setCellValue('C1', "Price");
        $sheet->setCellValue('D1', "Pictures");
        $sheet->setCellValue('E1', "VendorName");
        $sheet->setCellValue('F1', "VendorScore");
        $sheet->setCellValue('G1', "ExternalItemUrl");
        $sheet->setCellValue('H1', "Weight");
        $sheet->setCellValue('I1', "ProviderType");
        $sheet->setCellValue('J1', "VendorId");
        $sheet->setCellValue('K1', "Language");
        $sheet->setCellValue('L1', "Description");
        $sheet->setCellValue('M1', "Volume");
        $sheet->setCellValue('N1', "IsDeliverable");
        $sheet->setCellValue('O1', "Level");
        $sheet->setCellValue('P1', "Score");
        $sheet->setCellValue('Q1', "UpdatedTime");
        $sheet->setCellValue('R1', "CreatedTime");
        $sheet->setCellValue('S1', "IsDeliverable");
        $sheet->setCellValue('T1', "Rating");


        $item_count = 0;
        $i =2; // номер строки в таблице
        while($item_count < $frame_limit){  //
            set_time_limit(0);
//            log::alert('frame size', ['$frame_size'=>$frame_size, '$items_limit' => $items_limit, '$frame_limit' => $frame_limit, '$item_count'=>$item_count,'$frame_position' => $frame_position]);
            if($items_limit < 200)  //
                $frame_size = $items_limit;

            $data = $this->searchItemsService->SearchItems_ByImage($image, $frame_position, $frame_size, $order_by);
            $items = $data['items'];

            foreach($items as $item){
                $sheet->setCellValue('A'.$i,  $item['Id'] );
                $sheet->setCellValue('B'.$i,  $item['Title'] );
                $sheet->setCellValue('C'.$i,  $item['Price']['ConvertedPrice'] );
                $sheet->setCellValue('D'.$i, $item['MainPictureUrl']);

                if(isset($item['VendorName'])){
                    $sheet->setCellValue('E'.$i,  $item['VendorName'] );
                }
                else{$sheet->setCellValue('E'.$i,  '-' );}
                if(isset($item['VendorScore'])){
                    $sheet->setCellValue('F'.$i,  $item['VendorScore'] );
                }
                else{$sheet->setCellValue('F'.$i,  '-' );}
                if(isset($item['ExternalItemUrl'])){
                    $sheet->setCellValue('G'.$i,  $item['ExternalItemUrl'] );
                }
                else{$sheet->setCellValue('G'.$i,  '-' );}
                if(isset($item['PhysicalParameters']['Weight'])){
                    $sheet->setCellValue('H'.$i,  $item['PhysicalParameters']['Weight'] );
                }
                else{$sheet->setCellValue('H'.$i,  '-' );}
                // ---------------------------------
                if(isset($item['ProviderType'])){
                    $sheet->setCellValue('I'.$i,  $item['ProviderType'] );
                }
                else{$sheet->setCellValue('I'.$i,  '-' );}
                if(isset($item['VendorId'])){
                    $sheet->setCellValue('J'.$i,  $item['VendorId'] );
                }
                else{$sheet->setCellValue('J'.$i,  '-' );}
                if(isset($item['Language'])){
                    $sheet->setCellValue('K'.$i,  $item['Language'] );
                }
                else{$sheet->setCellValue('K'.$i,  '-' );}
                if(isset($item['Description'])){
                    $sheet->setCellValue('L'.$i,  $item['Description'] );
                }
                else{$sheet->setCellValue('L'.$i,  '-' );}
                if(isset($item['Volume'])){
                    $sheet->setCellValue('M'.$i,  $item['Volume'] );
                }
                else{$sheet->setCellValue('M'.$i,  '-' );}
                if(isset($item['IsDeliverable'])){
                    $sheet->setCellValue('N'.$i,  $item['IsDeliverable'] );
                }
                else{$sheet->setCellValue('N'.$i,  '-' );}
                if(isset($item['Level'])){
                    $sheet->setCellValue('O'.$i,  $item['Level'] );
                }
                else{$sheet->setCellValue('O'.$i,  '-' );}
                if(isset($item['Score'])){
                    $sheet->setCellValue('P'.$i,  $item['Score'] );
                }
                else{$sheet->setCellValue('P'.$i,  '-' );}
                if(isset($item['UpdatedTime'])){
                    $sheet->setCellValue('Q'.$i,  $item['UpdatedTime'] );
                }
                else{$sheet->setCellValue('Q'.$i,  '-' );}
                if(isset($item['CreatedTime'])){
                    $sheet->setCellValue('R'.$i,  $item['CreatedTime'] );
                }
                else{$sheet->setCellValue('R'.$i,  '-' );}
                if(isset($item['Price']['IsDeliverable'])){
                    $sheet->setCellValue('S'.$i,  $item['Price']['IsDeliverable'] );
                }
                else{$sheet->setCellValue('S'.$i,  '-' );}

                if(isset($item['FeaturedValues'])){
                    foreach ($item['FeaturedValues'] as $rating){
                        if($rating['Name'] == 'rating'){
                            $sheet->setCellValue('T'.$i,  $rating['Value'] );
                            break;
                        }
                    }
                }
                else{$sheet->setCellValue('T'.$i,  '-' );}

                // ---------------------------------
                $i++;
            }

            $item_count += 200;
            $frame_position += 200;
            $items_limit -= 200;

            $items = [];

            $writer = new Xlsx($spreadsheet);
            $writer->save("$file_path");
        }
        return ['file_name'=>$file_name, 'file_path'=>$file_path, 'frame_position' => $frame_position];

    }
}
