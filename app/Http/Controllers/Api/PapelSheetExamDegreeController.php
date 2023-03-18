<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PapelSheetExamUserDegreeResource;
use App\Models\AllExam;
use App\Models\ExamDegreeDepends;
use App\Models\OnlineExam;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamDegree;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PapelSheetExamDegreeController extends Controller{


    public function papelsheet_details(Request $request){

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
                ->where('user_id','=',auth('user-api')->id())->first()->full_degree;

        }elseif ($request->exam_type == 'papel_sheet'){

            $exam = PapelSheetExam::where('id','=',$request->id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان الورقي غير موجود",404,404);
            }


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
        }else{

            $exam = AllExam::where('id','=',$request->id)->first();
            if(!$exam){
                return self::returnResponseDataApi(null,"الامتحان الشامل غير موجود",404,404);
            }


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
                ->where('user_id','=',auth('user-api')->id())->first()->full_degree;

        }



        return response()->json([
            'data' => [
                'users' => PapelSheetExamUserDegreeResource::collection($users),
                'ordered' => ($key = array_search(auth('user-api')->id(),$users->pluck('id')->toArray()))+1,
                'degree' => $degree_user,
            ]

        ]);


    }

}
