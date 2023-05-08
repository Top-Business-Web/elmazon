<?php

namespace App\Http\Controllers\Api\LiveExam;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionsNewResource;
use App\Http\Resources\LiveExamDetailsResource;
use App\Http\Resources\LiveExamQuestionsResource;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Models\AllExam;
use App\Models\Answer;
use App\Models\ExamDegreeDepends;
use App\Models\LifeExam;
use App\Models\OnlineExam;
use App\Models\OnlineExamUser;
use App\Models\Question;
use App\Models\Timer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LiveExamController extends Controller{



   public function allOfQuestions($id): JsonResponse
   {

       try {


           $liveExam = LifeExam::query()
               ->whereHas('term', fn(Builder $builder) => $builder->where('status', '=', 'active')
                   ->where('season_id', '=', auth('user-api')->user()->season_id))
               ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
               ->where('id', '=', $id)
               ->first();

                   if (!$liveExam) {
                       return self::returnResponseDataApi(null, "الامتحان الايف غير موجود", 404);
                   }else{

                       return self::returnResponseDataApi(new LiveExamQuestionsResource($liveExam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);
                   }

           } catch (\Exception $exception) {

           return self::returnResponseDataApi(null, $exception->getMessage(), 500);
       }

   }


    public function addLiveExamByStudent(Request $request,$id): JsonResponse{

        $liveExam = LifeExam::query()
            ->whereHas('term', fn(Builder $builder) => $builder->where('status', '=', 'active')
                ->where('season_id', '=', auth('user-api')->user()->season_id))
            ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
            ->where('id', '=', $id)
            ->first();


        if (!$liveExam) {
            return self::returnResponseDataApi(null, "الامتحان الايف غير موجود", 404);
        }

        $liveExamStudentCheck = ExamDegreeDepends::query()
            ->where('life_exam_id','=',$liveExam->id)
            ->where('user_id','=',Auth::guard('user-api')->id())
            ->first();

        if($liveExamStudentCheck){
            $liveExamUserCorrectAnswers  = OnlineExamUser::query()
                ->where('user_id','=',Auth::guard('user-api')->id())
                ->where('life_exam_id','=',$liveExam->id)
                ->where('status','=','solved')
                ->count();


            $liveExamUserMistakeAnswers  = OnlineExamUser::query()
                ->where('user_id','=',Auth::guard('user-api')->id())
                ->where('life_exam_id','=',$liveExam->id)
                ->where('status','=','un_correct')
                ->orWhere('status','=','leave')
                ->count();



            $data['full_degree']     = ($liveExamStudentCheck->full_degree) . " / " . $liveExam->degree;
            $data['correct_numbers'] =  $liveExamUserCorrectAnswers;
            $data['mistake_numbers'] =  $liveExamUserMistakeAnswers;
            $data['exam_questions']  = new ExamQuestionsNewResource($liveExam);

            return self::returnResponseDataApi($data, "انت اديت هذا الامتحان من قبل", 201);

        }else{

            $arrayOfDegree = [];

            for ($i = 0; $i < count($request->details); $i++) {

                $question = Question::query()
                    ->where('id', '=', $request->details[$i]['question'])
                    ->first();

                $answer = Answer::query()
                    ->where('id', '=', $request->details[$i]['answer'])
                    ->first();

                $examStudentCreate = OnlineExamUser::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'question_id' => $request->details[$i]['question'],
                    'answer_id' => $request->details[$i]['answer'],
                    'life_exam_id' => $liveExam->id,
                    'status' => isset($answer) ? $answer->answer_status == "correct" ? "solved" : "un_correct" : "leave",
                    'degree' => $answer->answer_status == "correct" ? $question->degree : 0,
                ]);

                $arrayOfDegree[] = $examStudentCreate->degree;
            }


            $resultOfDegreeLiveExam = ExamDegreeDepends::create([
               'life_exam_id' => $liveExam->id,
               'user_id' => Auth::guard('user-api')->id(),
                'full_degree' => array_sum($arrayOfDegree),
            ]);


            $liveExamUserCorrectAnswers  = OnlineExamUser::query()
                ->where('user_id','=',Auth::guard('user-api')->id())
                ->where('life_exam_id','=',$liveExam->id)
                ->where('status','=','solved')
                ->count();

            $liveExamUserMistakeAnswers  = OnlineExamUser::query()
                ->where('user_id','=',Auth::guard('user-api')->id())
                ->where('life_exam_id','=',$liveExam->id)
                ->where('status','=','un_correct')
                ->orWhere('status','=','leave')
                ->count();


            $data['full_degree']     = ($resultOfDegreeLiveExam->full_degree) . " / " . $liveExam->degree;
            $data['correct_numbers'] =  $liveExamUserCorrectAnswers;
            $data['mistake_numbers'] =  $liveExamUserMistakeAnswers;
            $data['exam_questions']  = new LiveExamDetailsResource($liveExam);

            return self::returnResponseDataApiWithMultipleIndexes($data,"تم اداء الامتحان بنجاح",200);


        }

    }


    public function allOfLiveExamsStudent(): JsonResponse{


      $allOfLiveExams = ExamDegreeDepends::query()
          ->where('user_id','=',Auth::guard('user-api')->id())
          ->get();

        return self::returnResponseDataApi($allOfLiveExams,"تم جلب جميع الامتحانات الايف  بنجاح",200);


    }


    public function allOfExamHeroes($id): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }

    public function resultOfLiveExam($id): JsonResponse{

        return self::returnResponseDataApi(null,"Hello in my app",200);

    }


}
