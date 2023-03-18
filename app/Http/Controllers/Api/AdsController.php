<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index(){
        $guide = Ads::where('status',1)->get();

        if($guide->count() > 0){

            return self::returnResponseDataApi(AdsResource::collection($guide),"جميع الاعلانات ",200);

        }else{

            return self::returnResponseDataApi(null,"لا يوجد بيانات في الدليل الي الان ",405);
        }

    }
}
