<?php

namespace App\Http\Controllers\Api\SubjectClass;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\LessonNewResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\SubjectClassAllExamResource;
use App\Http\Resources\SubjectClassNewResource;
use App\Models\AllExam;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\SubjectClass;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class SubjectClassController extends Controller
{
    public function allClasses()
    {


        try {

            $classes = SubjectClass::whereHas('term', function ($term) {

                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->get();

            //            $fullExams = AllExam::whereHas('term', function ($term){
            //
            //                $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
            //            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();


            $subject_classes_all_exams = SubjectClass::whereHas('term', function ($term) {

                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->whereHas('all_exams')->get();


            return response()->json([

                'data' => [
                    'subject_class' => SubjectClassNewResource::collection($classes),
                    //                     'fullExams' => AllExamResource::collection($fullExams),
                    'classes_all_exams' => SubjectClassAllExamResource::collection($subject_classes_all_exams),

                    'code' => 200,
                    'message' => "تم الحصول علي جميع الدروس التابعه لهذا الفصل",
                ]
            ]);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function lessonsByClassId($id): JsonResponse
    {

        try {
            $user = studentAuth();
            $class = SubjectClass::query()
                ->where('id', $id)
                ->whereHas(
                    'lessons.videos',
                    function (Builder $builder) use ($user) {
                        $builder->whereIn('month', json_decode($user->subscription_months_groups));
                    }
                )->with(['lessons' => function ($query) use ($user) {
                    // Include only lessons that have videos in the same month as the subscription
                    $query->whereHas('videos', function (Builder $builder) use ($user) {
                        $builder->whereIn('month', json_decode($user->subscription_months_groups));
                    });
                }])->first();

            if (!$class) {
                return self::returnResponseDataApi(null, "هذا الفصل غير موجود", 404);
            }

            return response()->json([
                'data' => [
                    'class' => new SubjectClassNewResource($class),
                    'lessons' => LessonNewResource::collection($class->lessons),
                ],
                'code' => 200,
                'message' => "تم الحصول على جميع الدروس التابعة لهذا الفصل",
            ]);
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }
}
