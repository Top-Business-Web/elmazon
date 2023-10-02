<?php

namespace App\Http\Controllers\Api\ExamEntry;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamHeroesNewResource;
use App\Http\Resources\OnlineExamQuestionResource;
use App\Models\AllExam;
use App\Models\Answer;
use App\Models\ExamDegreeDepends;
use App\Models\OnlineExam;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamEntryController extends Controller
{

    public function all_questions_by_online_exam(Request $request,$id)
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
                    ->where('id', '=', $id)
                    ->where('type', '=', 'class')
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

    public function online_exam_by_user(Request $request, $id): JsonResponse{

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


            if (in_array(request()->exam_type,['video','subject_class','lesson'])) {

                if(request()->exam_type == 'subject_class'){

                    $exam = OnlineExam::query()
                        ->where('id',$id)
                        ->where('type', '=', 'class')
                        ->first();

                    if (!$exam) {
                        return self::returnResponseDataApi(null, "امتحان الفصل غير موجود", 404,404);
                    }

                }else{

                    $exam = OnlineExam::query()
                        ->where('id',$id)
                        ->where('type', '=',request()->exam_type)
                        ->first();

                    if (!$exam) {
                        return self::returnResponseDataApi(null, "امتحان الفيديو او الدرس غير موجود", 404,404);
                    }

                }


                $count_trying = Timer::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->count();


                $depends = ExamDegreeDepends::query()
                    ->where('online_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('exam_depends', '=', 'yes')
                    ->first();


            } else {

                $exam = AllExam::query()
                    ->where('id',$id)
                    ->first();

                $count_trying = Timer::query()
                    ->where('all_exam_id', '=', $exam->id)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->count();

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

                 /*
                 * start create new trying number for student
                 */

                  $timer =  Timer::create([
                        'online_exam_id' => $exam->id,
                        'user_id' => Auth::guard('user-api')->id(),
                        'timer' => request()->timer,
                    ]);


                    for ($i = 0; $i < count(request()->details); $i++) {

                        $question = Question::query()
                            ->where('id', '=',request()->details[$i]['question'])
                            ->first();

                        $answer = Answer::query()
                            ->where('id', '=',request()->details[$i]['answer'])
                            ->first();

                        if ($question->question_type == 'choice') {

                            OnlineExamUser::create([
                                'timer_id' =>   $timer->id,
                                'user_id' => Auth::id(),
                                'question_id' => request()->details[$i]['question'],
                                'answer_id' => request()->details[$i]['answer'],
                                'online_exam_id' => request()->exam_type == 'full_exam' ? null : $exam->id,
                                'all_exam_id' => request()->exam_type == 'full_exam' ? $exam->id : null,
                                'status' => request()->details[$i]['answer'] == null ? "leave"  : ($answer->answer_status == "correct" ? "solved" : "un_correct"),
                                'degree' => request()->details[$i]['answer'] == null ? 0 : ($answer->answer_status == "correct" ? $question->degree : 0) ,
                            ]);

                        } else {

                            $image = request()->details[$i]['image'] ?? null;
                            if (isset($image) && $image != "") {
                                $destinationPath = 'text_user_exam_files/images/';
                                $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
                                $image->move($destinationPath, $file);
                            }

                            $audio = request()->details[$i]['audio'] ?? null;
                            if (isset($audio) && $audio != "") {
                                $audioPath = 'text_user_exam_files/audios/';
                                $fileAudio = date('YmdHis') . "." . $audio->getClientOriginalExtension();
                                $audio->move($audioPath, $fileAudio);
                            }

                            TextExamUser::create([
                                'timer_id' =>   $timer->id,
                                'user_id' => auth()->id(),
                                'question_id' => request()->details[$i]['question'],
                                'online_exam_id' => $exam->id,
                                'answer' => request()->details[$i]['answer'] ?? null,
                                'image' => $file ?? null,
                                'audio' => $fileAudio ?? null,
                                'answer_type' => 'text',
                                'status' => (isset(request()->details[$i]['answer']) || isset(request()->details[$i]['image']) || isset(request()->details[$i]['audio'])) ? 'solved' : 'leave',
                            ]);
                        }
                    }//end foreach loop to create question and answers of users (choice and questions text)

                    if (request()->exam_type == 'full_exam') {

                        Timer::create([
                            'all_exam_id' => $exam->id,
                            'user_id' => Auth::guard('user-api')->id(),
                            'timer' => request()->timer,
                            ]);

                        $sumDegree = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('timer_id', '=',$timer->id)
                            ->sum('degree');

                        ExamDegreeDepends::create([
                            'timer_id' => $timer->id,
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
                            ->where('timer_id', '=',$timer->id)
                            ->where('status','=','solved')
                            ->count();

                        $numOfUnCorrectQtQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('timer_id', '=',$timer->id)
                            ->where('status','=','un_correct')
                            ->count();

                        $numOfLeaveQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('timer_id', '=',$timer->id)
                            ->where('status','=','leave')
                            ->count();

                        $totalTime = Timer::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $exam->id)
                            ->latest()
                            ->first();

                        $total_trying = Timer::query()
                            ->where('all_exam_id', '=', $exam->id)
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->count();

                        $data['degree'] =  $sumDegree."/".$exam->degree;
                        $data['ordered'] = 1;
                        $data['exam_id'] =  $exam->id;
                        $data['exam_name'] =  in_array(request()->exam_type,['video','subject_class','lesson'])  ? 'online_exam' : 'full_exam';
                        $data['exam_type'] = request()->exam_type;
                        $data['trying_number'] =  $total_trying;
                        $data['motivational_word'] = "ممتاز بس فيه أحسن ";
                        $data['num_of_correct_questions'] = $numOfCorrectQuestions;
                        $data['num_of_mistake_questions'] = $numOfUnCorrectQtQuestions;
                        $data['num_of_leave_questions'] =   $numOfLeaveQuestions;
                        $data['total_time_take'] = $totalTime->timer;
                        $data['total_time_exam'] = $exam->quize_minute;
                        $data['title_result'] = $exam->title_result;
                        $data['description_result'] = $exam->description_result;
                        $data['image_result'] = $exam->image_result == null ? asset('all_exam_result_images/default/default.png') :
                            asset('all_exam_result_images/images/'. $exam->image_result);


                    } else {



                        $sumDegree = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('timer_id', '=',$timer->id)
                            ->where('online_exam_id', '=', $exam->id)
                            ->sum('degree');

                        ExamDegreeDepends::create([
                            'timer_id' => $timer->id,
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
                            ->where('timer_id', '=',$timer->id)
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('status','=','solved')->count();

                        $numOfUnCorrectQtQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('timer_id', '=',$timer->id)
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('status','=','un_correct')->count();


                        $numOfLeaveQuestions = OnlineExamUser::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('timer_id', '=',$timer->id)
                            ->where('status','=','leave')->count();

                        $totalTime = Timer::query()
                            ->where('user_id', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=',$exam->id)
                            ->latest()
                            ->first();

                        $total_trying = Timer::query()
                            ->where('online_exam_id', '=', $exam->id)
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->count();

                        $data['degree'] =  $sumDegree."/".$exam->degree;
                        $data['ordered'] = 1;
                        $data['exam_id'] =  $exam->id;
                        $data['exam_name'] =  in_array(request()->exam_type,['video','subject_class','lesson']) ? 'online_exam' : 'full_exam';
                        $data['exam_type'] = request()->exam_type;
                        $data['trying_number'] =  $total_trying;
                        $data['motivational_word'] = "ممتاز بس فيه أحسن ";
                        $data['num_of_correct_questions'] = $numOfCorrectQuestions;
                        $data['num_of_mistake_questions'] = $numOfUnCorrectQtQuestions;
                        $data['num_of_leave_questions'] =   $numOfLeaveQuestions;
                        $data['total_time_take'] = (int)$totalTime->timer;
                        $data['total_time_exam'] = $exam->quize_minute;
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


    //access end time for exam
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

                $exam = AllExam::query()
                ->where('id', $id)->first();

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

            if(in_array(request()->exam_type,['video','subject_class','lesson'])){

                $exam = OnlineExam::query()
                    ->where('id','=',$id)
                    ->first();


                if(!$exam){
                    return self::returnResponseDataApi(null,"هذا الامتحان غير موجود",404,404);
                } else{

                    $exam_degree_depends = ExamDegreeDepends::query()
                        ->where('online_exam_id','=',$exam->id)
                        ->where('user_id', Auth::guard('user-api')->id())
                        ->orderBy('full_degree','DESC')
                        ->first();


                   if(!$exam_degree_depends){
                        return self::returnResponseDataApi(null,"يرجي ادخال هذا الامتحان اولا لاعتماد اعلي درجه",404,404);

                    }else{

                        $exam_degree_depends->update(['exam_depends' => 'yes']);
                        return self::returnResponseDataApi(null,"تم اعتماد درجه الاونلاين بنجاح",200);
                    }

                }//end else condition


            }else{

                if(request()->exam_type == 'full_exam')

                $exam = AllExam::query()
                       ->where('id','=',$id)
                     ->first();

                if(!$exam){
                    return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404,404);
                }else{

                    $exam_degree_depends = ExamDegreeDepends::query()
                        ->where('all_exam_id','=',$exam->id)
                        ->where('user_id', Auth::guard('user-api')->id())
                        ->orderBy('full_degree','DESC')
                        ->first();

                    if(!$exam_degree_depends){
                        return self::returnResponseDataApi(null,"يرجي ادخال الامتحان الشامل اولا لاعتماد اعلي درجه",404,404);

                    }else{

                        $exam_degree_depends->update(['exam_depends' => 'yes']);
                        return self::returnResponseDataApi(null,"تم اعتماد درجه الامتحان الشامل بنجاح",200);
                    }

                }

            }

        }catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }



    final public function examHeroesAll(): JsonResponse
    {

        try {

            $userCountExam = ExamDegreeDepends::query()
                ->where('user_id','=', auth()->guard('user-api')->id())
                ->where('exam_depends','=', 'yes')
                ->count();

            if($userCountExam > 0) {

                $data['day'] = $this->day();
                $data['week'] = $this->week();
                $data['current_month'] = $this->currentMonth();
                $data['last_month'] = $this->lastMonth();
                $data['day_heroes'] = $this->dayHeroesAll();
                $data['week_heroes'] = $this->weekHeroesAll();
                $data['current_month_heroes'] = $this->currentMonthHeroesAll();
                $data['last_month_heroes'] = $this->lastMonthHeroesAll();

                return self::returnResponseDataApi($data, "تم الحصول علي ابطال الامتحانات  بنجاح", 200);


            }else{

                return self::returnResponseDataApi(null, "يجب دخول امتحان واحد علي الاقل لاظهار ابطال المنصه", 403);
            }

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

     }


    final public function day(): ?array
    {

        $examsDepends = User::query()
            ->where('id','=',auth('user-api')->id())
        ->with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereDay('created_at', '=', Carbon::now()->format('d'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

        ->withSum(
            ['exam_degree_depends' => function ($query) {
                $query->where('exam_depends', '=', 'yes');
            }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
        ->first();


        $heroesDaysIds = collect($this->dayHeroesAll())->pluck('id')->toArray();

        if(!is_null($examsDepends)){

            $authStudent = Auth::guard('user-api')->user();
            $authData['id'] = $authStudent->id;
            $authData['name'] = $authStudent->name;
            $authData['country'] = lang() == 'ar'? $authStudent->country->name_ar : $authStudent->country->name_en;
            $authData['ordered'] = (array_search($authStudent->id,$heroesDaysIds)) + 1;
            $authData['student_total_degrees'] = (int)$examsDepends->exam_degree_depends_sum_full_degree;
            $authData['exams_total_degree'] = (int)$examsDepends->online_exams_sum_degree + $examsDepends->all_exams_sum_degree;
            $authData['image'] = $authStudent->image != null ? asset('/users/'.$authStudent->image) : asset('/default/avatar2.jfif');

            return $authData;

        }else{

           return null;
        }

    }


    final public function week():  ?array
    {

        $examsDepends = User::query()
            ->where('id','=',auth('user-api')->id())
        ->with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->first();

        $heroesWeekIds = collect($this->weekHeroesAll())->pluck('id')->toArray();

        if(!is_null($examsDepends)){

            $authStudent = Auth::guard('user-api')->user();
            $authData['id'] = $authStudent->id;
            $authData['name'] = $authStudent->name;
            $authData['country'] = lang() == 'ar'?$authStudent->country->name_ar : $authStudent->country->name_en;
            $authData['ordered'] = (array_search($authStudent->id,$heroesWeekIds)) + 1;
            $authData['student_total_degrees'] = (int)$examsDepends->exam_degree_depends_sum_full_degree;
            $authData['exams_total_degree'] = (int)$examsDepends->online_exams_sum_degree + $examsDepends->all_exams_sum_degree;
            $authData['image'] = $authStudent->image != null ? asset('/users/'.$authStudent->image) : asset('/default/avatar2.jfif');

            return $authData;

        }else{

            return null;

        }

    }

    final public function currentMonth():  ?array
    {

        $examsDepends = User::query()
            ->where('id','=',auth('user-api')->id())
            ->with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->first();

        $heroesCurrentMonthIds = collect($this->currentMonthHeroesAll())->pluck('id')->toArray();

        if(!is_null($examsDepends)){

            $authStudent = Auth::guard('user-api')->user();
            $authData['id'] = $authStudent->id;
            $authData['name'] = $authStudent->name;
            $authData['country'] = lang() == 'ar'?$authStudent->country->name_ar : $authStudent->country->name_en;
            $authData['ordered'] = (array_search($authStudent->id,$heroesCurrentMonthIds)) + 1;
            $authData['student_total_degrees'] = (int)$examsDepends->exam_degree_depends_sum_full_degree;
            $authData['exams_total_degree'] = (int)$examsDepends->online_exams_sum_degree + $examsDepends->all_exams_sum_degree;
            $authData['image'] = $authStudent->image != null ? asset('/users/'.$authStudent->image) : asset('/default/avatar2.jfif');

            return $authData;

        }else{

            return null;

        }

    }


    final public function lastMonth():  ?array
    {

        $examsDepends = User::query()
            ->where('id','=',auth('user-api')->id())
            ->with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereMonth('created_at', Carbon::now()->subMonth()->format('m'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->first();

        $heroesLastMonthIds = collect($this->lastMonthHeroesAll())->pluck('id')->toArray();

        if(!is_null($examsDepends)){

            $authStudent = Auth::guard('user-api')->user();
            $authData['id'] = $authStudent->id;
            $authData['name'] = $authStudent->name;
            $authData['country'] = lang() == 'ar'?$authStudent->country->name_ar : $authStudent->country->name_en;
            $authData['ordered'] = (array_search($authStudent->id,$heroesLastMonthIds)) + 1;
            $authData['student_total_degrees'] = (int)$examsDepends->exam_degree_depends_sum_full_degree;
            $authData['exams_total_degree'] = (int)$examsDepends->online_exams_sum_degree + $examsDepends->all_exams_sum_degree;
            $authData['image'] = $authStudent->image != null ? asset('/users/'.$authStudent->image) : asset('/default/avatar2.jfif');

            return $authData;

        }else{

            return null;
        }

    }



    final public function dayHeroesAll(): array
    {

        $students = User::with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereDay('created_at', '=', Carbon::now()->format('d'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->orderBy('exam_degree_depends_sum_full_degree', 'desc')
            ->get();


        $listOfStudentsIds = $students->pluck('id')->toArray();

        if(!is_null($students)){

            $data = [];
            foreach ($students as $student){

                $studentsData['id'] = $student->id;
                $studentsData['name'] = $student->name;
                $studentsData['country'] = lang() == 'ar'?$student->country->name_ar : $student->country->name_en;
                $studentsData['ordered'] = (array_search($student->id,$listOfStudentsIds)) + 1;
                $studentsData['student_total_degrees'] = (int)$student->exam_degree_depends_sum_full_degree;
                $studentsData['exams_total_degree'] = (int)$student->online_exams_sum_degree + $student->all_exams_sum_degree;
                $studentsData['image'] = $student->image != null ? asset('/users/'.$student->image) : asset('/default/avatar2.jfif');
                $data[] = $studentsData;
            }

            return $data;

        }else{

            return [];
        }

    }



   final public function weekHeroesAll(): array
   {

       $students = User::with(['exam_degree_depends' => fn(HasMany $q) =>
       $q->where('exam_depends', '=', 'yes')
       ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

       $builder->where('exam_depends', '=', 'yes')
           ->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])
           ->whereYear('created_at', '=', Carbon::now()->format('Y'))
       )->whereHas('season', fn(Builder $builder) =>
       $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

           ->withSum(
               ['exam_degree_depends' => function ($query) {
                   $query->where('exam_depends', '=', 'yes');
               }], 'full_degree')
           ->withSum(['onlineExams'], 'degree')
           ->withSum(['allExams'], 'degree')
           ->orderBy('exam_degree_depends_sum_full_degree', 'desc')
           ->get();

       $listOfStudentsIds = $students->pluck('id')->toArray();

       if(!is_null($students)){

           $data = [];
           foreach ($students as $student){

               $studentsData['id'] = $student->id;
               $studentsData['name'] = $student->name;
               $studentsData['country'] = lang() == 'ar'?$student->country->name_ar : $student->country->name_en;
               $studentsData['ordered'] = (array_search($student->id,$listOfStudentsIds)) + 1;
               $studentsData['student_total_degrees'] = (int)$student->exam_degree_depends_sum_full_degree;
               $studentsData['exams_total_degree'] = (int)$student->online_exams_sum_degree + $student->all_exams_sum_degree;
               $studentsData['image'] = $student->image != null ? asset('/users/'.$student->image) : asset('/default/avatar2.jfif');
               $data[] = $studentsData;
           }

           return $data;

       }else{

           return [];
       }
    }


    final public function currentMonthHeroesAll(): array
    {

        $students = User::with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->orderBy('exam_degree_depends_sum_full_degree', 'desc')
            ->get();

        $listOfStudentsIds = $students->pluck('id')->toArray();

        if(!is_null($students)){

            $data = [];
            foreach ($students as $student){

                $studentsData['id'] = $student->id;
                $studentsData['name'] = $student->name;
                $studentsData['country'] = lang() == 'ar'?$student->country->name_ar : $student->country->name_en;
                $studentsData['ordered'] = (array_search($student->id,$listOfStudentsIds)) + 1;
                $studentsData['student_total_degrees'] = (int)$student->exam_degree_depends_sum_full_degree;
                $studentsData['exams_total_degree'] = (int)$student->online_exams_sum_degree + $student->all_exams_sum_degree;
                $studentsData['image'] = $student->image != null ? asset('/users/'.$student->image) : asset('/default/avatar2.jfif');
                $data[] = $studentsData;
            }

            return $data;

        }else{

            return [];
        }
    }


    final public function lastMonthHeroesAll(): array
    {

        $students = User::with(['exam_degree_depends' => fn(HasMany $q) =>
        $q->where('exam_depends', '=', 'yes')
        ])->whereHas('exam_degree_depends', fn(Builder $builder) =>

        $builder->where('exam_depends', '=', 'yes')
            ->whereMonth('created_at', Carbon::now()->subMonth()->format('m'))
            ->whereYear('created_at', '=', Carbon::now()->format('Y'))
        )->whereHas('season', fn(Builder $builder) =>
        $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))

            ->withSum(
                ['exam_degree_depends' => function ($query) {
                    $query->where('exam_depends', '=', 'yes');
                }], 'full_degree')
            ->withSum(['onlineExams'], 'degree')
            ->withSum(['allExams'], 'degree')
            ->orderBy('exam_degree_depends_sum_full_degree', 'desc')
            ->get();

        $listOfStudentsIds = $students->pluck('id')->toArray();

        if(!is_null($students)){

            $data = [];
            foreach ($students as $student){

                $studentsData['id'] = $student->id;
                $studentsData['name'] = $student->name;
                $studentsData['country'] = lang() == 'ar'?$student->country->name_ar : $student->country->name_en;
                $studentsData['ordered'] = (array_search($student->id,$listOfStudentsIds)) + 1;
                $studentsData['student_total_degrees'] = (int)$student->exam_degree_depends_sum_full_degree;
                $studentsData['exams_total_degree'] = (int)$student->online_exams_sum_degree + $student->all_exams_sum_degree;
                $studentsData['image'] = $student->image != null ? asset('/users/'.$student->image) : asset('/default/avatar2.jfif');
                $data[] = $studentsData;
            }

            return $data;

        }else{

            return [];
        }
    }


}
