<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateExcelService
{

    /**
     * @var FileService
     * @var SearchItemsService
     */
    private $searchItemsService;
    private $fileService;


    public function __construct(FileService $fileService, SearchItemsService $searchItemsService)
    {
        $this->fileService = $fileService;
        $this->searchItemsService = $searchItemsService;
    }


    public function create_excel($title, $id, $select, $frame_limit, $items_position){

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

        if ($title == ''){
            $data = $this->searchItemsService->CategoryItems($id, $frame_position, $frame_size, $order_by);
        }
        else{
            $data = $this->searchItemsService->SearchByName($id, $frame_position, $frame_size, $title, $order_by);
        }

        $items = $data['items'];
        $total_count = $data['total_count'];

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('items');
//        $sheet_img = $spreadsheet->createSheet();
//        $sheet_img->setTitle('images');

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

//        $writer = new Xlsx($spreadsheet);
//        $writer->save("$file_path");

        $item_count = 0;
        $i =2; // номер строки в таблице
        while($item_count < $frame_limit){
            set_time_limit(0);

            if($items_limit < 200)  //
                $frame_size = $items_limit;

            if ($title == ''){
                $data = $this->searchItemsService->CategoryItems($id, $frame_position, $frame_size, $order_by);
            }
            else{
                $data = $this->searchItemsService->SearchByName($id, $frame_position, $frame_size, $title, $order_by);
            }
            $items = $data['items'];

//            // чтение файла
//            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
//            $reader->setLoadSheetsOnly($sheet, $sheet_img);

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
//                $sheet_img->setCellValue('B'.$i, $item['MainPictureUrl']);
//                $sheet_img->setCellValue('A'.$i, $item['Id']);
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
