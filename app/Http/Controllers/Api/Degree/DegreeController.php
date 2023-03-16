<?php

namespace App\Http\Controllers\Api\Degree;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamDegreeResource;
use App\Http\Resources\OnlineExamDegreeResource;
use App\Http\Resources\PapelSheetExamDegreeResource;
use App\Http\Resources\PapelSheetResource;
use App\Models\AllExam;
use App\Models\Degree;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Models\PapelSheetExam;
use App\Models\SubjectClass;
use Illuminate\Http\Request;

class DegreeController extends Controller{


    public function degrees(){


        $examVideos =  OnlineExam::with(['term'])->whereHas('term', function ($term){
            $term->where('status','=','active');
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)
            ->where('type','=','video')->get();

        $exam_videos_ids = $examVideos->pluck('id')->toArray();
        $degrees = Degree::whereIn('online_exam_id',$exam_videos_ids)->get();
        foreach ($degrees as $degree){
            if($degree->status == 'not_completed'){
                $examVideos = [];
            }
        }

        $lessons_or_subject_classes = OnlineExam::with(['term'])->whereHas('term', function ($term){
            $term->where('status','=','active');
        })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->where('type','=','subject_class')
            ->orWhere('type','=','lesson')->get();


        $lessons_or_subject_classes_ids = $lessons_or_subject_classes->pluck('id')->toArray();
        $degrees_lessons = Degree::whereIn('online_exam_id',$lessons_or_subject_classes_ids)->get();
        foreach ($degrees_lessons as $degrees_lesson){
            if($degrees_lesson->status == 'not_completed'){
                $lessons_or_subject_classes = [];
            }
        }

       $all_exams = AllExam::whereHas('term', function ($term){
           $term->where('status','=','active');
       })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();


        $all_exams_ids = $all_exams->pluck('id')->toArray();
        $degrees_all_exams = Degree::whereIn('all_exam_id',$all_exams_ids)->get();
        foreach ($degrees_all_exams as $degree_all_exam){
            if($degree_all_exam->status == 'not_completed'){
                $all_exams = [];
            }
        }

        $papelSheetExam = PapelSheetExam::where('season_id','=',auth()->guard('user-api')->id())->whereHas('term', function ($term){
            $term->where('status','=','active');
        })->get();

        return response()->json([

           "data" => [
               "videos" => OnlineExamDegreeResource::collection($examVideos),
               "all_exams" => AllExamDegreeResource::collection($all_exams),
               "subject_classes" => OnlineExamDegreeResource::collection($lessons_or_subject_classes),
               "papel_sheet" => PapelSheetExamDegreeResource::collection($papelSheetExam),
           ],
           "message" => "تم الحصول علي جميع درجات الامتحانات التابعه لهذا الطالب بنجاح",
           "code" => 200

       ],200);



    }

}
