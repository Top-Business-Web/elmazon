<?php

namespace App\Http\Controllers\Api\SubjectClass;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Http\Resources\SubjectClassResource;
use App\Models\Lesson;
use App\Models\SubjectClass;

class SubjectClassController extends Controller
{
    public function allClasses(){


        try {

            $classes = SubjectClass::whereHas('term', function ($term){

                $term->where('status','=','active');
            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();
            if($classes->count() > 0){

                return self::returnResponseDataApi(SubjectClassResource::collection($classes),"تم ارسال جميع فصول الماده",200);

            }else{

                return self::returnResponseDataApi(null,"لا يوجد فصول دراسيه",405);
            }

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }

    }

    public function lessonsByClassId($id){

        try {
            $class = SubjectClass::find($id);

            if(!$class){
                return self::returnResponseDataApi(null,"هذا الفصل غير موجود",404);

            }

            $lessons = Lesson::where('subject_class_id','=',$id)->get();

            return self::returnResponseDataApi(LessonResource::collection($lessons),"تم الحصول علي جميع الدروس التابعه لهذا الفصل",200);

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }
    }
}
