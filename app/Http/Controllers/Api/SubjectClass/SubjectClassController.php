<?php

namespace App\Http\Controllers\Api\SubjectClass;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\SubjectClassResource;
use App\Models\AllExam;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\SubjectClass;

class SubjectClassController extends Controller
{
    public function allClasses(){


        try {

            $classes = SubjectClass::whereHas('term', function ($term){

                $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();

            $fullExams = AllExam::whereHas('term', function ($term){

                $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();

            return response()->json([

                'data' => [
                     'classes' => SubjectClassResource::collection($classes),
                     'fullExams' => AllExamResource::collection($fullExams),
                    'code' => 200,
                    'message' => "تم الحصول علي جميع الدروس التابعه لهذا الفصل",
                ]
            ]);


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

            return response()->json([

                'data' => [
                    'class' => new SubjectClassResource($class),
                    'code' => 200,
                    'message' => "تم الحصول علي جميع الدروس التابعه لهذا الفصل",
                ]
            ]);


        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }
    }
}
