<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\AllExamsDegreeResource;
use App\Http\Resources\HeroesExamResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\PapelSheetResource;
use App\Models\AllExam;
use App\Models\ExamDegreeDepends;
use App\Models\OnlineExam;
use App\Models\OnlineExamUser;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use App\Models\Timer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AllExamsUsersDegreeController extends Controller{


    public function all_exams_details(Request $request){

        $rules = [
            'exam_type' => 'required|in:full_exam,lesson,subject_class,video,papel_sheet'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'exam_type.in' => 407,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,Exam type must be an lesson or video or subject_class or full_exam or papelseheet.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        if($request->exam_type == 'video' || $request->exam_type == 'subject_class' || $request->exam_type == 'lesson') {
            $exam = OnlineExam::where('id', '=', $request->id)->first();
            if (!$exam) {
                return self::returnResponseDataApi(null, "هذا الامتحان غير موجود", 404, 404);
            }

            $details = new OnlineExamResource($exam);

            $users = User::whereHas('exam_degree_depends',function ($degree)use($exam){
                $degree->where('online_exam_id','=',$exam->id);
            })->orderBy(
                ExamDegreeDepends::select('full_degree')
                    ->where('exam_depends','=','yes')
                    // This can vary depending on the relationship
                    ->whereColumn('user_id', 'users.id')
                    ->orderBy('full_degree','desc')
                ,'desc')->take(10)->get();


            $degree_user = ExamDegreeDepends::where('online_exam_id','=',$exam->id)
                ->where('exam_depends','=','yes')
                ->where('user_id','=',auth('user-api')->id())->first()->full_degree ?? 0;



            //start details of timer and mistake
            $timer = Timer::where('user_id','=',auth('user-api')->id())
                ->where('online_exam_id','=',$request->id)->latest()->first();

            $number_mistake = OnlineExamUser::where('user_id','=',auth('user-api')->id())
                ->where('online_exam_id','=',$request->id)
                ->where('status','=','un_correct')
                ->groupBy('online_exam_id')
                ->count();

            $depends = ExamDegreeDepends::where('online_exam_id', '=',$request->id)->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('exam_depends', '=', 'yes')->first();

            $trying = Timer::where('online_exam_id',$request->id)->where('user_id','=',auth('user-api')->id())->count();
            //end details of timer and mistake



        }elseif ($request->exam_type == 'papel_sheet'){

            $exam = PapelSheetExam::where('id','=',$request->id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان الورقي غير موجود",404,404);
            }

            $details = new PapelSheetResource($exam);

            $users = User::whereHas('papel_sheet_exam_degree',function ($degree)use($exam){
                $degree->where('papel_sheet_exam_id','=',$exam->id);
            })->orderBy(
                PapelSheetExamDegree::select('degree')
                    // This can vary depending on the relationship
                    ->whereColumn('user_id', 'users.id')
                    ->orderBy('degree','desc')
                ,'desc')->take(10)->get();

            $degree_user = PapelSheetExamDegree::where('papel_sheet_exam_id','=',$exam->id)
                ->where('user_id','=',auth('user-api')->id())->first()->degree;

            $trying = 0;
            $depends = "";
        }else{

            $exam = AllExam::where('id','=',$request->id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404,404);
            }

            $details = new AllExamResource($exam);


            $users = User::whereHas('exam_degree_depends',function ($degree)use($exam){
                $degree->where('all_exam_id','=',$exam->id);
            })->orderBy(
                ExamDegreeDepends::select('full_degree')
                    ->where('exam_depends','=','yes')
                    // This can vary depending on the relationship
                    ->whereColumn('user_id', 'users.id')
                    ->orderBy('full_degree','desc')
                ,'desc')->take(10)->get();


            $degree_user = ExamDegreeDepends::where('all_exam_id','=',$exam->id)
                ->where('exam_depends','=','yes')
                ->where('user_id','=',auth('user-api')->id())->first()->full_degree ?? 0;


            //start details of timer and mistake
            $timer = Timer::where('user_id','=',auth('user-api')->id())
                ->where('all_exam_id','=',$request->id)->latest()->first();

            $number_mistake = OnlineExamUser::where('user_id','=',auth('user-api')->id())
                ->where('all_exam_id','=',$request->id)
                ->where('status','=','un_correct')
                ->groupBy('all_exam_id')
                ->count();

            $depends = ExamDegreeDepends::where('all_exam_id', '=',$request->id)->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('exam_depends', '=', 'yes')->first();
            $trying = Timer::where('all_exam_id',$request->id)->where('user_id','=',auth('user-api')->id())->count();

            //end details of timer and mistake
        }


        return response()->json([
            'data' => [
                'users' => AllExamsDegreeResource::collection($users),
            ],
            'details' => $details,
            'ordered' => ($key = array_search(auth('user-api')->id(),$users->pluck('id')->toArray()))+1,
            'degree' => $degree_user,
            'timer' => $timer->timer ?? 0,
            'number_mistake' => $number_mistake ?? 0,
            'trying_number_again' => !$depends?((int)$exam->trying_number - (int)$trying) : 0,

        ]);

    }//end method

    public function all_exams_heroes(){



//        $online_exam_count = OnlineExam::whereHas('season', function ($season) {
//            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
//        })->whereHas('term', function ($term) {
//            $term->where('status', '=', 'active');
//        })->whereHas('exam_degree_depends')->count();
//
//
//        $all_exam_count = AllExam::whereHas('season', function ($season) {
//            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
//        })->whereHas('term', function ($term) {
//            $term->where('status', '=', 'active');
//        })->whereHas('exam_degree_depends')->count();
//
//
//
//        $online_exams = OnlineExam::whereHas('season', function ($season) {
//            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
//        })->whereHas('term', function ($term) {
//            $term->where('status', '=', 'active');
//        })->pluck('id')->toArray();
//
//
//        $all_exams = AllExam::whereHas('season', function ($season) {
//            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
//        })->whereHas('term', function ($term) {
//            $term->where('status', '=', 'active');
//        })->pluck('id')->toArray();
////        return $online_exam_count;
//
//
//
//         $user_total_online_exam_count = ExamDegreeDepends::whereIn('online_exam_id',$online_exams)
//             ->where('exam_depends','=','yes')
//             ->where('user_id', '=', auth()->guard('user-api')->id())->count();
//
//        $user_total_all_exam_count = ExamDegreeDepends::whereIn('all_exam_id',$all_exams)
//            ->where('exam_depends','=','yes')
//            ->where('user_id', '=', auth()->guard('user-api')->id())->count();
//
//
//
//
//        $total = $online_exam_count + $all_exam_count;
//        $total_user_exams = $user_total_online_exam_count + $user_total_all_exam_count;


//        if($total == $total_user_exams){
            $users = User::whereHas('exam_degree_depends')->whereHas('season', function ($season) {
                $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
            })->orderBy(
                ExamDegreeDepends::select('full_degree')
                    ->where('exam_depends','=','yes')
                    // This can vary depending on the relationship
                    ->whereColumn('user_id', 'users.id')
                    ->orderBy('full_degree','desc')
                ,'desc')->take(10)->get();

            foreach ($users as $user){
                $user->ordered = ($key = array_search($user->id,$users->pluck('id')->toArray()))+1;
            }

            return response()->json([
                "data" => [
                    "day" => HeroesExamResource::collection($users),
                "week" => HeroesExamResource::collection($users),
                "month" => HeroesExamResource::collection($users),
                ],
                "message" => "تم الحصول علي ابطال الامتحانات بنجاح",
                "code" => 200
            ]);
//        }else{
//
//            return response()->json([
//                "data" => [
//                    "day" => [],
////                "week" => HeroesExamResource::collection($users),
////                "month" => HeroesExamResource::collection($users),
//                ],
//                "message" => "تم الحصول علي ابطال الامتحانات بنجاح",
//                "code" => 200
//            ]);
//        }




//         return $user_total_exam_count;

//         return $total;





    }

}
