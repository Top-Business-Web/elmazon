<?php

namespace App\Http\Controllers\Api\LiveExam;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionsNewResource;
use App\Http\Resources\HeroesExamResource;
use App\Http\Resources\LifeExamResource;
use App\Http\Resources\LiveExamDetailsResource;
use App\Http\Resources\LiveExamFavoriteResource;
use App\Http\Resources\LiveExamHeroesResource;
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
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LiveExamController extends Controller
{


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
            } else {

                return self::returnResponseDataApi(new LiveExamQuestionsResource($liveExam), "تم ارسال جميع الاسئله بالاجابات التابعه لهذا الامتحان", 200);
            }

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function addLiveExamByStudent(Request $request, $id): JsonResponse
    {

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
            ->where('life_exam_id', '=', $liveExam->id)
            ->where('user_id', '=', Auth::guard('user-api')->id())
            ->first();

        if ($liveExamStudentCheck) {
            $liveExamUserCorrectAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'solved')
                ->count();


            $liveExamUserMistakeAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'un_correct')
                ->orWhere('status', '=', 'leave')
                ->count();


            $data['student_degree'] = ($liveExamStudentCheck->full_degree) . " / " . $liveExam->degree;
            $data['num_of_correct_questions'] = $liveExamUserCorrectAnswers;
            $data['num_of_mistake_questions'] = $liveExamUserMistakeAnswers;
            $data['exam_questions'] = new ExamQuestionsNewResource($liveExam);

            return self::returnResponseDataApi($data, "انت اديت هذا الامتحان من قبل", 201);

        } else {

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


            $liveExamUserCorrectAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'solved')
                ->count();

            $liveExamUserMistakeAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'un_correct')
                ->orWhere('status', '=', 'leave')
                ->count();


            $data['student_degree'] = ($resultOfDegreeLiveExam->full_degree) . " / " . $liveExam->degree;
            $data['num_of_correct_questions'] = $liveExamUserCorrectAnswers;
            $data['num_of_mistake_questions'] = $liveExamUserMistakeAnswers;
            $data['exam_questions'] = new LiveExamDetailsResource($liveExam);

            return self::returnResponseDataApiWithMultipleIndexes($data, "تم اداء الامتحان بنجاح", 200);

        }

    }


    public function allOfLiveExamsStudent(): JsonResponse
    {


        $allOfLiveExams = LifeExam::query()
            ->whereHas('term', fn(Builder $builder) =>
            $builder->where('status', '=', 'active')
                ->where('season_id', '=', auth('user-api')->user()->season_id))
            ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
            ->whereHas('exams_degree_depends', fn(Builder $builder) =>
            $builder->where('user_id', '=', Auth::guard('user-api')->id()))
            ->get();

        return self::returnResponseDataApi(LiveExamFavoriteResource::collection($allOfLiveExams), "تم جلب جميع الامتحانات الايف  بنجاح", 200);


    }


    public function allOfExamHeroes($id): JsonResponse
    {

        try {


            $liveExamHeroes = LifeExam::query()
                ->whereHas('term', fn(Builder $builder) => $builder->where('status', '=', 'active')
                    ->where('season_id', '=', auth('user-api')->user()->season_id))
                ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                ->where('id', '=', $id)
                ->first();

            if (!$liveExamHeroes) {
                return self::returnResponseDataApi(null, "الامتحان الايف غير موجود", 404);
            }


            $users = User::with(['exam_degree_depends_user' => function($q) use($liveExamHeroes){
                $q->where('life_exam_id', '=', $liveExamHeroes->id)
                ->orderBy('full_degree', 'desc');
            }])->whereHas('exam_degree_depends_user', fn(Builder $builder) => $builder->where('life_exam_id', '=', $liveExamHeroes->id)
                ->orderBy('full_degree', 'desc'))
                ->whereHas('season', fn(Builder $builder) => $builder->where('season_id', '=', auth()->guard('user-api')->user()->season_id))
                ->take(10)
                ->get()
                ->sortByDesc('exam_degree_depends_user.full_degree');


            $usersIds = $users->pluck('id')->toArray();

            foreach ($users as $user) {
                $user->ordered = (array_search($user->id,$usersIds)) + 1;
            }

            $liveExmDegreeCheck = ExamDegreeDepends::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExamHeroes->id)
                ->first();

            $allOfStudentEnterLifeExam = User::with(['exam_degree_depends_user' => function($q) use($liveExamHeroes) {
            $q->where('life_exam_id', '=', $liveExamHeroes->id);
                 }])
                ->whereHas('exam_degree_depends_user', fn(Builder $builder) => $builder->where('life_exam_id', '=', $liveExamHeroes->id))
                ->pluck('id')
                ->toArray();


            if ($liveExmDegreeCheck) {
                $checkStudentAuth = Auth::guard('user-api')->user();
                $studentAuth = new LiveExamHeroesResource($checkStudentAuth);
                $studentAuth->ordered = (array_search($checkStudentAuth->id, $allOfStudentEnterLifeExam)) + 1;
                $data['MyOrdered'] = $studentAuth;
                $data['AllExamHeroes'] = LiveExamHeroesResource::collection($users->take(10));

                return self::returnResponseDataApi($data, "تم الحصول علي ابطال الامتحانات الايف بنجاح", 200);

            } else {

                return self::returnResponseDataApi(null, "انت لم تؤدي هذا الامتحان برجاء الامتحان اولا لاظهار ابطال المنصه", 403);
            }

//            return self::returnResponseDataApi(LiveExamHeroesResource::collection($users),"تم الحصول علي ابطال الامتحانات الايف بنجاح",200);


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function resultOfLiveExam($id): JsonResponse
    {

        //Live exam find by id with query
        $liveExam = LifeExam::query()
            ->whereHas('term', fn(Builder $builder) => $builder->where('status', '=', 'active')
                ->where('season_id', '=', auth('user-api')->user()->season_id))
            ->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
            ->where('id', '=', $id)
            ->first();

        if (!$liveExam) {
            return self::returnResponseDataApi(null, "الامتحان الايف غير موجود", 404);
        }

        //start check if user enter live exam or not
        $liveExamStudentCheck = ExamDegreeDepends::query()
            ->where('life_exam_id', '=', $liveExam->id)
            ->where('user_id', '=', Auth::guard('user-api')->id())
            ->first();

        if ($liveExamStudentCheck) {


            //start count all status of answer questions of student auth
            $liveExamUserCorrectAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'solved')
                ->count();


            $liveExamUserMistakeAnswers = OnlineExamUser::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'un_correct')
                ->orWhere('status', '=', 'leave')
                ->count();

            $numOfLeaveQuestions = OnlineExamUser::query()
                ->where('user_id', Auth::guard('user-api')->id())
                ->where('life_exam_id', '=', $liveExam->id)
                ->where('status', '=', 'leave')
                ->count();

           //end count all status of answer questions of student auth


            //start ordered student auth
            $allOfStudentEnterLifeExam = User::with(['exam_degree_depends_user' => fn(HasOne $q) =>
            $q->where('life_exam_id', '=', $liveExam->id)])
                ->whereHas('exam_degree_depends_user', fn(Builder $builder) =>
                $builder->where('life_exam_id', '=', $liveExam->id))
                ->pluck('id')
                ->toArray();


            $checkStudentAuth = Auth::guard('user-api')->user();
            $studentAuth = new LiveExamHeroesResource($checkStudentAuth);
            $studentAuth->ordered = (array_search($checkStudentAuth->id, $allOfStudentEnterLifeExam)) + 1;
            //end ordered student auth


            //start response of screen degree exam live
            $data['ordered'] = $studentAuth->ordered;
            $data['motivational_word'] = "ممتاز بس فيه أحسن ";
            $data['student_per'] = (($liveExamStudentCheck->full_degree / $liveExam->degree) * 100) . "%";
            $data['num_of_correct_questions'] = $liveExamUserCorrectAnswers;
            $data['num_of_mistake_questions'] = $liveExamUserMistakeAnswers;
            $data['num_of_leave_questions'] = $numOfLeaveQuestions;
            $data['exam_questions'] = new ExamQuestionsNewResource($liveExam);

            return self::returnResponseDataApi($data, "انت اديت هذا الامتحان من قبل", 201);

        } else {

            return self::returnResponseDataApi(null, "انت لم تؤدي هذا الامتحان برجاء الامتحان اولا لاظهار ابطال المنصه", 403);

        }
    }


}
