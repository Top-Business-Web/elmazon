<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdsResource;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index(){
        $ads = Ads::where('status',1)->get();

        if($ads->count() > 0){

            return self::returnResponseDataApi(AdsResource::collection($ads),"جميع الاعلانات ",200);

        }else{

            return self::returnResponseDataApi(null,"لا يوجد بيانات في الدليل الي الان ",405);
        }

    }
}
