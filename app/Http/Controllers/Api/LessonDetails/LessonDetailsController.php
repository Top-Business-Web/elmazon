<?php

namespace App\Http\Controllers\Api\LessonDetails;

use App\Http\Controllers\Controller;
use App\Http\Resources\PdfDetailsNewResource;
use App\Http\Resources\VideoPartDetailsNewResource;
use App\Models\Lesson;
use App\Models\VideoParts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonDetailsController extends Controller{


    public function allVideoByLessonId($id): JsonResponse{

        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $videos = VideoParts::query()->where('lesson_id','=',$lesson->id)->where('type','=','video')->get();

        return self::returnResponseDataApi(VideoPartDetailsNewResource::collection($videos),"تم الحصول علي جميع فيديوهات الشرح بنجاح",200);

    }

    public function allPdfByLessonId($id): JsonResponse{

        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $videos = VideoParts::query()->where('lesson_id','=',$lesson->id)->where('type','=','pdf')->get();

        return self::returnResponseDataApi(PdfDetailsNewResource::collection($videos),"تم الحصول علي جميع ملخصات الشرح بنجاح",200);


    }


    public function allAudiosByLessonId($id): JsonResponse{

        return response()->json(['data' => null]);


    }

      public function allExamsByLessonId($id): JsonResponse{

          return response()->json(['data' => null]);

    }


    public function examDetailsByExamId($id): JsonResponse{

        return response()->json(['data' => null]);

    }

}
