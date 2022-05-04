<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    public function files(){
        return $this->hasMany(File::class);
    }

    public function getFolder($folder_id){
        return Folder::find($folder_id);
    }

    public static function createFolder($user_id, $method){
        $folder = new Folder();
        $folder->method = $method;
        $folder->user_id = $user_id;
        $folder->save();

        return $folder;
    }




}
