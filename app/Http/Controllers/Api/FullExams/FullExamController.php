<?php

namespace App\Http\Controllers\Api\FullExams;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\LessonInstructionResource;
use App\Http\Resources\SubjectClassResource;
use App\Models\AllExam;
use App\Models\ExamInstruction;
use App\Models\SubjectClass;

class FullExamController extends Controller{


    public function fullExams(){

        $fullExams = AllExam::whereHas('term', function ($term){

            $term->where('status','=','active');
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();
        if($fullExams->count() > 0){

            return self::returnResponseDataApi(AllExamResource::collection($fullExams),"تم ارسال جميع الامتحانات الشامله بنجاح الماده",200);

        }else{

            return self::returnResponseDataApi(null,"لا يوجدامحانات شامله الي الان ",405);
        }

    }

    public function instructionByFullExamId($id){

        try {

            $fullExam = AllExam::find($id);
            if(!$fullExam){
                return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404);

            }

            $lessonInstruction = ExamInstruction::where('all_exam_id','=',$id)->first();
            return self::returnResponseDataApi(new LessonInstructionResource($lessonInstruction),"تم ارسال الارشاد التابع لهذا الامتحان الشامل بنجاح",200);


        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }


    }

}
