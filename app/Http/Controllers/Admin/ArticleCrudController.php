<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use function view;

class ArticleCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $articles = Article::all();

        return view('admin.article.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            $validate = $request->validate([
                'heading'=>'required|max:100',
                'description' => 'required|max:400'
            ]);

            $new_article = new Article();

            $new_article->heading = $validate['heading'];
            $new_article->description = $validate['description'];
            $new_article->content = $request->text;
            $new_article->link = $request->link;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                Storage::putFile('public/images/articles', $file);
                $file_name = $file->hashName();
                $new_article->image = $file_name;
            }

            $new_article->save();

            return Redirect::back()->withSuccess('Статья был успешно добавлена');

        } catch (QueryException $e){

            return Redirect::back()->withErrors('Что-то пошло не так, попробуйте еще раз');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', ['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        try {

            $validate = $request->validate([
                'heading'=>'required|max:100',
                'description' => 'required|max:400'
            ]);
            $article->heading = $validate['heading'];
            $article->description = $validate['description'];
            $article->content = $request->text;
            $article->link = $request->link;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                Storage::putFile('public/images/articles', $file);

                $file_name = $file->hashName();
                $article->image = $file_name;
            }

            $article->save();

            return Redirect::back()->withSuccess('Тариф был успешно изменен');

        } catch (QueryException $e){

            return Redirect::back()->withErrors('Что-то пошло не так, попробуйте еще раз');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        try {

            $article->delete();

            return redirect()->back()->withSuccess("Тариф был успешно удален");

        } catch (QueryException $e){

            return redirect()->back()->withErrors("Не удалось удалить тариф");
        }
    }
}
