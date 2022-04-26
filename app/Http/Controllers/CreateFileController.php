<?php

namespace App\Http\Controllers;


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
     */
    private $fileService;
    private $createExcelService;
    private $paymentService;


    public function __construct(FileService $fileService, CreateExcelService $createExcelService, PaymentService $paymentService)
    {

        $this->fileService = $fileService;
        $this->createExcelService = $createExcelService;
        $this->paymentService = $paymentService;
    }


    public function create_table(Request $req,  $id ){

        $title = $req->title;
        $select = $req->select;
        $isBuy = $req->isBuy;

        $data = $this->createExcelService->create_excel($title, $id, $select);

        $this->paymentService->buyExcel();

        $file_name = $data['file_name'];
        $file_path = $data['file_path'];

        if($isBuy == true){
            return response()->download(public_path("$file_path"));
        }

        $this->fileService->saveFile("$file_name".".xlsx");
        return response()->download(public_path("$file_path"));

    }
}
