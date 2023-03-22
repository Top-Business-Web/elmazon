<?php

namespace App\Http\Controllers\Api\LifeExam;

use App\Http\Controllers\Controller;
use App\Http\Resources\LifeExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\LifeExam;
use App\Models\Question;
use App\Models\SubjectClass;
use App\Models\VideoParts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LifeExamController extends Controller{


    public function access_first_question($id){

        $life_exam = LifeExam::whereHas('term', function ($term){
            $term->where('status','=','active');
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->first();

        if(!$life_exam){
            return self::returnResponseDataApi(null,"الامتحان الايف غير موجود",404,404);
        }

        $first_question = $life_exam->questions()->orderBy('id','ASC')->first();

        return self::returnResponseDataApi(new QuestionResource($first_question),"تم الوصول الي اول سؤال في الامتحان الايف",200);
    }


    public function add_life_exam_with_student(Request $request,$id){

        $life_exam = LifeExam::whereHas('term', function ($term){
            $term->where('status','=','active');
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->first();

        if(!$life_exam){
            return self::returnResponseDataApi(null,"الامتحان الايف غير موجود",404,404);
        }

        $rules = [
            'question_id' => ['required',Rule::exists('online_exam_questions','question_id')->where(function ($query) use($life_exam) {return $query->where('life_exam_id',$life_exam->id);})],
            'answer_id' => ['required',Rule::exists('answers','id')->where(function ($query) use($request) {return $query->where('question_id',$request->question_id);})],

        ];
        $validator = Validator::make($request->all(), $rules, [
            'question_id.exists' => 406,
            'answer_id.exists' => 407,
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    406 => 'هذا السؤال غير تابع لهذا الامتحان',
                    407 => 'الاجابه غير تابعه لهذا السؤال'
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }
        /*
         * $startTime = Carbon::parse($this->start_time);
          $finishTime = Carbon::parse($this->finish_time);
          $totalDuration = $finishTime->diffForHumans($startTime);
          dd($totalDuration);
         */
        $now = Carbon::now();
        $start = Carbon::createFromTimeString($life_exam->time_start);
        $end =  Carbon::createFromTimeString($life_exam->time_end);



        if ($now->isBetween($start,$end)) {
            // between 8:00 AM and 8:00 PM
            return "Yes";
        } else {

            return "No";
            // not between 8:00 AM and 8:00 PM
        }

//        return new LifeExamResource($life_exam);

    }
}
