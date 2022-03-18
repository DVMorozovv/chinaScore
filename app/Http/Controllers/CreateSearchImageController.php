<?php

namespace App\Http\Controllers;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateSearchImageController extends Controller
{
    public static function saveFile($filename){
        $user = Auth::user();
        $user_id = $user->id;
        $size = ShowFileController::filesize_format(filesize("files/"."$filename"));
        $file = new File();
        $file->name = "$filename";
        $file->path = "files/"."$filename";
        $file->user_id = "$user_id";
        $file->size = "$size";
        $file->save();
    }

    public function imageItem($image, $frame_position, $frame_size){

        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.CategoryController::KEY.'&language=&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A++%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A++%3CImageUrl%3E'.$image.'%3C%2FImageUrl%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = CategoryController::curl_json($url);
        $items = [];
        $count = 0;
        for($i = 0; $i<count($data['Result']['Items']['Items']['Content']); $i++){
            $items[] = $data['Result']['Items']['Items']['Content'][$count];
            $count++;
        }
        $total_count = $data['Result']['Items']['Items']['TotalCount'];
        return ['items'=>$items, 'total_count'=>$total_count];
    }

    public static function imageItemOrder($image, $frame_position, $frame_size, $order_by){
        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.CategoryController::KEY.'&language=&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A++%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A++%3CImageUrl%3E'.$image.'%3C%2FImageUrl%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = CategoryController::curl_json($url);
        $items = [];
        $count = 0;
        for($i = 0; $i<count($data['Result']['Items']['Items']['Content']); $i++){
            $items[] = $data['Result']['Items']['Items']['Content'][$count];
            $count++;
        }
        $total_count = $data['Result']['Items']['Items']['TotalCount'];
        return ['items'=>$items, 'total_count'=>$total_count];
    }


    public function create_excel(Request $req){


//        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.CategoryController::KEY.'&language=&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A++%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A++%3CImageUrl%3E'.$image.'%3C%2FImageUrl%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';


        $image = $_GET['image'];
        $select = $_GET["filter"];
        $image = $req->input('image');

        $frame_limit = 10;

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

        $user = Auth::user();
        $current = Carbon::now();
        $file_name = $user->name.'_items-'.$current->toDateString().' '.$current->hour.'-'.$current->minute;
        $file_path = 'files/'.$file_name.'.xlsx';

        $frame_position = 0;
        $frame_size = 200;

        $data = self::imageItemOrder($image, $frame_position, $frame_size, $order_by);


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
        while($item_count < $frame_limit){  //$item_count < $total_count
            set_time_limit(0);
            $data = self::imageItemOrder($image, $frame_position, $frame_size, $order_by);
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

            $item_count = $item_count + 200;
            $frame_position = $frame_position + 200;
            $items = [];

            $writer = new Xlsx($spreadsheet);
            $writer->save("$file_path");
        }
        self::saveFile("$file_name".".xlsx");
        return response()->download(public_path("$file_path"));
    }
}
