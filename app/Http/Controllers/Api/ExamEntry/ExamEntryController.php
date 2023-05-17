<?php

namespace App\Http\Controllers\Api\ExamEntry;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamHeroesNewResource;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\LiveExamHeroesResource;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\AllExam;
use App\Models\Answer;
use App\Models\ExamDegreeDepends;
use App\Models\ExamInstruction;
use App\Models\LifeExam;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamUser;
use App\Models\Question;
use App\Models\TextExamUser;
use App\Models\Timer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExamEntryController extends Controller
{

    public function all_questions_by_online_exam(Request $request,$id): JsonResponse
    {

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


            if ($request->exam_type == 'video') {

                $onlineExam = OnlineExam::query()
                    ->whereHas('term', fn(Builder $builder) => $builder->where('status', '=', 'active')
                        ->where('season_id', '=', auth('user-api')->user()->season_id))
                    ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                    ->where('id', '=', $id)
                    ->where('type', '=', 'video')
                    ->first();

                if (!$onlineExam) {

                    return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
                }else{
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);

                }

            } elseif ($request->exam_type == 'subject_class') {

                $onlineExam = OnlineExam::query()
                    ->whereHas('term', fn(Builder $builder) =>
                $builder->where('status', '=', 'active')
                    ->where('season_id', '=', auth('user-api')->user()->season_id))
                    ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                    ->where('id', '=', $id)
                    ->where('type', '=', 'subject_class')
                    ->first();

                if (!$onlineExam) {
                    return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
                }else{
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);

                }

            } elseif ($request->exam_type == 'lesson') {

                $onlineExam = OnlineExam::whereHas('term', fn(Builder $builder) =>
                $builder->where('status', '=', 'active')
                    ->where('season_id', '=', auth('user-api')->user()->season_id))
                    ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                    ->where('id', '=', $id)
                    ->where('type', '=', 'lesson')
                    ->first();

                if (!$onlineExam) {
                    return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
                }else{
                    return self::returnResponseDataApi(new OnlineExamQuestionResource($onlineExam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);

                }

            } else {
                if ($request->exam_type == 'full_exam') {

                    $full_exam = AllExam::whereHas('term', fn(Builder $builder) => $builder
                        ->where('status', '=', 'active')
                        ->where('season_id', '=', auth('user-api')->user()->season_id))
                        ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                        ->where('id', '=', $id)
                        ->first();

                    if (!$full_exam) {
                        return self::returnResponseDataApi(null, "الامتحان الشامل غير موجود", 404);
                    }else{
                        return self::returnResponseDataApi(new OnlineExamQuestionResource($full_exam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);

                    }
                }

            }

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function online_exam_by_user(Request $request, $id): JsonResponse
    {

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
                    return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }


            if ($request->exam_type == 'video' || $request->exam_type == 'subject_class' || $request->exam_type == 'lesson') {


                $exam = OnlineExam::query()
                    ->where('id', $id)
                    ->where('type', '=', $request->exam_type)
                    ->first();

                $count_trying = Timer::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->count();

                $online_exam_users = OnlineExamUser::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->get();


                $text_exam_users = TextExamUser::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->get();


                $depends = ExamDegreeDepends::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('exam_depends', '=', 'yes')
                    ->first();

                if (!$exam) {
                    return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
                }
            } else {
                $exam = AllExam::query()
                    ->where('id',$id)
                    ->first();

                $count_trying = Timer::query()
                    ->where('all_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->count();

                $online_exam_users = OnlineExamUser::query()
                    ->where('all_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->get();

                $text_exam_users = TextExamUser::where('all_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->get();


                $depends = ExamDegreeDepends::query()
                    ->where('all_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('exam_depends', '=', 'yes')
                    ->first();

                if (!$exam) {
                    return self::returnResponseDataApi(null, "الامتحان الشامل غير موجود", 404);
                }
            }


            $trying = $exam->trying_number;//trying number of exam

            if (!$depends) {

                if ($count_trying < $trying) {

                    if ($count_trying > 0) {

                        foreach ($online_exam_users as $online_exam_user) {
                            $online_exam_user->delete();
                        }

                        foreach ($text_exam_users as $text_exam_user) {
                            $text_exam_user->delete();
                        }

                    }

                    for ($i = 0; $i < count($request->details); $i++) {

                        $question = Question::query()
                            ->where('id', '=', $request->details[$i]['question'])
                            ->first();

                        $answer = Answer::query()
                            ->where('id', '=', $request->details[$i]['answer'])
                            ->first();

                        if ($question->question_type == 'choice') {

                            OnlineExamUser::create([
                                'user_id' => Auth::id(),
                                'question_id' => $request->details[$i]['question'],
                                'answer_id' => $request->details[$i]['answer'],
                                'online_exam_id' => $exam->id,
                                'status' => isset($answer) ? $answer->answer_status == "correct" ? "solved" : "un_correct" : "leave",
                                'degree' => $answer->answer_status == "correct" ? $question->degree : 0,
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

                            TextExamUser::create([
                                'user_id' => auth()->id(),
                                'question_id' => $request->details[$i]['question'],
                                'online_exam_id' => $exam->id,
                                'answer' => isset($request->details[$i]['answer']) ? $request->details[$i]['answer'] : null,
                                'image' => $file ?? null,
                                'audio' => $fileAudio ?? null,
                                'answer_type' => 'text',
                                'status' => (isset($request->details[$i]['answer']) || isset($request->details[$i]['image']) || isset($request->details[$i]['audio'])) ? 'solved' : 'leave',
                            ]);

                        }
                    }

                    if ($request->exam_type == 'full_exam') {

                        Timer::create([
                            'all_exam_id' => $exam->id,
                            'user_id' => Auth::guard('user-api')->id(),
                            'timer' => $request->timer,
                            ]);

                        $sumDegree = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->sum('degree');

                        ExamDegreeDepends::create([
                            'user_id' => auth('user-api')->id(),
                            'all_exam_id' => $exam->id,
                            'full_degree' => $sumDegree,
                            ]);

                        /*
                        |--------------------------------------------------------------------------
                         تفصاصيل درجات الامتحان الشامل
                        |--------------------------------------------------------------------------
                        */

                        $numOfCorrectQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('status','=','solved')->count();

                        $numOfUnCorrectQtQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('status','=','un_correct')->count();


                        $numOfLeaveQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('status','=','leave')->count();

                        $totalTime = Timer::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->latest()
                            ->first();

                        $data['degree'] =  $sumDegree."/".$exam->degree;
                        $data['ordered'] = 1;
                        $data['motivational_word'] = "ممتاز بس فيه أحسن ";
                        $data['num_of_correct_questions'] = $numOfCorrectQuestions;
                        $data['num_of_mistake_questions'] = $numOfUnCorrectQtQuestions;
                        $data['num_of_leave_questions'] =   $numOfLeaveQuestions;
                        $data['total_time_take'] = $totalTime->timer;
                        $data['title_result'] = $exam->title_result;
                        $data['description_result'] = $exam->description_result;
                        $data['image_result'] = $exam->image_result == null ? asset('all_exam_result_images/default/default.png') :
                            asset('all_exam_result_images/images/'. $exam->image_result);


                    } else {

                        Timer::create([
                            'online_exam_id' => $exam->id,
                            'user_id' => Auth::guard('user-api')->id(),
                            'timer' => $request->timer,
                            ]);

                        $sumDegree = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $exam->id)
                            ->sum('degree');

                        ExamDegreeDepends::create([
                            'user_id' => auth('user-api')->id(),
                            'online_exam_id' => $exam->id,
                            'full_degree' => $sumDegree,
                            ]);

                        /*
                       |--------------------------------------------------------------------------
                        تفصاصيل درجات الامتحان الاونلاين (فيديو-درس-فصل)
                       |--------------------------------------------------------------------------
                       */

                        $numOfCorrectQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('status','=','solved')->count();

                        $numOfUnCorrectQtQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('status','=','un_correct')->count();


                        $numOfLeaveQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('status','=','leave')->count();

                        $totalTime = Timer::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=',$exam->id)
                            ->latest()
                            ->first();

                        $data['degree'] =  $sumDegree."/".$exam->degree;
                        $data['ordered'] = 1;
                        $data['motivational_word'] = "ممتاز بس فيه أحسن ";
                        $data['num_of_correct_questions'] = $numOfCorrectQuestions;
                        $data['num_of_mistake_questions'] = $numOfUnCorrectQtQuestions;
                        $data['num_of_leave_questions'] =   $numOfLeaveQuestions;
                        $data['total_time_take'] = (int)$totalTime->timer;
                        $data['title_result'] = $exam->title_result;
                        $data['description_result'] = $exam->description_result;
                        $data['image_result'] = $exam->image_result == null ? asset('online_exam_result_images/default/default.png') : asset('online_exam_result_images/images/'. $exam->image_result);


                    }
                    return self::returnResponseDataApiWithMultipleIndexes($data,"تم اداء الامتحان بنجاح وارسال تفاصيل نتيجه الطالب",200);

                } else {
                    return self::returnResponseDataApi(null, "لقد انتهيت من جميع محاولاتك لهذا الامتحان ولا يوجد لديك محاولات اخري", 415);
                }
            } else {
                return self::returnResponseDataApi(null, "تم اعتماد الدرجه لهذا الامتحان من قبل", 416);
            }

        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }


    public function access_end_time_for_exam(Request $request, $id)
    {

        $rules = [
            'type' => 'required|in:video,subject_class,lesson,full_exam',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'type.in' => 407,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The exam type must be an video or lesson or subject_class or full_exam.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        if ($request->type == 'video' || $request->type == 'subject_class' || $request->type == 'lesson') {
            $exam = OnlineExam::where('id', $id)->where('type', '=', $request->type)->first();
            if (!$exam) {
                return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
            }

            Timer::create([
                'online_exam_id' => $exam->id,
                'user_id' => Auth::guard('user-api')->id(),
                'timer' => $request->timer,

            ]);
            return self::returnResponseDataApi(null, "تم اضافه محاوله جديده", 200);

        } else {
            if ($request->type == 'full_exam') {
                $exam = AllExam::where('id', $id)->first();
                if (!$exam) {
                    return self::returnResponseDataApi(null, "الامتحان ال موجود", 404);
                }

                Timer::create([
                    'all_exam_id' => $exam->id,
                    'user_id' => Auth::guard('user-api')->id(),
                    'timer' => $request->timer,

                ]);
                return self::returnResponseDataApi(null, "تم اضافه محاوله جديده للامتحان الشامل", 200);

            }
        }

    }

    public function degreesDependsWithStudent(Request $request,$id): JsonResponse{

        try {
            $rules = [
                'exam_type' => 'required|in:full_exam,lesson,subject_class,video'
            ];
            $validator = Validator::make($request->all(), $rules, [
                'exam_type.in' => 407,
            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,Exam type must be an lesson or video or subject_class oe full_exam.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            if($request->exam_type == 'video' || $request->exam_type == 'subject_class' || $request->exam_type == 'lesson'){

                $exam = OnlineExam::query()
                    ->where('id','=',$id)
                    ->first();

                if(!$exam){
                    return self::returnResponseDataApi(null,"هذا الامتحان غير موجود",404,404);
                }

                $exam_degree_depends = ExamDegreeDepends::query()
                    ->where('online_exam_id','=',$exam->id)
                    ->where('user_id', Auth::guard('user-api')->id())
                    ->orderBy('full_degree','DESC')
                    ->first();

                $exam_degree_depends->update(['exam_depends' => 'yes']);
                return self::returnResponseDataApi(null,"تم اعتماد درجه الاونلاين بنجاح",200);

            }else{

                if($request->exam_type == 'full_exam')
                    $exam = AllExam::where('id','=',$id)->first();
                if(!$exam){
                    return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404,404);
                }
                $exam_degree_depends = ExamDegreeDepends::query()
                    ->where('all_exam_id','=',$exam->id)
                    ->where('user_id', Auth::guard('user-api')->id())
                    ->orderBy('full_degree','DESC')
                    ->first();

                $exam_degree_depends->update(['exam_depends' => 'yes']);
                return self::returnResponseDataApi(null,"تم اعتماد درجه الامتحان الشامل بنجاح",200);
            }

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


    public function examHeroesAll(): JsonResponse{


        try {


            $day_heroes = User::dayOfExamsHeroes();

            $week_heroes = User::weekOfExamsHeroes();

            $month_heroes = User::monthOfExamsHeroes();


            $userCountExam = ExamDegreeDepends::query()
                ->where('user_id','=', auth()->guard('user-api')->id())
                ->where('exam_depends','=', 'yes')
                ->count();

            if($userCountExam > 0){

                $allOfStudentsEnterExams = User::allOfStudentsEnterExams();

                $examsStudentsDayHeroesIds = $day_heroes->pluck('id')->toArray();
                $examsStudentsWeekHeroesIds = $week_heroes->pluck('id')->toArray();
                $examsStudentsMonthHeroesIds = $month_heroes->pluck('id')->toArray();


                foreach ($day_heroes as $day_hero) {
                    $day_hero->ordered = (array_search($day_hero->id,$examsStudentsDayHeroesIds)) + 1;
                }


                foreach ($week_heroes as $week_hero) {
                    $week_hero->ordered = (array_search($week_hero->id,$examsStudentsWeekHeroesIds)) + 1;
                }

                foreach ($month_heroes as $month_hero) {
                    $month_hero->ordered = (array_search($month_hero->id,$examsStudentsMonthHeroesIds)) + 1;
                }


                $checkStudentAuth = Auth::guard('user-api')->user();
                $studentAuth = new AllExamHeroesNewResource($checkStudentAuth);
                $studentAuth->ordered = (array_search($checkStudentAuth->id,$allOfStudentsEnterExams)) + 1;
                $data['MyOrdered'] = $studentAuth;


                //all of exams heroes
                $data['day_heroes'] = AllExamHeroesNewResource::collection($day_heroes->take(10));
                $data['week_heroes'] = AllExamHeroesNewResource::collection($week_heroes->take(10));
                $data['month_heroes'] = AllExamHeroesNewResource::collection($month_heroes->take(10));

                return self::returnResponseDataApi($data, "تم الحصول علي ابطال الامتحانات  بنجاح", 200);


            }else{

                return self::returnResponseDataApi(null, "يجب دخول امتحان واحد علي الاقل لاظهار ابطال المنصه", 403);

            }


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }


    }
}
