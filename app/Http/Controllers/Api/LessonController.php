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
use App\Models\VideoWatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller{


    public function allVideos($id){


        $lesson = Lesson::where('id','=',$id)->first();
        if(!$lesson){

            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }

        $videos = VideoParts::where('lesson_id','=',$id)->orderBy('ordered','ASC')->get();
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


    public function accessFirstVideo($id){

        $lesson = Lesson::where('id','=',$id)->first();
        $video = VideoParts::where('lesson_id','=',$id)->orderBy('ordered','ASC')->first();

        if(!$lesson){
            return self::returnResponseDataApi(null,"هذا الدرس غير موجود",404,404);
        }
        if(!$video){
            return self::returnResponseDataApi(null,"لا يوجد قائمه فيديوهات لفتح اول فيديو",404,404);
        }
        $watched = VideoWatch::where('user_id','=',Auth::guard('user-api')->id())->where('video_part_id','=',$video->id);
        if($watched->exists()){
            return response()->json(['data' => null,'message' => 'Video watched with ' . Auth::guard('user-api')->user()->name . ' before','code' => 200]);

        }else{

            $watch = VideoWatch::create([
                'user_id' => Auth::guard('user-api')->id(),
                'video_part_id' =>  $video->id,
            ]);

            return response()->json(['data' => $watch,'message' => 'Video opened now  ' . Auth::guard('user-api')->user()->name,'code' => 200]);
        }

    }

    public function accessNextVideo(Request $request,$id){

        $rules = [
            'status' => 'required|in:watched',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'status.in' => 407,
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The Video or file must be an updated keyword watched.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null,$validator->errors()->first(),422);
        }
        $video = VideoParts::where('id','=',$id)->first();
        if(!$video){
            return self::returnResponseDataApi(null,"هذا الفيديو او المرفق غير موجود",404,404);
        }

        //update first video to watched

        $watched = VideoWatch::where('user_id','=',Auth::guard('user-api')->id())->where('video_part_id','=',$video->id)->first();
        if($watched){
            $watched->update(['status' => $request->status]);
        }else{
            return self::returnResponseDataApi(null,"يجب مشاهده الفيديو السابق اولا",500);
        }


        //access next video and show second file or video or audio
        $all_video_watches = VideoParts::select("id")->orderBy('ordered','ASC')->whereHas('watches', function ($watches){
            $watches->where('user_id','=',Auth::guard('user-api')->id())->where('status','=','watched');
        })->get();


        $ids = [];
        foreach ($all_video_watches as $all_video_watch){
            $ids[] = $all_video_watch->id;
        }
            if(isset($watched)){
                $next_video = VideoParts::where('lesson_id','=',$video->lesson_id)->orderBy('ordered','ASC')->whereNotIn('id',$ids)->first();
                if($next_video){
                    $next_video_watched = VideoWatch::where('user_id','=',Auth::guard('user-api')->id())->where('video_part_id','=',$next_video->id)->first();
                    if(!$next_video_watched){
                        VideoWatch::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'video_part_id' => $next_video->id,
                        ]);
                    }
                }else{
                    return self::returnResponseDataApi(null,"تم الوصول للملف الاخير ولا يوجد اي ملفات اخري لفتحها",500);
                }
            }else{
                return self::returnResponseDataApi(null,"Error in update",500);
            }
            return self::returnResponseDataApi(new VideoPartResource($next_video),"تم الوصول الي الفيديو التالي",200);



    }
}
