<?php

namespace App\Http\Controllers;

use App\Services\SearchItemsService;
use Illuminate\Http\Request;

class SearchItemsController extends Controller
{
    /**
     * @var SearchItemsService
     */
    private $searchItemsService;

    public function __construct(SearchItemsService $searchItemsService)
    {
        $this->searchItemsService = $searchItemsService;
    }

    public function itemsByCategory(Request $req, $id){

        $cat_name = $req->get('cat_name');
        $data = $this->searchItemsService->SearchItems_ByCategory($id);
        $data["cat_name"] = $cat_name;

        return view('/pages/items', $data);
    }

    public function itemsByName(Request $req, $id){

        $validate = $req->validate([
            'title' => 'required|min:1|max:255',
        ]);
        $title = $validate['title'];
        $cat_name = $req->get('cat_name');

        $data = $this->searchItemsService->SearchItems_ByName($title, $id);

        $data["cat_name"] = $cat_name;

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

        $data = $this->searchItemsService->SearchItems_ByImage($image, $frame_position, $frame_size, $order_by);
        $data["image"] = $image;
//        dd($data);
        return view('/pages/itemsPhoto', $data);
    }
}
