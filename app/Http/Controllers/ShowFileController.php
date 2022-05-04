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
//    public function files(Request $req){
//
//        $user_id = Auth::user()->getAuthIdentifier();
//
//        $files = File::select()->where('user_id', '=', "$user_id")->where('created_at','<',Carbon::now()->subDays(5))->orderBy('created_at', 'desc')->get();
//        $recently_files =  File::select()->where('user_id', '=', "$user_id")->where('created_at','>',Carbon::now()->subDays(5))->orderBy('created_at', 'desc')->get();
//        return view('pages/user-files',  ['files'=>$files, 'recently_files'=>$recently_files]);
//    }

    public function files(Request $req){

        $folder_id = $req->folder_id;

        $files = File::select()->where('folder_id', '=', $folder_id)->get();

        return view('pages/files',  ['files'=>$files]);
    }

    public function download_file(Request $req){
        $file_id = $req->get('file_id');
        $file = File::find($file_id);
        $file_path = $file->path;
        return response()->download(public_path("$file_path"));
    }
}
