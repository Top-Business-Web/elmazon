<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\ExamInstruction;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamUser;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller{

    public function all_questions_by_online_exam($id){

        try {

            $exam = OnlineExam::where('id', $id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
            }
            $timer = ExamInstruction::where('online_exam_id','=',$id)->first()->quiz_minute;
            $exam->quiz_minute = (int)$timer;

            if(isset($exam)){
                return self::returnResponseDataApi(new OnlineExamQuestionResource($exam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
            }
        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function online_exam_by_user(Request $request,$id){

        try {
            $exam = OnlineExam::where('id', $id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
            }

            for ($i = 0; $i < count($request->details);$i++){

                $answer = Answer::where('id','=',$request->details[$i]['answer'])->first();
                OnlineExamUser::create([
                    'user_id' => Auth::id(),
                    'question_id' => $request->details[$i]['question'],
                    'answer_id' => $request->details[$i]['answer'],
                    'online_exam_id' => $exam->id,
                    'status' =>  isset($answer)?$answer->answer_status == "correct" ? "solved" : "un_correct" : "leave",
                ]);

            }

            return self::returnResponseDataApi(null,"تم حل جميع الاسئله",200);

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}