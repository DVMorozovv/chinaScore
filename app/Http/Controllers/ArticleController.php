<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public  function index(){

        $articles = Article::all();
        return view('pages/learning', ['articles' => $articles]);
    }

    public function article($id){

        $article = Article::find($id);
        return view('pages/single-learning', ['article' => $article]);
    }
}
