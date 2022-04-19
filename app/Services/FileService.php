<?php
namespace App\Services;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FileService
{
    public function filesize_format($filesize)
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

    public function saveFile($filename){
        $user = Auth::user();
        $user_id = $user->id;
        $size = $this->filesize_format(filesize("files/"."$filename"));
        $file = new File();
        $file->name = "$filename";
        $file->path = "files/"."$filename";
        $file->user_id = "$user_id";
        $file->size = "$size";
        $file->save();
    }

    public function fileName(): string
    {
        $user = Auth::user();
        $current = Carbon::now();
        $file_name = $user->name.'_items-'.$current->toDateString().' '.$current->hour.'-'.$current->minute;

        return $file_name;
    }




}
