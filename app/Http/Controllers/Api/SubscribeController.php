<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscribeResource;
use App\Models\Subscribe;

class SubscribeController extends Controller
{
    public function all(){

        try {

            $subscribes = Subscribe::where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();

            return self::returnResponseDataApi(SubscribeResource::collection($subscribes), "تم الحصول علي بيانات الاشتراكات بنجاح", 200);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

}
