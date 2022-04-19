<?php
namespace App\Services;

class Categories
{

    /**
     * @var DecodeJson
     */
    private $decodeJson;

    public function __construct(DecodeJson $decodeJson)
    {
        $this->decodeJson = $decodeJson;
    }

    public function get_cat($url){
        $data = $this->decodeJson->curl_json($url);
        $categories = array();
        $count =0;
        for ($i = 0; $i<count($data['CategoryInfoList']['Content']); $i++){
            $categories[] = $data['CategoryInfoList']['Content']["$count"];
            $count++;
        }
        return $categories;
    }

    //получение корневых категорий GetRoot CategoryIfoList
    public function categories(){
        $url = 'http://otapi.net/service-json/GetRootCategoryInfoList?instanceKey='.env('OTAPI_KEY').'&language=ru&signature=ru&timestamp=';
        $parent_cat = $this->get_cat($url);
        $id = 'all';

        // если первой вводится одна общая категория, получаем этим запросом ее дочерние
        // $url_Subcategory = 'http://otapi.net/service-json/GetCategorySubcategoryInfoList?instanceKey='.self::$key.'&language=ru&signature=&timestamp=&parentCategoryId='.$parent_id.'';
        // $cat_child = static::get_cat($url_Subcategory);
        $categories = [];
        for($i = 0; $i<count($parent_cat); $i++){
            if(($parent_cat[$i]['IsParent'] == true) and ($parent_cat[$i]['IsHidden'] == false) ){
                $categories[] = $parent_cat[$i];
            }
        }

        return ['categories'=>$categories, 'id'=>$id];
    }


    public function categories_child($id){
        $url_Subcategory = 'http://otapi.net/service-json/GetCategorySubcategoryInfoList?instanceKey='.env('OTAPI_KEY').'&language=ru&signature=&timestamp=&parentCategoryId='.$id.'';
        $categories = [];
        $cat_child = $this->get_cat($url_Subcategory);
        for($i = 0; $i<count($cat_child); $i++){
            if(($cat_child[$i]['IsParent'] == true) and ($cat_child[$i]['IsHidden'] == false) ){
                $categories[] = $cat_child[$i];
            }
        }
        return $categories;
    }
}
