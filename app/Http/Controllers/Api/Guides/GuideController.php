<?php

namespace App\Http\Controllers\Api\Guides;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
{

    public function index(){
        $guide = Guide::with('childs')->whereHas('term', function ($term){
            $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->whereNull('from_id')->get();

        if($guide->count() > 0){

                return self::returnResponseDataApi(GuideResource::collection($guide),"تم وصل الدليل كامل ",200);

        }else{

            return self::returnResponseDataApi(null,"لا يوجد بيانات في الدليل الي الان ",405);
        }

    }
}
