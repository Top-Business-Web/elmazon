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
                'answer_id' => 'required|exists:answers,id',
                'status' => 'nullable|in:leave'
            ];
            $validator = Validator::make($request->all(), $rules, [
                'question_id.exists' => 407,
                'answer_id.exists' => 408,
                'status.in' => 409

            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {
                    $errors_arr = [
                        407 => 'Failed,Question not exists.',
                        408 => 'Failed,Answer not exists.',
                        409 => 'Failed,Status must be an  leave  in the request.',
                    ];
                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            $question = Question::where('id', $request->question_id)->first();

//            return $question->answers;
            foreach ($question->answers as $answer) {
                if($answer->id == $request->answer_id) {
                    $online_exam_user = OnlineExamUser::create([
                        'user_id' => Auth::id(),
                        'question_id' => $request->question_id,
                        'answer_id' => $request->answer_id,
                        'online_exam_id' => $exam->id,
                        'status' => $answer->status == 'correct' ? 'solved' : 'un_correct',
                    ]);
                    return self::returnResponseDataApi(null,"تم حل السؤال واجابتك صحيحه",200);
                    break;
                   }else{
                    $online_exam_user = OnlineExamUser::create([
                        'user_id' => Auth::id(),
                        'question_id' => $request->question_id,
                        'answer_id' => $request->answer_id,
                        'online_exam_id' => $exam->id,
                        'status' => $request->status,
                    ]);

                    return self::returnResponseDataApi(null,"تم مغادره السؤال وعدم حله",200);
                    break;
                }
            }

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}
