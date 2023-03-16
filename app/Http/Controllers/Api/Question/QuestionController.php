<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\AllExam;
use App\Models\Answer;
use App\Models\Degree;
use App\Models\ExamDegreeDepends;
use App\Models\ExamInstruction;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamUser;
use App\Models\Question;
use App\Models\TextExamUser;
use App\Models\Timer;
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


            if($request->exam_type == 'video'){
                $onlineExam = OnlineExam::whereHas('term', function ($term){
                    $term->where('status','=','active');
                })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->where('type','=','video')->first();
                if(!$onlineExam){
                    return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
                }
                if(isset($onlineExam)){
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                }
            }elseif ($request->exam_type == 'subject_class'){
                $onlineExam = OnlineExam::whereHas('term', function ($term){
                    $term->where('status','=','active');
                })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->where('type','=','subject_class')->first();
                if(!$onlineExam){
                    return self::returnResponseDataApi(null,"الامتحان غير موجود",404);
                }
                if(isset($onlineExam)){
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam),"تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان",200);
                }
            }elseif ($request->exam_type == 'lesson'){
                $onlineExam = OnlineExam::whereHas('term', function ($term){
                    $term->where('status','=','active');
                })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->where('type','=','lesson')->first();
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
                    })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('id','=',$id)->first();
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


            if ($request->exam_type == 'video' || $request->exam_type == 'subject_class' || $request->exam_type == 'lesson') {
                $exam = OnlineExam::where('id', $id)->where('type', '=', $request->exam_type)->first();
                $count_trying = Timer::where('online_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->count();
                $online_exam_users = OnlineExamUser::where('online_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();
                $text_exam_users = TextExamUser::where('online_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();
                $all_degrees = Degree::where('online_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();

                $depends = ExamDegreeDepends::where('online_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('exam_depends', '=', 'yes')->first();
                if (!$exam) {
                    return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
                }
            } else {
                $exam = AllExam::where('id', $id)->first();
                $count_trying = Timer::where('all_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->count();
                $online_exam_users = OnlineExamUser::where('all_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();
                $text_exam_users = TextExamUser::where('all_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();
                $all_degrees = Degree::where('all_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())->get();

                $depends = ExamDegreeDepends::where('all_exam_id', '=', $exam->id)->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('exam_depends', '=', 'yes')->first();
                if (!$exam) {
                    return self::returnResponseDataApi(null, "الامتحان الشامل غير موجود", 404);
                }
            }


            $trying = $exam->trying_number;

            if (!$depends) {

            if ($count_trying < $trying) {

                if ($count_trying > 0) {
                    foreach ($online_exam_users as $online_exam_user) {
                        $online_exam_user->delete();
                    }

                    foreach ($text_exam_users as $text_exam_user) {
                        $text_exam_user->delete();
                    }
                    foreach ($all_degrees as $all_degree) {
                        $all_degree->delete();
                    }
                }

                for ($i = 0; $i < count($request->details); $i++) {

                    $question = Question::where('id', '=', $request->details[$i]['question'])->first();
                    $answer = Answer::where('id', '=', $request->details[$i]['answer'])->first();

                    if ($question->question_type == 'choice') {
                        $onlineExamUser = OnlineExamUser::create([
                            'user_id' => Auth::id(),
                            'question_id' => $request->details[$i]['question'],
                            'answer_id' => $request->details[$i]['answer'],
                            'online_exam_id' => $exam->id,
                            'status' => isset($answer) ? $answer->answer_status == "correct" ? "solved" : "un_correct" : "leave",
                        ]);
                        Degree::create([
                            'user_id' => auth()->id(),
                            'question_id' => $request->details[$i]['question'],
                            'online_exam_id' => $exam->id,
                            'type' => 'choice',
                            'degree' => $onlineExamUser->status == "solved" ? $onlineExamUser->question->degree : 0,
                        ]);

                    } else {

                        $image = $request->details[$i]['image'] ?? null;
                        if (isset($image) && $image != "") {
                            $destinationPath = 'text_user_exam_files/images/';
                            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
                            $image->move($destinationPath, $file);
                        }

                        $audio = $request->details[$i]['audio'] ?? null;
                        if (isset($audio) && $audio != "") {
                            $audioPath = 'text_user_exam_files/audios/';
                            $fileAudio = date('YmdHis') . "." . $audio->getClientOriginalExtension();
                            $audio->move($audioPath, $fileAudio);
                        }

                        $textExamUser = TextExamUser::create([
                            'user_id' => auth()->id(),
                            'question_id' => $request->details[$i]['question'],
                            'online_exam_id' => $exam->id,
                            'answer' => isset($request->details[$i]['answer']) ? $request->details[$i]['answer'] : null,
                            'image' =>  $file ?? null,
                            'audio' => $fileAudio ?? null,
                            'answer_type' => 'text',
                            'status' => (isset($request->details[$i]['answer']) || isset($request->details[$i]['image']) || isset($request->details[$i]['audio'])) ? 'solved' : 'leave',
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

                if ($request->exam_type == 'full_exam') {
                    Timer::create([
                        'all_exam_id' => $exam->id,
                        'user_id' => Auth::guard('user-api')->id(),
                        'timer' => $request->timer,

                    ]);
                    $degrees_sum = Degree::where('all_exam_id', '=', $exam->id)->where('user_id', '=', auth('user-api')->id())
                        ->sum('degree');
                    ExamDegreeDepends::create([
                        'user_id' => auth('user-api')->id(),
                        'all_exam_id' => $exam->id,
                        'full_degree' => $degrees_sum,
                    ]);
                } else {

                    Timer::create([
                        'online_exam_id' => $exam->id,
                        'user_id' => Auth::guard('user-api')->id(),
                        'timer' => $request->timer,

                    ]);
                    $degrees_sum = Degree::where('online_exam_id', '=', $exam->id)->where('user_id', '=', auth('user-api')->id())
                        ->sum('degree');
                    ExamDegreeDepends::create([
                        'user_id' => auth('user-api')->id(),
                        'online_exam_id' => $exam->id,
                        'full_degree' => $degrees_sum,
                    ]);
                }
                return self::returnResponseDataApi($request->exam_type == 'full_exam' ? new AllExamResource($exam) : new OnlineExamResource($exam), "تم حل جميع الاسئله", 200);

            } else {
                return self::returnResponseDataApi(null, "لقد انتهيت من جميع محاولاتك لهذا الامتحان ولا يوجد لديك محاولات اخري", 415);
            }
           }else{
                return self::returnResponseDataApi(null, "تم اعتماد الدرجه لهذا الامتحان من قبل", 416);

            }

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}