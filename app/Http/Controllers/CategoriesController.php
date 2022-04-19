<?php

namespace App\Http\Controllers;

use App\Services\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * @var Categories
     */
    private $categories;

    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }


    public function mainCategories(){

        $data = $this->categories->categories();

        $categories = $data['categories'];
        $id = $data['id'];

        return view('/pages/cat', ['categories'=>$categories, 'id'=>$id]);
    }

    public function childCategories($id){

        $categories = $this->categories->categories_child($id);
        return view('/pages/cat', ['categories'=>$categories]);
    }
}
