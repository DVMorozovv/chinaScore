<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageSearchController extends Controller
{
    public function imageSearch(Request $req){

        $validate = $req->validate([
            'image' => 'required|min:1',
        ]);
        $image = $validate['image'];
//        $image = 'https://www.google.ru/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png';
        $frame_position = 0;
        $frame_size = 10;
        $url = 'http://otapi.net/service-json/BatchSearchItemsFrame?instanceKey='.CategoryController::KEY.'&language=&signature=&timestamp=&sessionId=&xmlParameters=%3CSearchItemsParameters%3E%0D%0A++%3CProvider%3EAlibaba1688%3C%2FProvider%3E%0D%0A++%3CImageUrl%3E'.$image.'%3C%2FImageUrl%3E%0D%0A%3C%2FSearchItemsParameters%3E%0D%0A&framePosition='.$frame_position.'&frameSize='.$frame_size.'&blockList=';
        $data = CategoryController::curl_json($url);
        $items = [];
        $count = 0;
        for($i = 0; $i<count($data['Result']['Items']['Items']['Content']); $i++){
            $items[] = $data['Result']['Items']['Items']['Content'][$count];
            $count++;
        }
        $total_count = $data['Result']['Items']['Items']['TotalCount'];
        return view('/pages/itemsPhoto', ['items'=>$items,  'total_count'=>$total_count, 'image'=>$image]);

    }
}
