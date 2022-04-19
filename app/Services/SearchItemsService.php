<?php
namespace App\Services;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchItemsService
{
    /**
     * @var DecodeJson
     */
    private $decodeJson;

    public function __construct(DecodeJson $decodeJson)
    {

        $this->decodeJson = $decodeJson;
    }

    public function CategoryItems($id, $frame_position, $frame_size, $order_by){
        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.env('OTAPI_KEY').'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A%3CCategoryId%3E'.$id.'%3C%2FCategoryId%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = $this->decodeJson->curl_json($url);
        $items = [];
        $count = 0;
        for($i = 0; $i<count($data['Result']['Items']['Items']['Content']); $i++){
            $items[] = $data['Result']['Items']['Items']['Content'][$count];
            $count++;
        }
        $total_count = $data['Result']['Items']['Items']['TotalCount'];
        return ['items'=>$items, 'total_count'=>$total_count];
    }

    public function SearchItems_ByCategory($id){
        $frame_position = 0;
        $frame_size = 10;
        $data = $this->CategoryItems($id, $frame_position, $frame_size, '');
        $data["id"] = $id;

        return $data;
    }

    public function SearchByName($id, $frame_position, $frame_size, $title, $order_by){

        $split_title = str_replace(" ", "%20", $title);

        // статическое значение id родительской категории: otc-8421
        if ($id == 'all'){
            $url ='http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.env('OTAPI_KEY').'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%3CItemTitle%3E'.$split_title.'%3C%2FItemTitle%3E%3CLanguageOfQuery%3Eru%3C%2FLanguageOfQuery%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
            $data_all_cat = $this->decodeJson->curl_json($url);
            $items = [];
            $count = 0;
            for($i = 0; $i<count($data_all_cat['Result']['Items']['Items']['Content']); $i++){
                $items[] = $data_all_cat['Result']['Items']['Items']['Content'][$count];
                $count++;
            }
            $total_count = $data_all_cat['Result']['Items']['Items']['TotalCount'];
        }
        else{
            $url ='http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.env('OTAPI_KEY').'&language=ru&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A%3CItemTitle%3E'.$split_title.'%3C%2FItemTitle%3E%0D%0A%3CCategoryId%3E'.$id.'%3C%2FCategoryId%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
            $data_cat = $this->decodeJson->curl_json($url);
            $items = [];
            $count = 0;
            for($i = 0; $i<count($data_cat['Result']['Items']['Items']['Content']); $i++){
                $items[] = $data_cat['Result']['Items']['Items']['Content'][$count];
                $count++;
            }
            $total_count = $data_cat['Result']['Items']['Items']['TotalCount'];
        }
        return ['items'=>$items, 'total_count'=>$total_count];
    }


    public function SearchItems_ByName($title, $id){
        $frame_position = 0;
        $frame_size = 10;
        $data = $this->SearchByName($id, $frame_position, $frame_size, $title, '');
        $data["id"] = $id;
        $data["title"] = $title;

        return $data;
    }


    public function SearchItems_ByImage($image, $frame_position, $frame_size, $order_by){

        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.env('OTAPI_KEY').'&language=&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A++%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A++%3CImageUrl%3E'.$image.'%3C%2FImageUrl%3E%0D%0A%3COrderBy%3E'.$order_by.'%3C%2FOrderBy%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = $this->decodeJson->curl_json($url);
        $items = [];
        $count = 0;
        if($data['ErrorCode'] == 'Ok') {
            for ($i = 0; $i < count($data['Result']['Items']['Items']['Content']); $i++) {
                $items[] = $data['Result']['Items']['Items']['Content'][$count];
                $count++;
            }
            $total_count = $data['Result']['Items']['Items']['TotalCount'];

            return ['items'=>$items, 'total_count'=>$total_count];
        }
        else
            echo $data['ErrorDescription'];
    }
}
