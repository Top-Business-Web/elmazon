<?php

namespace App\Http\Controllers\Api\LifeExam;

use App\Http\Controllers\Controller;
use App\Http\Resources\LifeExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\Degree;
use App\Models\ExamDegreeDepends;
use App\Models\Lesson;
use App\Models\LifeExam;
use App\Models\OnlineExamUser;
use App\Models\Question;
use App\Models\SubjectClass;
use App\Models\VideoParts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//        $now = Carbon::now();
//        $start = Carbon::createFromTimeString($life_exam->time_start);
//        $end =  Carbon::createFromTimeString($life_exam->time_end);
//
//
//
//        if ($now->isBetween($start,$end)) {
//            // between 8:00 AM and 8:00 PM
//            return "Yes";
//        } else {
//
//            return "No";
//            // not between 8:00 AM and 8:00 PM
//        }


//        $question = Question::where('id','=',$request->question_id)->first();
        $answer = Answer::where('id','=',$request->answer_id)->first();


            $life_exam_user = OnlineExamUser::create([
                'user_id' => Auth::guard('user-api')->id(),
                'question_id' => $request->question_id,
                'answer_id' => $request->answer_id,
                'life_exam_id' => $life_exam->id,
                'status' =>  $answer->answer_status == "correct" ? "solved" : "un_correct",
            ]);

            Degree::create([
                'user_id' => auth()->id(),
                'question_id' => $request->question_id,
                'life_exam_id' =>  $life_exam_user->life_exam_id,
                'type' => 'choice',
                'degree' => $life_exam_user->status == "solved" ? $life_exam_user->question->degree : 0,
            ]);

            $degrees_depends = ExamDegreeDepends::where('life_exam_id','=',$id)
                ->where('user_id', '=', auth('user-api')->id())->first();

            if(!$degrees_depends){
                ExamDegreeDepends::create([
                    'user_id' => auth('user-api')->id(),
                    'life_exam_id' =>  $life_exam_user->life_exam_id,
                    'full_degree' => $life_exam_user->status == "solved" ? $life_exam_user->question->degree : 0,
                ]);
            }else{
                $degrees_depends->update([
                  'full_degree' =>  $life_exam_user->status == "solved" ?
                      $degrees_depends->full_degree+=$life_exam_user->question->degree
                      : $degrees_depends->full_degree+=0,
                ]);
            }

            $next_question = Question::orderBy('id','ASC')->get()->except($request->question_id)->where('id','>',$request->question_id)->first();
            if($next_question){
                return self::returnResponseDataApi(new QuestionResource($next_question),"تم حل السؤال بنجاح",200);

            }else{
                return self::returnResponseDataApi(null,"تم الوصول الي السؤال الاخير",201);
            }




    }
}
