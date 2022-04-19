<?php
namespace App\Services;

class DecodeJson
{
    public function curl_json($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $responce = curl_exec($ch);
        $data = json_decode($responce, true);
        curl_close($ch);
        return $data;
    }
}
