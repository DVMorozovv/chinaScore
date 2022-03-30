<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ShowFileController extends Controller
{
    static function filesize_format($filesize)
    {
        $formats = array('b','kb','mb','gb','tb');// варианты размера файла
        $format = 0;// формат размера по-умолчанию

        // прогоняем цикл
        while ($filesize > 1024 && count($formats) != ++$format)
        {
            $filesize = round($filesize / 1024, 2);
        }
        // если число большое, мы выходим из цикла с
        // форматом превышающим максимальное значение
        // поэтому нужно добавить последний возможный
        // размер файла в массив еще раз
        $formats[] = 'tb';

        return $filesize.$formats[$format];
    }

    public function files(Request $req){

        $user_id = Auth::user()->getAuthIdentifier();

        $files = File::select()->where('user_id', '=', "$user_id")->where('created_at','<',Carbon::now()->subDays(5))->orderBy('created_at', 'desc')->get();
        $recently_files =  File::select()->where('created_at','>',Carbon::now()->subDays(5))->orderBy('created_at', 'desc')->get();
        return view('pages/user-files',  ['files'=>$files, 'recently_files'=>$recently_files]);
    }

    public function download_file(Request $req){
        $file_id = $req->get('file_id');
        $file = File::find($file_id);
        $file_path = $file->path;
        return response()->download(public_path("$file_path"));
    }
}
