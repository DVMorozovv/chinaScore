<?php

namespace App\Http\Controllers;

use App\Enums\FolderMethodEnum;
use App\Models\Balance;
use App\Models\File;
use App\Models\Folder;
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
                    return redirect()->route('file-folder');
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
                    return redirect()->route('file-folder');
                }
            }

//            dd($userTariff, $userLimit, $tariff, $count_excel, $userBalance, $defaultTariff);
        }
        else{
            $count_excel = ceil($range / $defaultTariff->items_limit);
            $price = $count_excel*$defaultTariff->price;
            if($userBalance >= $price){

                $this->create_table($image, $select, $isBuy, $range);
                return redirect()->route('file-folder');
            }
            else{
                return redirect()->route('payment');
            }

        }

    }

    public function create_table( $image, $select, $isBuy, $range){
        $method = FolderMethodEnum::IMAGE;
        $folder = Folder::createFolder(Auth::user()->getAuthIdentifier(), $method);
//    log::info('request', [$image, $select,$isBuy , $range]);

        $frame_position = 0; // ?????????????? ???????????? ?? ?????????????? ???????????????????? ?????????????????????? ????????????, ?????????? ?? url

        $user_tariff = UserTariff::getUserTariff(Auth::user()->getAuthIdentifier());
        if(!$user_tariff==null){
            $tariff = Tariff::getTariff($user_tariff->tariff_id);
            $items_limit = $tariff->items_limit;
        }
        else{
            $default = UserTariff::getDefaultTariff();
            $items_limit = $default->items_limit;
        }

//    log::info('check tariff', [$user_tariff, $items_limit]);

        if($range <= $items_limit){  //???????? ???????? ???????????? ?????????? ?????????????? ???????????? ?????? ?????????? ???? ????????????, ?????????????? 1 ????????????

            $data = $this->create_excel($image, $select, $range, $frame_position);
            $file_name = $data['file_name'];

            if($isBuy == true){
                $this->paymentService->buyExcel();
            }

            UserTariff::incTariffLimit(Auth::user()->getAuthIdentifier());

            $this->fileService->saveFile("$file_name".".xlsx", $folder);
        }
        else{

            $items_count = $range; // ???????????? ?????? ???????????????? ?????????????? ?????????????? ?? ?????????????????? ????????????, ???????????????? ???? ?? url -> frame_size
            while($frame_position < $range){  //

                if($items_count >= $items_limit){  //
                    $items_count -= $items_limit; // 41
                }else
                    $items_limit = $items_count; //

                $data = $this->create_excel($image, $select, $items_limit, $frame_position);
                $frame_position = $data['frame_position'];

                $file_name = $data['file_name'];

                if($isBuy == true){
                    $this->paymentService->buyExcel();
                }

                UserTariff::incTariffLimit(Auth::user()->getAuthIdentifier());

                $this->fileService->saveFile("$file_name".".xlsx", $folder);

            }
        }

//        return redirect()->route('user-files');
    }


    public function create_excel($image, $select, $frame_limit, $items_position){

        switch ($select){
            case 0: //???? ??????????????????
                $order_by = '';
                break;
            case 1: //?????????? ???????????? ???? ????????????????
                $order_by = 'Volume%3Adesc';
                break;
            case 2: //???????? ???? ????????????????
                $order_by = 'Price%3Adesc';
                break;
            case 3: //???????? ???? ??????????????????????
                $order_by = 'Price%3Aasc';
                break;
            case 4: //?????????????? ???????????????? ???? ????????????????
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
        $sheet->setCellValue('D1', "Price RUB");
        $sheet->setCellValue('E1', "Pictures");
        $sheet->setCellValue('F1', "VendorName");
        $sheet->setCellValue('G1', "VendorScore");
        $sheet->setCellValue('H1', "ExternalItemUrl");
        $sheet->setCellValue('I1', "Weight");
        $sheet->setCellValue('J1', "ProviderType");
        $sheet->setCellValue('K1', "VendorId");
        $sheet->setCellValue('L1', "Rating");
        $sheet->setCellValue('M1', "normalizedRating");
        $sheet->setCellValue('N1', "TotalSales");


        $item_count = 0;
        $i =2; // ?????????? ???????????? ?? ??????????????
        while($item_count < $frame_limit){  //
            set_time_limit(0);
            log::alert('frame size', ['$frame_size'=>$frame_size, '$items_limit' => $items_limit, '$frame_limit' => $frame_limit, '$item_count'=>$item_count,'$frame_position' => $frame_position]);
            if($items_limit < 200)  //
                $frame_size = $items_limit;
            log::alert('frame size', ['$frame_size'=>$frame_size, '$items_limit' => $items_limit, '$frame_limit' => $frame_limit, '$item_count'=>$item_count,'$frame_position' => $frame_position]);
            $data = $this->searchItemsService->SearchItems_ByImage($image, $frame_position, $frame_size, $order_by);
            $items = $data['items'];

            foreach($items as $item){
                $sheet->setCellValue('A'.$i,  $item['Id'] );
                $sheet->setCellValue('B'.$i,  $item['Title'] );
                $sheet->setCellValue('C'.$i,  $item['Price']['ConvertedPrice'] );
                if(isset($item['Price'])){
                    $sheet->setCellValue('D'.$i,  $item['Price']['ConvertedPriceList']['Internal']['Price'].' '.$item['Price']['ConvertedPriceList']['Internal']['Sign'] );
                }
                else{$sheet->setCellValue('D'.$i,  '-' );}

                $sheet->setCellValue('E'.$i, $item['MainPictureUrl']);
//                $sheet->getCell('D'.$i)->getHyperlink()->setUrl("sheet://'images'!A$i");
                if(isset($item['VendorName'])){
                    $sheet->setCellValue('F'.$i,  $item['VendorName'] );
                }
                else{$sheet->setCellValue('F'.$i,  '-' );}
                if(isset($item['VendorScore'])){
                    $sheet->setCellValue('G'.$i,  $item['VendorScore'] );
                }
                else{$sheet->setCellValue('G'.$i,  '-' );}
                if(isset($item['ExternalItemUrl'])){
                    $sheet->setCellValue('H'.$i,  $item['ExternalItemUrl'] );
                }
                else{$sheet->setCellValue('H'.$i,  '-' );}
                if(isset($item['PhysicalParameters']['Weight'])){
                    $sheet->setCellValue('I'.$i,  $item['PhysicalParameters']['Weight'] );
                }
                else{$sheet->setCellValue('I'.$i,  '-' );}
                if(isset($item['ProviderType'])){
                    $sheet->setCellValue('J'.$i,  $item['ProviderType'] );
                }
                else{$sheet->setCellValue('J'.$i,  '-' );}
                if(isset($item['VendorId'])){
                    $sheet->setCellValue('K'.$i,  $item['VendorId'] );
                }
                else{$sheet->setCellValue('K'.$i,  '-' );}

                if(isset($item['FeaturedValues'])){
                    foreach ($item['FeaturedValues'] as $rating){
                        if($rating['Name'] == 'rating'){
                            $sheet->setCellValue('L'.$i,  $rating['Value'] );
                        }
                        if($rating['Name'] == 'normalizedRating'){
                            $sheet->setCellValue('M'.$i,  $rating['Value'] );
                        }
                        if($rating['Name'] == 'TotalSales'){
                            $sheet->setCellValue('N'.$i,  $rating['Value'] );
                        }
                    }
                }
                // ---------------------------------
                $i++;
            }

            $item_count += 200;
            $frame_position += $frame_size;
            $items_limit -= 200;

            $items = [];

            $writer = new Xlsx($spreadsheet);
            $writer->save("$file_path");
        }
        return ['file_name'=>$file_name, 'file_path'=>$file_path, 'frame_position' => $frame_position];

    }
}
