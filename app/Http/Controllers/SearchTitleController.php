<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SearchTitleController extends Controller
{
    public function SearchTitle(){

        $id = 'all';
        return view('/pages/search-title', [ 'id'=>$id]);
    }
}
