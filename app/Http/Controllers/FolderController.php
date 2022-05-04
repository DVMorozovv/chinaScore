<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $folders = Folder::select()->where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

        for ($i = 0; $i < count($folders); $i++){
            $files = $folders[$i]->files;
            $folders[$i]['count'] = count($files);

        }

        return view('pages/file-folder', ['folders'=>$folders]);
    }


}
