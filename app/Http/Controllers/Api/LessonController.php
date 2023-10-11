<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\SubjectClassNewResource;
use App\Http\Resources\VideoDetailsResource;
use App\Http\Resources\VideoOpenedWithStudentNewResource;
use App\Http\Resources\VideoPartNewResource;
use App\Http\Resources\VideoPartResource;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\OpenLesson;
use App\Models\SubjectClass;
use App\Models\VideoBasic;
use App\Models\VideoFilesUploads;
use App\Models\VideoParts;
use App\Models\VideoResource;
use App\Models\VideoOpened;
use App\Models\VideoTotalView;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{


    public function allVideos($id): JsonResponse
    {

        $lesson = Lesson::query()
        ->where('id', '=', $id)
            ->first();

        if (!$lesson) {

            return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
        }

        $videos = VideoParts::query()
        ->where('lesson_id', '=', $id)
            ->orderBy('ordered', 'ASC')
            ->get();

        $videos = VideoPartResource::collection($videos);
        $exams = OnlineExamResource::collection($lesson->exams);

        return self::returnResponseDataApi(compact('videos', 'exams'), "تم ارسال جميع الفيديوهات التابعه للدرس بنجاح ", 200);

    }


    public static function userWatchVideo($video, string $type)
    {

        if ($type == 'video_part') {

        $userWatchVideoBefore = VideoTotalView::query()
            ->where('user_id', '=', Auth::guard('user-api')->id())
            ->where('video_part_id', '=', $video->id)
            ->first();

        } elseif ($type == 'video_basic') {

            $userWatchVideoBefore = VideoTotalView::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('video_basic_id', '=', $video->id)
                ->first();

        } else {
            $userWatchVideoBefore = VideoTotalView::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('video_resource_id', '=', $video->id)
                ->first();
        }

        if (!$userWatchVideoBefore) {
            VideoTotalView::create([
                "user_id" => Auth::guard('user-api')->id(),
                "{$type}_id" => $video->id,
                "count" => 1,
            ]);
        }
    }


    public function videoDetails(Request $request, $id): JsonResponse
    {

        if ($request->type == 'video_part') {

            $video = VideoParts::query()
            ->where('id', '=', $id)
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الشرح غير موجود", 404, 404);
            }

            self::userWatchVideo($video, "video_part");

            return self::returnResponseDataApi(new VideoDetailsResource($video), "تم ارسال تفاصيل الفيديو بنجاح", 200);

        } elseif ($request->type == 'video_basic') {

            $video = VideoBasic::query()
            ->where('id', '=', $id)
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الاساسيات غير موجود", 404, 404);
            }
            self::userWatchVideo($video, "video_basic");
            return self::returnResponseDataApi(new VideoDetailsResource($video), "تم ارسال تفاصيل الفيديو بنجاح", 200);

        } elseif ($request->type == 'video_resource') {

            $video = VideoResource::query()
                ->where('id', '=', $id)
                ->where('type', '=', 'video')
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو المراجعه غير موجود", 404, 404);
            }

            self::userWatchVideo($video, "video_resource");
            return self::returnResponseDataApi(new VideoDetailsResource($video), "تم ارسال تفاصيل الفيديو بنجاح", 200);

        } else {
            return self::returnResponseDataApi(null, "يجب ان يكون النوع من نوع video_basic or video_resource or video_part", 422);

        }

    }

    public function videoComments($id): \Illuminate\Http\JsonResponse
    {

        if (request()->type == 'video_part') {

            $video = VideoParts::query()
            ->where('id', '=', $id)
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الشرح غير موجود", 404, 404);
            }

            $comments = Comment::query()
            ->where('video_part_id', '=', $video->id)
                ->latest()
                ->paginate(4);

            $comments = CommentResource::collection($comments)->response()->getData(true);

        } elseif (request()->type == 'video_basic') {

            $video = VideoBasic::query()
            ->where('id', '=', $id)
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الاساسيات غير موجود", 404, 404);
            }

            $comments = Comment::query()
            ->where('video_basic_id', '=', $video->id)
                ->latest()
                ->paginate(4);

            $comments = CommentResource::collection($comments)->response()->getData(true);

        } elseif (request()->type == 'video_resource') {

            $video = VideoResource::query()->where('id', '=', $id)->where('type', '=', 'video')->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو المراجعه غير موجود", 404, 404);
            }

            $comments = Comment::query()
            ->where('video_resource_id', '=', $video->id)
                ->latest()
                ->paginate(4);

            $comments = CommentResource::collection($comments)->response()->getData(true);

        } else {
            return self::returnResponseDataApi(null, "يجب اختيار نوع الفيديو لجلب التعليقات", 422);

        }

        return response()->json(['comments' => $comments, 'message' => "تم ارسال جميع التعليقات المتعلقه بالفيديو", 'code' => 200], 200);

    }


    public function accessFirstVideo(Request $request, $id): JsonResponse
    {

        $rules = [
            'type' => 'required|in:lesson,subject_class',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an lesson or subject_class',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }


        if ($request->type == 'lesson') {

            $lesson = Lesson::query()
            ->where('id', '=', $id)
                ->first();

            $video = VideoParts::query()
            ->where('lesson_id', '=',$id)
                ->orderBy('id', 'ASC')
                ->first();


            if (!$lesson) {
                return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
            }
            if (!$video) {
                return self::returnResponseDataApi(null, "لا يوجد قائمه فيديوهات لفتح اول فيديو", 404, 404);
            }


            $checkLessonIfOpenedOrClosed = OpenLesson::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('lesson_id', '=', $lesson->id)
                ->exists();

            if($checkLessonIfOpenedOrClosed){
                $videoUploadAllFiles = VideoFilesUploads::query()
                    ->where('video_part_id','=',$video->id)
                    ->get();//List of all pdf and audios of video part


                $watched = VideoOpened::query()
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('video_part_id', '=', $video->id)
                    ->exists();

                if ($watched) {
                    return self::returnResponseDataApi(null,"تم مشاهده هذا الفيديو من قبل",201);

                }elseif(count($video->videoFileUpload) == 0){

                    return self::returnResponseDataApi(null,"ناسف لعدم فتح اول فيديو تابع لهذا الدرس بمتعلقاته لان الفيديو غير مسجل به متعلقات",203);

                } else {

                    VideoOpened::create([
                        'user_id' => Auth::guard('user-api')->id(),
                        'video_part_id' => $video->id,
                        'type' => 'video'
                    ]);

                    foreach ($videoUploadAllFiles as $videoUploadAllFile) {

                        VideoOpened::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'video_upload_file_pdf_id' => $videoUploadAllFile->file_type == 'pdf' ? $videoUploadAllFile->id : null,
                            'video_upload_file_audio_id' => $videoUploadAllFile->file_type == 'audio' ? $videoUploadAllFile->id : null,
                            'type' => $videoUploadAllFile->file_type == 'pdf' ? 'pdf' : 'audio',
                            'status' => 'watched',
                        ]);
                    }

                    return self::returnResponseDataApi(null,"تم فتح اول فيديو بمتعلقاته التابع لهذا الدرس الان",200);

                }//end access first video

            }else{

                return self::returnResponseDataApi(null,"هذا الدرس مغلق الي الان ناسف لعدم فتح اول فيديو بمتعلقاته في هذا الدرس",423);
            }


        } else {

            $subject_class = SubjectClass::query()
            ->first();

            $first_lesson = Lesson::query()
            ->where('subject_class_id', '=', $subject_class->id)
                ->first();

            if (!$subject_class) {
                return self::returnResponseDataApi(null, "لا يوجد فصول برجاء ادخال عدد من الفصول لفتح اول فصل من القائمه", 404, 404);
            }

            if (!$first_lesson) {
                return self::returnResponseDataApi(null, "لا يوجد قائمه دروس لفتح اول درس", 404, 404);
            }

            $subject_class_opened = OpenLesson::query()
            ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('subject_class_id', '=', $subject_class->id);

            $lesson_opened = OpenLesson::query()
            ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('lesson_id', '=', $first_lesson->id);

            if ($subject_class_opened->exists() && $lesson_opened->exists()) {

                return self::returnResponseDataApi(null,"تم فتح اول فصل واول درس تابع لهذا الفصل من قبل",202);

            } else {

                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'subject_class_id' => $subject_class->id,
                ]);

                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'lesson_id' => $first_lesson->id,
                ]);

                return self::returnResponseDataApi(null,"تم فتح اول فصل واول درس تابع لهذا الفصل",202);

            }
        }

    }//end access first subject_class and first lesson and first video and  all files of video

    public function accessNextVideo(Request $request, $id): JsonResponse
    {


        $rules = [
            'type' => 'required|in:video,lesson,subject_class',

        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,

        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an video or lesson or subject_class',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }


        if ($request->type == 'video') {

            $video = VideoParts::query()
            ->where('id', '=', $id)
                ->first();

            if (!$video) {
                return self::returnResponseDataApi(null, "هذا الفيديو او المرفق غير موجود", 404, 404);
            } else {

                $videoOpenedByUser = VideoOpened::query()
                ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('video_part_id', '=', $video->id)
                    ->first();

                if ($videoOpenedByUser) {

                    //sum minutes of video
                    $sumMinutesOfVideo = VideoParts::query()
                        ->where('id','=',$id)
                        ->pluck('video_time')
                        ->toArray();// example 130 seconds

                     //sum watched for user auth in this video
                    $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                        ->where('video_part_id','=',$id)
                        ->where('user_id', '=', Auth::guard('user-api')->id())
                        ->pluck('minutes')
                        ->toArray();//example 120 seconds


                    // total per watched in this video
                    $total = number_format(((getAllSecondsFromTimes($sumAllOfMinutesVideosStudentAuth) / getAllSecondsFromTimes($sumMinutesOfVideo)) * 100),2);

                    if($total < 65.00){

                        return self::returnResponseDataApi(null, "يجب مشاهده 65% من محتوي ذلك الفيديو اولا لفتح الفيديو التالي", 403);

                    }else{

                        $videoOpenedByUser->update(['status' => 'watched']);

                    }

                } else {
                    return self::returnResponseDataApi(null, "يجب فتح الملف السابق", 415, 200);
                }


                $nextFileToWatch = VideoParts::query()
                    ->orderBy('id', 'ASC')
                    ->where('lesson_id', '=',$video->lesson_id)
                    ->orderBy('id', 'ASC')
                    ->get()
                    ->except($videoOpenedByUser->video_part_id)
                    ->where('id', '>', $videoOpenedByUser->video_part_id)
                    ->first();

                if ($nextFileToWatch) {

                        $watched = VideoOpened::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('video_part_id', '=', $nextFileToWatch->id)
                            ->first();

                        if (!$watched) {
                            VideoOpened::create([
                                'user_id' => Auth::guard('user-api')->id(),
                                'video_part_id' => $nextFileToWatch->id,
                            ]);

                            $videoUploadAllFiles = VideoFilesUploads::query()
                                ->where('video_part_id','=',$nextFileToWatch->id)
                                ->get();//List of all pdf and audios of video part

                            foreach ($videoUploadAllFiles as $videoUploadAllFile) {

                                VideoOpened::create([
                                    'user_id' => Auth::guard('user-api')->id(),
                                    'video_upload_file_pdf_id' => $videoUploadAllFile->file_type == 'pdf' ? $videoUploadAllFile->id : null,
                                    'video_upload_file_audio_id' => $videoUploadAllFile->file_type == 'audio' ? $videoUploadAllFile->id : null,
                                    'type' => $videoUploadAllFile->file_type == 'pdf' ? 'pdf' : 'audio',
                                    'status' => 'watched',
                                ]);
                            }

                            return self::returnResponseDataApi(null, "تم اكتمال مشاهده هذا الملف وتم فتح الملف الذي يليه بنجاح", 200);

                        } else {
                            return self::returnResponseDataApi(null, "تم فتح الملف الذي يلي هذا الملف من قبل", 417);
                        }

                } else {

                    return self::returnResponseDataApi(null, "تم الوصول للملف الاخير من هذا النوع للملف", 418);

                }
            }


        } elseif ($request->type == 'lesson') {


            $lesson = Lesson::query()
            ->where('id', '=', $id)
                ->first();

            if (!$lesson) {
                return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
            }

            $opened_lesson = OpenLesson::query()
            ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('lesson_id', '=', $lesson->id)
                ->first();

            $next_lesson = Lesson::query()
            ->orderBy('id', 'ASC')->get()
                ->except($id)
                ->where('id', '>', $id)
                ->first();


            //start sum total of minutes to compare between video minutes and total user watch
            $videosIds = VideoParts::query()
                ->where('lesson_id','=',$lesson->id)
                ->pluck('id')
                 ->toArray();//example [1,2,3,4,5]

            $sumMinutesOfAllVideosBelongsTiThisLesson = VideoParts::query()
                ->where('lesson_id','=',$lesson->id)
                ->pluck('video_time')
                ->toArray();// example 130 seconds

            $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                ->whereIn('video_part_id',$videosIds)
                ->where('user_id', '=', Auth::guard('user-api')->id())
                ->pluck('minutes')
                ->toArray();//example 120 seconds


             $total = number_format(((getAllSecondsFromTimes($sumAllOfMinutesVideosStudentAuth) / getAllSecondsFromTimes($sumMinutesOfAllVideosBelongsTiThisLesson)) * 100),2);

            if ($next_lesson) {

                if($total < 65){

                    return self::returnResponseDataApi(null, "يجب مشاهده 65% من محتوي ذلك الدرس اولا لفتح الدرس التالي", 403);

                }else{

                    $next_lesson_open = OpenLesson::query()
                        ->where('user_id', '=', Auth::guard('user-api')->id())
                        ->where('lesson_id', '=', $next_lesson->id)
                        ->first();

                    if (!$opened_lesson) {
                        return self::returnResponseDataApi(null, "يجب مشاهده الدرس السابق اولا", 500);

                    }
                    if (!$next_lesson_open) {
                        OpenLesson::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'lesson_id' => $next_lesson->id,
                        ]);
                    }

                    return self::returnResponseDataApi(new LessonResource($next_lesson), "تم الوصول الي الدرس التالي", 200);

                }

            } else {
                return self::returnResponseDataApi(null, "تم الوصول للدرس الاخير ولا يوجد اي دروس اخري لفتحها", 500);
            }

        } else {


            $subject_class = SubjectClass::query()
            ->where('id', '=', $id)
                ->first();

            if (!$subject_class) {
                return self::returnResponseDataApi(null, "هذا الفصل غير موجود", 404, 404);
            }


            $opened_subject_class = OpenLesson::query()
            ->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('subject_class_id', '=', $subject_class->id)
                ->first();


            $next_subject_class = SubjectClass::query()
            ->orderBy('id', 'ASC')->get()
                ->except($id)->where('id', '>', $id)
                ->first();


            //start check total watched of student for this subject_class
             $Ids = Lesson::query()
                 ->where('subject_class_id', '=', $subject_class->id)
                 ->pluck('id')->toArray();// ids of lessons belongs to subject class * example [1,2,3,4,5,6]


            $allOfLessons = Lesson::query()
                ->whereIn('id',$Ids)->get();

            $totalOfMinutesVideos = [];
            $totalOfMinutesUserWatched = [];

            foreach ($allOfLessons as $lesson){

                $videosIds = VideoParts::query()
                    ->where('lesson_id','=',$lesson->id)
                    ->pluck('id')
                    ->toArray();//example [1,2,3,4,5]

                $sumMinutesOfAllVideosBelongsTiThisLesson = VideoParts::query()
                    ->where('lesson_id','=',$lesson->id)
                    ->pluck('video_time')
                     ->toArray();// example 20 minutes

                $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                    ->whereIn('video_part_id',$videosIds)
                    ->where('user_id', '=', Auth::guard('user-api')->id())
                    ->pluck('minutes')
                ->toArray();//example 20 minutes

                $totalOfMinutesVideos[] =  $sumMinutesOfAllVideosBelongsTiThisLesson;
                $totalOfMinutesUserWatched[] = $sumAllOfMinutesVideosStudentAuth;

            }


            $total = number_format(((getAllSecondsFromTimes($totalOfMinutesUserWatched) / getAllSecondsFromTimes($totalOfMinutesVideos)) * 100),2);

            if($total < 65){

                return self::returnResponseDataApi(null, "يجب مشاهده 65% من محتوي ذلك الفصل اولا لفتح الفصل التالي", 403);

            }else{
                if ($next_subject_class) {

                    $next_subject_class_open = OpenLesson::query()
                        ->where('user_id', '=', Auth::guard('user-api')->id())
                        ->where('subject_class_id', '=', $next_subject_class->id)
                        ->first();

                    if (!$opened_subject_class) {
                        return self::returnResponseDataApi(null, "يجب مشاهده الوحده السابقه اولا", 500);

                    }
                    if (!$next_subject_class_open) {
                        OpenLesson::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'subject_class_id' => $next_subject_class->id,
                        ]);
                    }

                    return self::returnResponseDataApi(new SubjectClassNewResource($next_subject_class), "تم الوصول الي الدرس التالي", 200);

                } else {
                    return self::returnResponseDataApi(null, "تم الوصول للفصل الاخير ولا يوجد اي فصل اخر لفتحه", 500);
                }
            }

        }//end else condition

    }




    public function updateMinuteVideo(Request $request,$id)
    {

        $rules = ['minutes' => 'required|date_format:H:i:s'];


        $validator = Validator::make($request->all(), $rules, ['minutes.gte' => 406]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The minutes must be greater than or equal 1',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        $video = VideoParts::query()
            ->where('id','=',$id)->first();

        if(!$video){

            return self::returnResponseDataApi(null, "فيديو الشرح غير موجود", 404,404);
        }else{

            $videoOpened = VideoOpened::query()
                ->where('video_part_id','=',$video->id)
                ->first();


            if(!$videoOpened){
                return self::returnResponseDataApi(null, "يجب فتح هذا الفيديو اولا لتحديث المشاهده للطالب", 403,403);

            }else{

                if($request->minutes > $video->video_time){

                    if($video->video_time ==  $videoOpened->minutes){

                        return self::returnResponseDataApi(new VideoOpenedWithStudentNewResource($video), "تم استكمال مشاهده الفيديو من قبل", 420);

                    }else{
                        return self::returnResponseDataApi(new VideoOpenedWithStudentNewResource($video), "عدد الدقائق المدخله بالطلب اكبر من عدد دقائق هذا الفيديو!", 419);
                    }

                }elseif ($video->video_time ==  $videoOpened->minutes){

                    return self::returnResponseDataApi(new VideoOpenedWithStudentNewResource($video), "تم استكمال مشاهده الفيديو من قبل", 420);

                }else{

                    $videoOpened->update(['minutes' => $request->minutes]);



                    /*
                * start update next lesson ==========================================================================================================================
                */


                    $lesson = Lesson::query()
                        ->where('id', '=',$video->lesson_id)
                        ->first();

                    $next_lesson = Lesson::query()
                        ->orderBy('id', 'ASC')->get()
                        ->except($video->lesson_id)
                        ->where('id', '>', $video->lesson_id)
                        ->first();


                    //start sum total of minutes to compare between video minutes and total user watch
                    $videosIds = VideoParts::query()
                        ->where('lesson_id','=',$lesson->id)
                        ->pluck('id')
                        ->toArray();//example [1,2,3,4,5]

                    $sumMinutesOfAllVideosBelongsTiThisLesson = VideoParts::query()
                        ->where('lesson_id','=',$lesson->id)
                        ->pluck('video_time')
                        ->toArray();// example 130 seconds

                    $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                        ->where('minutes','!=',null)
                        ->whereIn('video_part_id',$videosIds)
                        ->where('user_id', '=', Auth::guard('user-api')->id())
                        ->pluck('minutes')
                        ->toArray();//example 120 seconds


                    $totalMinutesOfAllLessons = number_format(((getAllSecondsFromTimes($sumAllOfMinutesVideosStudentAuth) / getAllSecondsFromTimes($sumMinutesOfAllVideosBelongsTiThisLesson)) * 100),2);



                    if ($next_lesson) {

                        if($totalMinutesOfAllLessons >= 65){

                            $next_lesson_open = OpenLesson::query()
                                ->where('user_id', '=', Auth::guard('user-api')->id())
                                ->where('lesson_id', '=', $next_lesson->id)
                                ->first();

                            if (!$next_lesson_open) {
                                OpenLesson::create([
                                    'user_id' => Auth::guard('user-api')->id(),
                                    'lesson_id' => $next_lesson->id,
                                ]);
                            }
                        }
                    }//if find next lesson



                    /*
                      * end update next lesson ==========================================================================================================================
                      */



                    /*
                   * start update next video ==========================================================================================================================
                   */

                        $videoOpenedByUser = VideoOpened::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('video_part_id', '=', $video->id)
                            ->first();

                        if ($videoOpenedByUser) {

                            $sumMinutesOfVideo = VideoParts::query()
                                ->where('id','=',$id)
                                ->pluck('video_time')
                                ->toArray();// example 130 seconds


                            $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                                ->where('video_part_id','=',$id)
                                ->where('user_id', '=', Auth::guard('user-api')->id())
                                ->pluck('minutes')
                                ->toArray();//example 120 seconds



                            $totalMinutesOfAllVideos = number_format(((getAllSecondsFromTimes($sumAllOfMinutesVideosStudentAuth) / getAllSecondsFromTimes($sumMinutesOfVideo)) * 100),2);


                            if($totalMinutesOfAllVideos >= 65){

                                $videoOpenedByUser->update(['status' => 'watched']);

                                $nextFileToWatch = VideoParts::query()
                                    ->orderBy('id', 'ASC')
                                    ->where('lesson_id', '=',$video->lesson_id)
                                    ->orderBy('id', 'ASC')
                                    ->get()
                                    ->except($videoOpenedByUser->video_part_id)
                                    ->where('id', '>', $videoOpenedByUser->video_part_id)
                                    ->first();

                                if ($nextFileToWatch) {

                                    $watched = VideoOpened::query()
                                        ->where('user_id', '=', Auth::guard('user-api')->id())
                                        ->where('video_part_id', '=', $nextFileToWatch->id)
                                        ->first();

                                    if (!$watched) {
                                        VideoOpened::create([
                                            'user_id' => Auth::guard('user-api')->id(),
                                            'video_part_id' => $nextFileToWatch->id,
                                        ]);

                                        $videoUploadAllFiles = VideoFilesUploads::query()
                                            ->where('video_part_id','=',$nextFileToWatch->id)
                                            ->get();//List of all pdf and audios of video part

                                        foreach ($videoUploadAllFiles as $videoUploadAllFile) {

                                            VideoOpened::create([
                                                'user_id' => Auth::guard('user-api')->id(),
                                                'video_upload_file_pdf_id' => $videoUploadAllFile->file_type == 'pdf' ? $videoUploadAllFile->id : null,
                                                'video_upload_file_audio_id' => $videoUploadAllFile->file_type == 'audio' ? $videoUploadAllFile->id : null,
                                                'type' => $videoUploadAllFile->file_type == 'pdf' ? 'pdf' : 'audio',
                                                'status' => 'watched',
                                            ]);
                                        }
                                    }//end if

                                } else {

                                    return self::returnResponseDataApi(new VideoOpenedWithStudentNewResource($video), "تم تحديث وقت هذا الفيديو وتم الوصول للملف الاخير للدرس التابع له الفيديو", 418);

                                }

                            }

                        } else {

                            return self::returnResponseDataApi(null, "يجب فتح الملف السابق", 415, 200);
                        }




                    /*
                   * end update next video ==========================================================================================================================
                   */




                /*
              * start update next subject_class ==========================================================================================================================
              */

                    $idOfSubjectClass =  $video->lesson->subject_class_id;


                    $subject_class = SubjectClass::query()
                        ->where('id', '=', $idOfSubjectClass)
                        ->first();


                    $next_subject_class = SubjectClass::query()
                        ->orderBy('id', 'ASC')->get()
                        ->except( $idOfSubjectClass)->where('id', '>', $idOfSubjectClass)
                        ->first();


                    $Ids = Lesson::query()
                        ->where('subject_class_id', '=', $subject_class->id)
                        ->pluck('id')
                        ->toArray();// ids of lessons belongs to subject class * example [1,2,3,4,5,6]


                    $allOfLessons = Lesson::query()
                        ->whereIn('id',$Ids)->get();

                    $totalOfMinutesVideos = [];
                    $totalOfMinutesUserWatched = [];


                    foreach ($allOfLessons as $lesson){

                        $videosIds = VideoParts::query()
                            ->where('lesson_id','=',$lesson->id)
                            ->pluck('id')
                            ->toArray();//example [1,2,3,4,5]

                        $sumMinutesOfAllVideosBelongsTiThisLesson = VideoParts::query()
                            ->where('lesson_id','=',$lesson->id)
                            ->pluck('video_time')
                            ->toArray();// example 20 minutes


                        $sumAllOfMinutesVideosStudentAuth = VideoOpened::query()
                            ->where('minutes','!=',null)
                            ->whereIn('video_part_id',$videosIds)
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->pluck('minutes')
                            ->toArray();//example 20 minutes


                        $totalOfMinutesVideos[] =  $sumMinutesOfAllVideosBelongsTiThisLesson;
                        $totalOfMinutesUserWatched[] = $sumAllOfMinutesVideosStudentAuth;

                    }


                    $listOfSecondsOfAllVideos = [];
                    for ($i = 0 ; $i < count($totalOfMinutesVideos);$i++){

                        $listOfSecondsOfAllVideos[] = getAllSecondsFromTimes($totalOfMinutesVideos[$i]);

                    }


                    $listOfSecondsOfAllVideosWatched = [];
                    for ($i = 0 ; $i <  sizeof(array_filter($totalOfMinutesUserWatched));$i++){

                        $listOfSecondsOfAllVideosWatched[] = getAllSecondsFromTimes($totalOfMinutesUserWatched[$i]);

                    }


                    $totalMinutesOfAllClasses =  number_format(((array_sum($listOfSecondsOfAllVideosWatched) / array_sum($listOfSecondsOfAllVideos)) * 100),2);


                    if($totalMinutesOfAllClasses >= 65){

                        if ($next_subject_class) {

                            $next_subject_class_open = OpenLesson::query()
                                ->where('user_id', '=', Auth::guard('user-api')->id())
                                ->where('subject_class_id', '=', $next_subject_class->id)
                                ->first();


                            if (!$next_subject_class_open) {
                                OpenLesson::create([
                                    'user_id' => Auth::guard('user-api')->id(),
                                    'subject_class_id' => $next_subject_class->id,
                                ]);
                            }

                        }
                    }

                    return self::returnResponseDataApi(new VideoOpenedWithStudentNewResource($video), "تم تحديث عدد دقائق الفيديو بنجاح", 200);


                    /*
                    * end update next subject_class ==========================================================================================================================
                    */



                }

            }

        }//end else

    }//end function





}
