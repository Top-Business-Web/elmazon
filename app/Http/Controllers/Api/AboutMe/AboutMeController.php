<?php

namespace App\Http\Controllers\Api\AboutMe;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutMeResource;
use App\Models\AboutMe;
use Illuminate\Http\JsonResponse;

class AboutMeController extends Controller{


    public function about_me(): JsonResponse{

        $about_me = AboutMe::query()->first();
        if($about_me->count() > 0){
            return self::returnResponseDataApi(new AboutMeResource($about_me),"تم الحصول علي بيانات المدرس بنجاح",200);

        }else{

            return self::returnResponseDataApi(null,"لا يوجد بيانات الي الان",201);

        }

    }

}
