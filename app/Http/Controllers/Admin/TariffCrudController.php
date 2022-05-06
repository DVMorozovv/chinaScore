<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TariffCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $tariffs = Tariff::all();

        return view('admin.tarif.index', ['tariffs' => $tariffs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.tarif.create');
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

            $new_tarif = new Tariff();

            $new_tarif->name = $request->name;
            $new_tarif->description = $request->description;
            $new_tarif->description_2 = $request->description_2;
            $new_tarif->description_3 = $request->description_3;
            $new_tarif->description_4 = $request->description_4;
            $new_tarif->description_5 = $request->description_5;
            $new_tarif->description_6 = $request->description_6;
            $new_tarif->price = $request->price;
            $new_tarif->limit = $request->limit;
            $new_tarif->items_limit = $request->items_limit;
            $new_tarif->duration = $request->duration;

            $new_tarif->save();

            return Redirect::back()->withSuccess('Тариф был успешно добавлен');

        } catch (QueryException $e){

            return Redirect::back()->withErrors('Что-то пошло не так, попробуйте еще раз');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tariff  $tariff
     */
    public function edit(Tariff $tariff)
    {
        return view('admin.tarif.edit', ['tariff'=>$tariff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tariff $tariff)
    {
        try {

            $tariff->name = $request->name;
            $tariff->description = $request->description;
            $tariff->description_2 = $request->description_2;
            $tariff->description_3 = $request->description_3;
            $tariff->description_4 = $request->description_4;
            $tariff->description_5 = $request->description_5;
            $tariff->description_6 = $request->description_6;
            $tariff->price = $request->price;
            $tariff->limit = $request->limit;
            $tariff->items_limit = $request->items_limit;
            $tariff->is_active = $request->is_active;
            $tariff->duration = $request->duration;

            $tariff->save();

            return Redirect::back()->withSuccess('Тариф был успешно изменен');

        } catch (QueryException $e){

            return Redirect::back()->withErrors('Что-то пошло не так, попробуйте еще раз');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tariff $tariff)
    {
        try {

            $tariff->delete();

            return redirect()->back()->withSuccess("Тариф был успешно удален");

        } catch (QueryException $e){

            return redirect()->back()->withErrors("Не удалось удалить тариф");
        }
    }
}
