<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AudioResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\PdfUploadResource;
use App\Http\Resources\VideoPartResource;
use App\Models\Audio;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\PdfFileUpload;
use App\Models\VideoParts;

class LessonController extends Controller{


    public function allVideos($id){


        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $videos = VideoParts::where('lesson_id','=',$id)->get();
        $videos = VideoPartResource::collection($videos);
        $exams =  OnlineExamResource::collection($lesson->exams);
        return self::returnResponseDataApi(compact('videos','exams'),"تم ارسال جميع الفيديوهات التابعه للدرس بنجاح ",200);

    }

    public function allPdf($id){


        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $allPdf = PdfFileUpload::where('lesson_id','=',$id)->get();

        return self::returnResponseDataApi(PdfUploadResource::collection($allPdf),"تم ارسال جميع ملفات ال pdf التابعه للدرس بنجاح ",200);

    }

    public function allAudios($id){
        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $allAudios = Audio::where('lesson_id','=',$id)->get();

        return self::returnResponseDataApi(AudioResource::collection($allAudios),"تم ارسال جميع الملفات الصوتيه التابعه للدرس بنجاح ",200);


    }

    public function videoDetails($id){

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){

            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        return self::returnResponseDataApi(new VideoPartResource($video),"تم ارسال تفاصيل الفيديو بنجاح",200);

    }

    public function videoComments($id){

        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){

            return self::returnResponseDataApi(null,"هذا الفيديو غير موجود",404,404);
        }

        $comments = Comment::where('video_part_id','=',$id)->latest()->paginate(4);
        $comments = CommentResource::collection($comments)->response()->getData(true);

        return response()->json(['comments' => $comments, 'message' => "تم ارسال جميع التعليقات المتعلقه بالفيديو", 'code' => 200],200);

    }
}
