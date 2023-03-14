<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\QuestionResource;
use App\Models\AllExam;
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

    public function all_questions_by_online_exam(Request $request,$id){

        try {

            $rules = [
                'exam_type' => 'required|in:video,subject_class,lesson,full_exam',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'exam_type.in' => 407,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,The exam type must be an video or lesson or subject_class or full_exam.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }


            $onlineExam = OnlineExam::whereHas('term', function ($term){

                $term->where('status','=','active');
            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id',$id);



            if($request->exam_type == 'video'){
             $onlineExam->where('type','=','video')->first();
                if(!$onlineExam){
                    return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
                }
                if(isset($onlineExam)){
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                }
            }elseif ($request->exam_type == 'subject_class'){
              $onlineExam->where('type','=','subject_class')->first();
                if(!$onlineExam){
                    return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
                }
                if(isset($onlineExam)){
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                }
            }elseif ($request->exam_type == 'lesson'){
               $onlineExam->where('type','=','lesson')->first();
                if(!$onlineExam){
                    return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
                }
                if(isset($onlineExam)){
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                }
            } else{
                if($request->exam_type == 'full_exam'){
                    $full_exam = AllExam::whereHas('term', function ($term){
                        $term->where('status','=','active');
                    })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id',$id)->first();
                    if(!$full_exam){
                        return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404);
                    }
                    if(isset($full_exam)){
                        return self::returnResponseDataApi(new OnlineExamQuestionResource($full_exam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                    }
                }

            }

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function online_exam_by_user(Request $request,$id){

//        return $request->details;
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
                        'question_id' => $request->details[$i]['question'],
                        'online_exam_id' => $exam->id,
                        'type' => 'choice',
                        'degree' => $onlineExamUser->status == "solved" ?  $onlineExamUser->question->degree : 0,
                    ]);
                }else{

//                    $image = $request->details[$i]['image'];
//                    $destinationPath = 'text_user_exam_files/images/';
//                    $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
//                    $image->move($destinationPath, $file);
//                    $request->details[$i]['image'] = "$file";
//
//
//                    $audio = $request->details[$i]['audio'];
//                    $audioPath = 'text_user_exam_files/audios/';
//                    $fileAudio = date('YmdHis') . "." . $audio->getClientOriginalExtension();
//                    $audio->move($audioPath, $fileAudio);
//                    $request->details[$i]['audio'] = "$fileAudio";


//                return  $request['details'][$i]['image'];
               $textExamUser = TextExamUser::create([
                   'user_id' => auth()->id(),
                   'question_id' => $request->details[$i]['question'],
                   'online_exam_id' => $exam->id,
                   'answer' => $request->details[$i]['answer'] ?? null,
                   'answer_type' => 'text',
                   'status' =>  ($request->details[$i]['answer']) != null  ? 'solved' : 'leave',
               ]);

                Degree::create([
                    'user_id' => auth()->id(),
                    'question_id' => $request->details[$i]['question'],
                    'online_exam_id' => $exam->id,
                    'type' => 'text',
                    'status' => 'not_completed',
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