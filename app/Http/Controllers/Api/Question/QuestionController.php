<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Models\Degree;
use App\Models\ExamInstruction;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamUser;
use App\Models\Question;
use App\Models\TextExamUser;
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

                $question = Question::where('id','=', $request->details[$i]['question'])->first();
                $answer = Answer::where('id','=',$request->details[$i]['answer'])->first();

                if($question->question_type == 'choice'){
                    $onlineExamUser =  OnlineExamUser::create([
                        'user_id' => Auth::id(),
                        'question_id' => $request->details[$i]['question'],
                        'answer_id' => $request->details[$i]['answer'],
                        'online_exam_id' => $exam->id,
                        'status' =>  isset($answer)?$answer->answer_status == "correct" ? "solved" : "un_correct" : "leave",
                    ]);

                    Degree::create([
                        'user_id' => auth()->id(),
                        'online_exam_user_id' => $onlineExamUser->id,
                        'type' => 'choice',
                        'degree' => $onlineExamUser->status == "solved" ?  $onlineExamUser->question->degree : 0,
                    ]);
                }else{

                if($image = $request->file('image')){
                    $destinationPath = 'text_user_exam_files/images/';
                    $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
                    $image->move($destinationPath, $file);
                    $request['image'] = "$file";

                }

                if($audio = $request->file('audio')){
                    $audioPath = 'text_user_exam_files/audios/';
                    $fileAudio = date('YmdHis') . "." . $audio->getClientOriginalExtension();
                    $audio->move($audioPath,$fileAudio);
                    $request['audio'] = "$fileAudio";
                }
               $textExamUser = TextExamUser::create([
                   'user_id' => auth()->id(),
                   'question_id' => $request->details[$i]['question'],
                   'online_exam_id' => $exam->id,
                   'answer' => $request->details[$i]['answer'],
                   'image' => $file ?? null,
                   'audio' => $fileAudio ?? null,
                   'answer_type' => 'text',
                   'status' =>  ($request->details[$i]['answer'] != null || $file != null || $audio != null) ? 'solved' : 'leave',
               ]);

                Degree::create([
                    'user_id' => auth()->id(),
                    'text_exam_user_id' => $textExamUser->id,
                    'type' => 'text',
                    'degree' => 0,
                ]);
                }

            }
            return self::returnResponseDataApi(null,"تم حل جميع الاسئله",200);

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}