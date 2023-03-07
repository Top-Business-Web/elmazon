<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
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

            $rules = [
                'question_id' => 'required|exists:questions,id',
                'answer_id' => 'nullable|exists:answers,id',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'question_id.exists' => 407,
                'answer_id.exists' => 408,

            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {
                    $errors_arr = [
                        407 => 'Failed,Question not exists.',
                        408 => 'Failed,Answer not exists.',
                    ];
                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            $question = Question::where('id', $request->question_id)->first();

            $online_exam_user = OnlineExamUser::where('user_id','=',Auth::guard('user-api')->id())
                ->where('question_id','=',$request->question_id)->where('online_exam_id','=',$id);


//            return $question->answers;

            if($online_exam_user->exists()){
                return self::returnResponseDataApi(null, "تم حل هذا السؤال من قبل", 410);
            }
            foreach ($question->answers as $answer) {
                if($answer->id == $request->answer_id && $answer->answer_status == "correct") {
                    OnlineExamUser::create([
                        'user_id' => Auth::id(),
                        'question_id' => $request->question_id,
                        'answer_id' => $request->answer_id,
                        'online_exam_id' => $exam->id,
                        'status' =>  "solved",
                    ]);
                    return self::returnResponseDataApi(null,"تم حل السؤال واجابتك صحيحه",200);
                    break;
                }elseif ($answer->id == $request->answer_id && $answer->answer_status == "un_correct"){

                    OnlineExamUser::create([
                        'user_id' => Auth::id(),
                        'question_id' => $request->question_id,
                        'answer_id' => $request->answer_id,
                        'online_exam_id' => $exam->id,
                        'status' =>  "un_correct",
                    ]);
                    return self::returnResponseDataApi(null,"تم حل السؤال واجابتك خاطئه",201);
                    break;
                }else{
                    if($request->answer_id == null){
                        OnlineExamUser::create([
                            'user_id' => Auth::id(),
                            'question_id' => $request->question_id,
                            'online_exam_id' => $exam->id,
                            'status' => "leave",
                        ]);

                        return self::returnResponseDataApi(null,"تم مغادره السؤال وعدم حله",202);
                        break;
                    }
                }
            }

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}