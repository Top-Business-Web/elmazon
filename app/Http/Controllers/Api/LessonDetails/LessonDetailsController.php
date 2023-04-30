<?php

namespace App\Http\Controllers\Api\LessonDetails;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineExamNewResource;
use App\Http\Resources\VideoPartOnlineExamsResource;
use App\Http\Resources\VideoUploadFileDetailsResource;
use App\Http\Resources\VideoPartDetailsNewResource;
use App\Models\Lesson;
use App\Models\OnlineExam;
use App\Models\VideoFilesUploads;
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

    public function allPdfByVideoId($id): JsonResponse{

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){

            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        $allPdf = VideoFilesUploads::query()->where('video_part_id','=',$video->id)->where('file_type','=','pdf')->get();

        return self::returnResponseDataApi(VideoUploadFileDetailsResource::collection($allPdf),"تم الحصول علي جميع ملخصات الشرح بنجاح",200);


    }


    public function allAudiosByVideoId($id): JsonResponse{

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){

            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        $allAudios = VideoFilesUploads::query()->where('video_part_id','=',$video->id)->where('file_type','=','audio')->get();

        return self::returnResponseDataApi(VideoUploadFileDetailsResource::collection($allAudios),"تم الحصول علي جميع الملفات الصوتيه بنجاح",200);


    }

      public function allExamsByVideoId($id): JsonResponse{

          $video = VideoParts::where('id','=',$id)->first();
          if(!$video){

              return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
          }

          $allExams = OnlineExam::query()->where('video_id','=',$video->id)->get();

          return self::returnResponseDataApi(VideoPartOnlineExamsResource::collection($allExams),"تم الحصول علي جميع امتحانات الفيديو بنجاح",200);


      }

    public function allExamsByLessonId($id): JsonResponse{

        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $allExams = OnlineExam::query()->where('lesson_id','=',$lesson->id)->get();

        return self::returnResponseDataApi(OnlineExamNewResource::collection($allExams),"تم الحصول علي جميع امتحانات الدرس بنجاح",200);


    }


    public function examDetailsByExamId($id): JsonResponse{

        return response()->json(['data' => null]);

    }

}
