<?php

namespace App\Http\Controllers;

use App\Models\UserTariff;
use App\Services\SearchItemsService;
use App\Services\TariffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchItemsController extends Controller
{
    /**
     * @var SearchItemsService
     * @var TariffService
     */
    private $searchItemsService;
    private $tariffService;

    public function __construct(SearchItemsService $searchItemsService, TariffService $tariffService)
    {
        $this->searchItemsService = $searchItemsService;
        $this->tariffService = $tariffService;
    }

    public function itemsByCategory(Request $req, $id){

        $result = $this->tariffService->checkTariffLimit(Auth::user()->getAuthIdentifier());
        $defaultTariff = UserTariff::getDefaultTariff();
        $userLimit = $this->tariffService->getUserTariffLimit(Auth::user()->getAuthIdentifier());
        $cat_name = $req->get('cat_name');
        $data = $this->searchItemsService->SearchItems_ByCategory($id);
        $data["cat_name"] = $cat_name;
        $data["result"] = $result;
        $data["default"] = $defaultTariff;
        $data['userLimit'] = $userLimit;

//        dd($data);
        return view('/pages/items', $data);
    }

    public function itemsByName(Request $req, $id){

        $validate = $req->validate([
            'title' => 'required|min:1|max:255',
        ]);
        $title = $validate['title'];
        $cat_name = $req->get('cat_name');

        $result = $this->tariffService->checkTariffLimit(Auth::user()->getAuthIdentifier());
        $defaultTariff = UserTariff::getDefaultTariff();
        $userLimit = $this->tariffService->getUserTariffLimit(Auth::user()->getAuthIdentifier());

        $data = $this->searchItemsService->SearchItems_ByName($title, $id);

        $data["cat_name"] = $cat_name;
        $data["result"] = $result;
        $data["default"] = $defaultTariff;
        $data['userLimit'] = $userLimit;

//        dd($data);
        return view('/pages/items', $data);
    }

    public function itemsByImage(Request $req){

        $validate = $req->validate([
            'image' => 'required|min:1',
        ]);
        $image = $validate['image'];

        $order_by = '';
        $frame_position = 0;
        $frame_size = 10;

        $result = $this->tariffService->checkTariffLimit(Auth::user()->getAuthIdentifier());
        $defaultTariff = UserTariff::getDefaultTariff();

        $userLimit = $this->tariffService->getUserTariffLimit(Auth::user()->getAuthIdentifier());

        $data = $this->searchItemsService->SearchItems_ByImage($image, $frame_position, $frame_size, $order_by);
        $data["image"] = $image;
        $data["result"] = $result;
        $data["default"] = $defaultTariff;
        $data['userLimit'] = $userLimit;

        if($data['ErrorCode'] == true){
            return view('/pages/itemsPhoto', $data);
        }
        else{
            return redirect()->back()->withErrors('Поиск по фото временно недоступен, обратитесь к администрации сайта.');
        }


    }
}
