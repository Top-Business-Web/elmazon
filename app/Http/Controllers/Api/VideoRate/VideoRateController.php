<?php

namespace App\Http\Controllers\Api\VideoRate;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoRateResource;
use App\Models\VideoParts;
use App\Models\VideoRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoRateController extends Controller{


    public function user_rate_video($id,Request $request){

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){
            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        $rules = [
            'action' => 'required|in:like,dislike',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'action.in' => 407
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The action type must be like or dislike',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }

       $video_rate = VideoRate::updateOrCreate(
           [
           'user_id'   => Auth::guard('user-api')->id(),
           ],
            [
            'video_id' => $video->id,
            'action' => $request->action
          ]
       );

        if(isset($video_rate)){
            return self::returnResponseDataApi(new VideoRateResource($video_rate),"تم تقييم الفيديو بنجاح",200);

        }else{
            return self::returnResponseDataApi(null,"يوجد خطاء ما اثناء دخول البيانات برجاء الرجوع للباك اند",500);

        }

    }

}
