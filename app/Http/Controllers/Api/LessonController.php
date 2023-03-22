<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AudioResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\PdfUploadResource;
use App\Http\Resources\SubjectClassResource;
use App\Http\Resources\VideoPartResource;
use App\Models\Audio;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\OpenLesson;
use App\Models\PdfFileUpload;
use App\Models\SubjectClass;
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


    public function accessFirstVideo(Request $request,$id){

        $rules = [
            'type' => 'required|in:video,subject_class',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an video or open_app or subject_class',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }


        if($request->type == 'video'){
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

            //end access first video
        }else{

            $subject_class = SubjectClass::first();
            $first_lesson = Lesson::where('subject_class_id','=',$subject_class->id)->first();

            if(!$subject_class){
                return self::returnResponseDataApi(null,"لا يوجد فصول برجاء ادخال عدد من الفصول لفتح اول فصل من القائمه",404,404);
            }

            if(!$first_lesson){
                return self::returnResponseDataApi(null,"لا يوجد قائمه دروس لفتح اول درس",404,404);
            }

            $subject_class_opened = OpenLesson::where('user_id','=',Auth::guard('user-api')->id())->where('subject_class_id','=',$subject_class->id);
            $lesson_opened = OpenLesson::where('user_id','=',Auth::guard('user-api')->id())->where('lesson_id','=',$first_lesson->id);

            if($subject_class_opened->exists() &&  $lesson_opened->exists()){
                return response()->json(['data' => null,'message' => 'تم فتح اول فصل واول درس تابع لهذا الفصل من قبل','code' => 201]);

            }else{
                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'subject_class_id' =>  $subject_class->id,
                ]);

                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'lesson_id' =>  $first_lesson->id,
                ]);

                return response()->json(['data' => null,'message' => 'تم فتح اول فصل واول درس تابع لهذا الفصل ','code' => 200]);
            }

            //end open first video =============================================================================================================


        }

    }

    public function accessNextVideo(Request $request,$id)
    {

        $rules = [
            'type' => 'required|in:video,lesson,subject_class',
            'status' => 'required|in:watched',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,
            'status.in' => 407,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an video or lesson or subject_class',
                    407 => 'Failed,The Video or file must be an updated keyword watched.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }



        if($request->type == 'video'){
            $video = VideoParts::where('id', '=', $id)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "هذا الفيديو او المرفق غير موجود", 404, 404);
            }

            //update first video to watched
            $watched = VideoWatch::where('user_id', '=', Auth::guard('user-api')->id())->where('video_part_id', '=',$video->id)->first();
            if ($watched) {
                $watched->update(['status' => $request->status]);
            } else {
                return self::returnResponseDataApi(null, "يجب مشاهده الفيديو السابق اولا", 500);
            }

            //access next video and show second file or video or audio
            $all_video_watches = VideoParts::select("id")->orderBy('ordered', 'ASC')->whereHas('watches', function ($watches) {
                $watches->where('user_id', '=', Auth::guard('user-api')->id())->where('status', '=', 'watched');
            })->get();


            $ids = [];
            foreach ($all_video_watches as $all_video_watch) {
                $ids[] = $all_video_watch->id;
            }
            if (isset($watched)) {

                $next_videos = VideoParts::where('lesson_id', '=', $video->lesson_id)->orderBy('ordered', 'ASC')->whereNotIn('id', $ids)->get();
                foreach ($next_videos as $next_video) {
                    $next_video_watched = VideoWatch::where('user_id', '=', Auth::guard('user-api')->id())->where('video_part_id', '=', $next_video->id)->first();
                    if (!$next_video_watched) {
                        if ($next_video->type == 'pdf' || $next_video->type == 'audio') {
                            VideoWatch::create([
                                'user_id' => Auth::guard('user-api')->id(),
                                'video_part_id' => $next_video->id,
                                'status' => 'watched'
                            ]);

                        } else {
                            VideoWatch::create([
                                'user_id' => Auth::guard('user-api')->id(),
                                'video_part_id' => $next_video->id,
                            ]);
                            break;
                        }
                    }else{
                        return self::returnResponseDataApi(null, "تم فتح الفيديو الذي يلي هذا الفيديو من قبل برجي الانتهاء منه اولا للدخول للفيديو التالي", 200);

                    }

                }

            } else {
                return self::returnResponseDataApi(null, "Error in update", 500);
            }

            if(isset($next_video))
                return self::returnResponseDataApi(new VideoPartResource($next_video),"تم الوصول الي الفيديو التالي",200);
            else
                return self::returnResponseDataApi(null,"تم الوصول للملف الاخير ولا يوجد اي ملفات اخري لفتحها",500);

        }elseif ($request->type == 'lesson') {

            $lesson = Lesson::where('id', '=', $id)->first();
            if (!$lesson) {
                return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
            }


            $opened_lesson = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('lesson_id', '=',$lesson->id)->first();
            $next_lesson = Lesson::orderBy('id','ASC')->get()->except($id)->where('id','>',$id)->first();
            if($next_lesson){
                $next_lesson_open = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('lesson_id', '=',$next_lesson->id)->first();

                if(!$opened_lesson){
                    return self::returnResponseDataApi(null, "يجب مشاهده الدرس السابق اولا", 500);

                }
                if(!$next_lesson_open){
                    OpenLesson::create([
                        'user_id' => Auth::guard('user-api')->id(),
                        'lesson_id' => $next_lesson->id,
                    ]);
                }

                return self::returnResponseDataApi(new LessonResource($next_lesson),"تم الوصول الي الدرس التالي",200);

            } else{
                return self::returnResponseDataApi(null,"تم الوصول للدرس الاخير ولا يوجد اي دروس اخري لفتحها",500);
            }

        }else{

            $subject_class = SubjectClass::where('id', '=', $id)->first();
            if (!$subject_class) {
                return self::returnResponseDataApi(null, "هذا الفصل غير موجود", 404, 404);
            }


            $opened_subject_class = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('subject_class_id', '=',$subject_class->id)->first();
            $next_subject_class = SubjectClass::orderBy('id','ASC')->get()->except($id)->where('id','>',$id)->first();
            if($next_subject_class){
                $next_subject_class_open = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('subject_class_id', '=',$next_subject_class->id)->first();

                if(!$opened_subject_class){
                    return self::returnResponseDataApi(null, "يجب مشاهده الوحده السابقه اولا", 500);

                }
                if(!$next_subject_class_open){
                    OpenLesson::create([
                        'user_id' => Auth::guard('user-api')->id(),
                        'subject_class_id' => $next_subject_class->id,
                    ]);
                }

                return self::returnResponseDataApi(new SubjectClassResource($next_subject_class),"تم الوصول الي الدرس التالي",200);

            } else{
                return self::returnResponseDataApi(null,"تم الوصول للفصل الاخير ولا يوجد اي فصل اخر لفتحه",500);
            }
        }//end else condition

    }
}
