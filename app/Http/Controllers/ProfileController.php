<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
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
//        $user = Auth::user();
//        $user_id = $user->id;
//        $files = new File();
//        $files = DB::table('files')->where('user_id', '=', "$user_id")->get();
//
//
//        return view('pages/user-files',  ['files'=>$files]);

        $filename = 'files/items.xlsx';
        $s = self::filesize_format(filesize($filename));
        $file = new File();
        $file->name = "items.xlsx";
        $file->path = "$filename";
        $file->user_id = '1';
        $file->size = "$s";
        $file->save();
        echo $s;
        $filename = 'files/items.xlsx';
        $s = self::filesize_format(filesize($filename));
        $file = new File();
        $file->name = "items.xlsx";
        $file->path = "$filename";
        $file->user_id = '1';
        $file->size = "$s";
        $file->save();
        echo $s;
        $filename = 'files/items.xlsx';
        $s = self::filesize_format(filesize($filename));
        $file = new File();
        $file->name = "items.xlsx";
        $file->path = "$filename";
        $file->user_id = '1';
        $file->size = "$s";
        $file->save();
        echo $s;
        $filename = 'files/items.xlsx';
        $s = self::filesize_format(filesize($filename));
        $file = new File();
        $file->name = "items.xlsx";
        $file->path = "$filename";
        $file->user_id = '1';
        $file->size = "$s";
        $file->save();
        echo $s;

    }
}
