<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTariff;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SubscriptionCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $userTariffs = UserTariff::all();
        return view('admin.subscription.index', ['userTariffs' => $userTariffs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserTariff  $userTariff
     * @return \Illuminate\Http\Response
     */
    public function show(UserTariff $userTariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserTariff  $userTariff
     */
    public function edit(UserTariff $userTariff)
    {
        return view('admin.subscription.edit', ['userTariff'=>$userTariff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserTariff  $userTariff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserTariff $userTariff)
    {
        try {
            $validate = $request->validate([
                'status'=>'required|max:100',
                'days_end_sub' => 'required|max:400'
            ]);
            $userTariff->status = $validate['status'];
            $userTariff->days_end_sub = $validate['days_end_sub'];

            $userTariff->save();

            return Redirect::back()->withSuccess('Подписка была успешно изменена');

        } catch (QueryException $e){

            return Redirect::back()->withErrors('Что-то пошло не так, попробуйте еще раз');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserTariff  $userTariff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserTariff $userTariff)
    {
        try {

            $userTariff->delete();

            return redirect()->back()->withSuccess("Подписка была успешно удалена");

        } catch (QueryException $e){

            return redirect()->back()->withErrors("Не удалось удалить подписку");
        }
    }
}
