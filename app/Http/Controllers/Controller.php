<?php

namespace App\Http\Controllers;

abstract class Controller
{
        public function redirect($code)
    {
        $url = Url::where('short_code',$code)->first();

        if(!$url){
            return response()->json(['message'=>'Not Found'],404);
        }

        if($url->expires_at && now()->gt($url->expires_at)){
            return response()->json(['message'=>'Expired'],410);
        }

        $url->increment('clicks');

        return redirect($url->original_url);
    }
}
