<?php

namespace App\Http\Controllers\Api\ExamYourselfTest;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesWithLessonsResource;
use App\Http\Resources\TextYourselfExamResource;
use App\Models\ExamsFavorite;
use App\Models\Lesson;
use App\Models\SubjectClass;
use App\Models\TestYourselfExams;
use App\Models\TextExamUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TestYourselfExamsController extends Controller{


   public function makeExam(Request $request): JsonResponse{

       try {
           $rules = [
               'questions_type' => 'required|in:low,mid,high',
               'lesson_id' => 'nullable|exists:lessons,id',
               'subject_class_id' => 'nullable|exists:subject_classes,id',
               'total_time' => 'required|integer',
               'num_of_questions' => 'required|integer',
           ];
           $validator = Validator::make($request->all(), $rules, [
               'questions_type.in' => 407,
               'lesson_id.exists' => 408,
               'subject_class_id.exists' => 409,

           ]);

           if ($validator->fails()) {
               $errors = collect($validator->errors())->flatten(1)[0];
               if (is_numeric($errors)) {

                   $errors_arr = [
                       407 => 'Failed,The questions type must be low or mid or high',
                       408 => 'Failed,The lesson does not exists',
                       409 => 'Failed,The subject_class does not exists',
                   ];

                   $code = collect($validator->errors())->flatten(1)[0];
                   return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
               }
               return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
           }

           if ($request->lesson_id == null && $request->subject_class_id == null) {

               return self::returnResponseDataApi(null, "يجب تسجيل الامتحان تبع درس معين او فصل معين", 422);
           }


           if($request->lesson_id != null){

               $lesson = Lesson::query()->where('id','=',$request->lesson_id)->first();
               $questions_count = $lesson->questions()->where('difficulty','=',$request->questions_type)->count();

             if ($questions_count == 0){

                   return self::returnResponseDataApi(null, "هذا الدرس لا يوجد به اسئله", 418);

               }  elseif($request->num_of_questions > $questions_count){

                 return self::returnResponseDataApi(null, "عدد اسئله الدرس اقل من العدد الذي تريد ان تضيفه للامتحان", 417);

             }
           }elseif ($request->subject_class_id != null){

               $class = SubjectClass::query()->where('id','=',$request->subject_class_id)->first();
               $questions_count = $class->questions()->where('difficulty','=',$request->questions_type)->count();
              if ($questions_count == 0){

                   return self::returnResponseDataApi(null, "هذا الفصل لا يوجد به اسئله", 418);
               } elseif($request->num_of_questions > $questions_count){

                  return self::returnResponseDataApi(null, "عدد اسئله الفصل اقل من العدد الذي تريد ان تضيفه للامتحان", 417);

              }
           }

           $makeExam = TestYourselfExams::create([
               'questions_type' => $request->questions_type,
               'user_id' => Auth::guard('user-api')->id(),
               'lesson_id' => $request->lesson_id ?? null,
               'subject_class_id' => $request->subject_class_id ?? null,
               'total_time' => $request->total_time,
               'num_of_questions' => $request->num_of_questions
           ]);

           if($makeExam->save()) {
               return self::returnResponseDataApi(new TextYourselfExamResource($makeExam), "تم تسجيل بيانات الامتحان بنجاح", 200);
           }else{
               return self::returnResponseDataApi(null,"يوجد خطاء بتسجيل البيانات برجاء الرجوع لمطور الباك اند", 500);

           }

       } catch (\Exception $exception) {

           return self::returnResponseDataApi(null, $exception->getMessage(), 500);
       }

   }


   public function examQuestions($id): JsonResponse{

       $testYourselfExam = TestYourselfExams::find($id);
       if(!$testYourselfExam){

           return self::returnResponseDataApi(null, "الامتحان غير موجود", 404);
       }elseif ($testYourselfExam->user_id != Auth::guard('user-api')->id()){

           return self::returnResponseDataApi(null, "غير مصرح لك بمشاهده تفاصيل هذا الامتحان لانه مسجل من قبل طالب اخر", 403);

       } else{

           return self::returnResponseDataApi(new TextYourselfExamResource($testYourselfExam), "تم جلب عدد الاسئله للامتحان", 200);
       }

   }


   public function allClassesWithLessons(): JsonResponse{

       $subjectClasses = SubjectClass::with('lessons:id,name_ar,name_en,subject_class_id')->whereHas('term', function ($term){
           $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
       })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->select('id','name_ar','name_en','image')->get();


       return self::returnResponseDataApi(ClassesWithLessonsResource::collection($subjectClasses),"تم الحصول علي جميع بيانات الفصول والدروس بنجاح",200);
   }


    public function solveExam($id): JsonResponse{

        return self::returnResponseDataApi(null,"The Api work successfully",200);
    }
}
