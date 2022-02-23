<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    static $key = 'b51a8024-ebac-49cb-885e-07670065e482';

    public static function curl_json($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $responce = curl_exec($ch);
        $data = json_decode($responce, true);
        curl_close($ch);
        return $data;
    }

    public static function get_cat($url){
        $data = self::curl_json($url);
        $cat_1688 = array();
        $count =0;
        for ($i = 0; $i<count($data['CategoryInfoList']['Content']); $i++){
            array_push($cat_1688, $data['CategoryInfoList']['Content']["$count"] );
            $count++;
        }
        return $cat_1688;
    }


    public function categories(){
        $url = 'http://otapi.net/service-json/GetRootCategoryInfoList?instanceKey='.self::$key.'&language=ru&signature=ru&timestamp=';
        $parent_cat = static::get_cat($url);
        //$parent_id = $parent_cat[0]['Id'];
        $id = 'all';

        // если первой вводится одна общая категория, получаем этим запросом ее дочерние
        // $url_Subcategory = 'http://otapi.net/service-json/GetCategorySubcategoryInfoList?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&parentCategoryId='.$parent_id.'';
        // $cat_child = static::get_cat($url_Subcategory);
        $categories = [];
        for($i = 0; $i<count($parent_cat); $i++){
            if(($parent_cat[$i]['IsParent'] == true) and ($parent_cat[$i]['IsHidden'] == false) ){
                array_push($categories, $parent_cat[$i] );
            }
        }

        return view('/pages/cat', ['categories'=>$categories, 'id'=>$id]);
    }


    public function categories_child($id){
        $url_Subcategory = 'http://otapi.net/service-json/GetCategorySubcategoryInfoList?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&parentCategoryId='.$id.'';
        $categories = array();
        $cat_child = array();
        $cat_child = static::get_cat($url_Subcategory);
        for($i = 0; $i<count($cat_child); $i++){
            if(($cat_child[$i]['IsParent'] == true) and ($cat_child[$i]['IsHidden'] == false) ){
                array_push($categories, $cat_child[$i]);
            }
        }
        return view('/pages/cat', ['categories'=>$categories]);
    }

    public static function CategoryItems($id, $frame_position, $frame_size, $order_by){
        // $order_by = 'VendorRating%3Adesc'; // Рейтинг продавца по убыванию
        // $order_by = ''; // Сортировка по умолчанию
        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A%3CCategoryId%3E'.$id.'%3C%2FCategoryId%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = self::curl_json($url);

        $items = [];
        $count = 0;
        for($i = 0; $i<count($data['Result']['Items']['Items']['Content']); $i++){
            array_push($items, $data['Result']['Items']['Items']['Content'][$count]);
            $count++;
        }
        $total_count = $data['Result']['Items']['Items']['TotalCount'];
        return ['items'=>$items, 'total_count'=>$total_count];
    }

    public function SearchItems_ByCategory(Request $req, $id){
        $frame_position = 0;
        $frame_size = 10;
        $cat_name = $req->get('cat_name');
        $data = self::CategoryItems($id, $frame_position, $frame_size, '');
        $items = array();
        $items = $data['items'];
        $total_count = $data['total_count'];
        return view('/pages/items', ['items'=>$items, 'total_count'=>$total_count, 'id'=>$id, 'cat_name'=>$cat_name ]);
    }

    public static function SearchByName($id, $frame_position, $frame_size, $title, $order_by){

        $split_title = str_replace(" ", "%20", $title);

        // статическое значение id родительской категории: otc-8421
        if ($id == 'all'){
            $url ='http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%3CItemTitle%3E'.$split_title.'%3C%2FItemTitle%3E%3CLanguageOfQuery%3Eru%3C%2FLanguageOfQuery%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
            //print_r($url);

            $data_all_cat = self::curl_json($url);
            $items = [];
            $count = 0;
            for($i = 0; $i<count($data_all_cat['Result']['Items']['Items']['Content']); $i++){
                array_push($items, $data_all_cat['Result']['Items']['Items']['Content'][$count]);
                $count++;
            }
            $total_count = $data_all_cat['Result']['Items']['Items']['TotalCount'];
        }
        else{
            $url ='http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A%3CItemTitle%3E'.$split_title.'%3C%2FItemTitle%3E%0D%0A%3CCategoryId%3E'.$id.'%3C%2FCategoryId%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
            $data_cat = self::curl_json($url);
            $items = [];
            $count = 0;
            for($i = 0; $i<count($data_cat['Result']['Items']['Items']['Content']); $i++){
                array_push($items, $data_cat['Result']['Items']['Items']['Content'][$count]);
                $count++;
            }
            $total_count = $data_cat['Result']['Items']['Items']['TotalCount'];
        }
        return ['items'=>$items, 'total_count'=>$total_count];
    }


    public function SearchItems_ByName(Request $request, $id){
        $frame_position = 0;
        $frame_size = 10;

        $validate = $request->validate([
            'title' => 'required|min:1',
        ]);
        $title = $validate['title'];

        $cat_name = $request->input('cat_name');
        $it = self::SearchByName($id, $frame_position, $frame_size, $title, '');
        $items = $it['items'];
        $total_count = $it['total_count'];

        return view('/pages/items', ['items'=>$items, 'total_count'=>$total_count, 'id'=>$id, 'title'=>$title, 'cat_name'=>$cat_name ]);
    }
}
