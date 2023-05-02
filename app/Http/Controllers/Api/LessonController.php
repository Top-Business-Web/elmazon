<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\OnlineExamResource;
use App\Http\Resources\SubjectClassNewResource;
use App\Http\Resources\VideoDetailsResource;
use App\Http\Resources\VideoPartResource;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\OpenLesson;
use App\Models\SubjectClass;
use App\Models\VideoBasic;
use App\Models\VideoParts;
use App\Models\VideoResource;
use App\Models\VideoOpened;
use App\Models\VideoTotalView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{


    public function allVideos($id): \Illuminate\Http\JsonResponse
    {


        $lesson = Lesson::where('id', '=', $id)->first();
        if (!$lesson) {

            return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
        }

        $videos = VideoParts::where('lesson_id', '=', $id)->orderBy('ordered', 'ASC')->get();
        $videos = VideoPartResource::collection($videos);
        $exams = OnlineExamResource::collection($lesson->exams);
        return self::returnResponseDataApi(compact('videos', 'exams'), "تم ارسال جميع الفيديوهات التابعه للدرس بنجاح ", 200);

    }


    public static function userWatchVideo($video, string $type)
    {

        if ($type == 'video_part') {
            $userWatchVideoBefore = VideoTotalView::query()->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('video_part_id', '=', $video->id)->first();

        } elseif ($type == 'video_basic') {

            $userWatchVideoBefore = VideoTotalView::query()->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('video_basic_id', '=', $video->id)->first();

        } else {
            $userWatchVideoBefore = VideoTotalView::query()->where('user_id', '=', Auth::guard('user-api')->id())
                ->where('video_resource_id', '=', $video->id)->first();
        }

        if (!$userWatchVideoBefore) {
            VideoTotalView::create([
                "user_id" => Auth::guard('user-api')->id(),
                "{$type}_id" => $video->id,
                "count" => 1,
            ]);
        }
    }


    public function videoDetails(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        if ($request->type == 'video_part') {
            $video = VideoParts::where('id', '=', $id)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الشرح غير موجود", 404, 404);
            }

            self::userWatchVideo($video, "video_part");

            return self::returnResponseDataApi(new VideoDetailsResource($video), "تم ارسال تفاصيل الفيديو بنجاح", 200);

        } elseif ($request->type == 'video_basic') {

            $video = VideoBasic::where('id', '=', $id)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الاساسيات غير موجود", 404, 404);
            }
            self::userWatchVideo($video, "video_basic");
            return self::returnResponseDataApi(new VideoDetailsResource($video), "تم ارسال تفاصيل الفيديو بنجاح", 200);

        } elseif ($request->type == 'video_resource') {

            $video = VideoResource::query()->where('id', '=', $id)->where('type', '=', 'video')->first();
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
            $video = VideoParts::where('id', '=', $id)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الشرح غير موجود", 404, 404);
            }

            $comments = Comment::where('video_part_id', '=', $video->id)->latest()->paginate(4);
            $comments = CommentResource::collection($comments)->response()->getData(true);

        } elseif (request()->type == 'video_basic') {

            $video = VideoBasic::where('id', '=', $id)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو الاساسيات غير موجود", 404, 404);
            }

            $comments = Comment::where('video_basic_id', '=', $video->id)->latest()->paginate(4);
            $comments = CommentResource::collection($comments)->response()->getData(true);

        } elseif (request()->type == 'video_resource') {

            $video = VideoResource::query()->where('id', '=', $id)->where('type', '=', 'video')->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "فيديو المراجعه غير موجود", 404, 404);
            }

            $comments = Comment::where('video_resource_id', '=', $video->id)->latest()->paginate(4);
            $comments = CommentResource::collection($comments)->response()->getData(true);

        } else {
            return self::returnResponseDataApi(null, "يجب اختيار نوع الفيديو لجلب التعليقات", 422);

        }

        return response()->json(['comments' => $comments, 'message' => "تم ارسال جميع التعليقات المتعلقه بالفيديو", 'code' => 200], 200);

    }


    public function accessFirstVideo(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $rules = [
            'type' => 'required|in:file,subject_class',
            'file_type' => 'nullable|in:video,pdf,audio',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,
            'file_type.in' => 407,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an video or subject_class',
                    407 => 'Failed,The file type must be an video or audio or pdf',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }


        if ($request->type == 'file') {
            $lesson = Lesson::where('id', '=', $id)->first();
            $video = VideoParts::where('lesson_id', '=', $id)->where('type', '=', $request->file_type)->orderBy('id', 'ASC')->first();

            if (!$lesson) {
                return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
            }
            if (!$video) {
                return self::returnResponseDataApi(null, "لا يوجد قائمه فيديوهات لفتح اول فيديو", 404, 404);
            }
            $watched = VideoOpened::where('user_id', '=', Auth::guard('user-api')->id())->where('video_part_id', '=', $video->id);
            if ($watched->exists()) {
                return response()->json(['data' => null, 'message' => 'Video watched with ' . Auth::guard('user-api')->user()->name . ' before', 'code' => 200]);

            } else {

                $watch = VideoOpened::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'video_part_id' => $video->id,
                ]);

                return response()->json(['data' => $watch, 'message' => 'Video opened now  ' . Auth::guard('user-api')->user()->name, 'code' => 200]);
            }

            //end access first video
        } else {

            $subject_class = SubjectClass::first();
            $first_lesson = Lesson::where('subject_class_id', '=', $subject_class->id)->first();

            if (!$subject_class) {
                return self::returnResponseDataApi(null, "لا يوجد فصول برجاء ادخال عدد من الفصول لفتح اول فصل من القائمه", 404, 404);
            }

            if (!$first_lesson) {
                return self::returnResponseDataApi(null, "لا يوجد قائمه دروس لفتح اول درس", 404, 404);
            }

            $subject_class_opened = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('subject_class_id', '=', $subject_class->id);
            $lesson_opened = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('lesson_id', '=', $first_lesson->id);

            if ($subject_class_opened->exists() && $lesson_opened->exists()) {
                return response()->json(['data' => null, 'message' => 'تم فتح اول فصل واول درس تابع لهذا الفصل من قبل', 'code' => 201]);

            } else {
                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'subject_class_id' => $subject_class->id,
                ]);

                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'lesson_id' => $first_lesson->id,
                ]);

                return response()->json(['data' => null, 'message' => 'تم فتح اول فصل واول درس تابع لهذا الفصل ', 'code' => 200]);
            }

            //end open first video =============================================================================================================


        }

    }

    public function accessNextVideo(Request $request, $id)
    {


        $rules = [
            'type' => 'required|in:file,lesson,subject_class',
            'file_type' => 'nullable|in:video,pdf,audio',

        ];
        $validator = Validator::make($request->all(), $rules, [

            'type.in' => 406,
            'file_type.in' => 407,

        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [

                    406 => 'Failed,The type must be an video or lesson or subject_class',
                    407 => 'Failed,The file type must be an video or audio or pdf',

                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }


        if ($request->type == 'file') {

            $video = VideoParts::where('id', '=', $id)->where('type', '=', $request->file_type)->first();
            if (!$video) {
                return self::returnResponseDataApi(null, "هذا الفيديو او المرفق غير موجود", 404, 404);
            } else {

                $videoOpenedByUser = VideoOpened::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('video_part_id', '=', $video->id)->first();

                if ($videoOpenedByUser) {
                    $videoOpenedByUser->update(['status' => 'watched']);

                } else {
                    return self::returnResponseDataApi(null, "يجب فتح الملف السابق", 415, 200);
                }


                $nextFileToWatch = VideoParts::query()->orderBy('id', 'ASC')->where('type', '=', $request->file_type)
                    ->where('lesson_id', '=', $video->lesson_id)->orderBy('id', 'ASC')
                    ->get()
                    ->except($videoOpenedByUser->video_part_id)
                    ->where('id', '>', $videoOpenedByUser->video_part_id)->first();


                if ($nextFileToWatch) {

                    $watched = VideoOpened::query()->where('user_id', '=', Auth::guard('user-api')->id())
                        ->where('video_part_id', '=', $nextFileToWatch->id)->first();

                    if (!$watched) {
                        VideoOpened::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'video_part_id' => $nextFileToWatch->id,
                        ]);

                        return self::returnResponseDataApi(null, "تم اكتمال مشاهده هذا الملف وتم فتح الملف الذي يليه بنجاح", 200);

                    } else {
                        return self::returnResponseDataApi(null, "تم فتح الملف الذي يلي هذا الملف من قبل", 417);
                    }

                } else {
                    return self::returnResponseDataApi(null, "تم الوصول للملف الاخير من هذا النوع للملف", 418);

                }
            }


        } elseif ($request->type == 'lesson') {

            $lesson = Lesson::where('id', '=', $id)->first();
            if (!$lesson) {
                return self::returnResponseDataApi(null, "هذا الدرس غير موجود", 404, 404);
            }

            $opened_lesson = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('lesson_id', '=', $lesson->id)->first();
            $next_lesson = Lesson::orderBy('id', 'ASC')->get()->except($id)->where('id', '>', $id)->first();
            if ($next_lesson) {
                $next_lesson_open = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('lesson_id', '=', $next_lesson->id)->first();

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

            } else {
                return self::returnResponseDataApi(null, "تم الوصول للدرس الاخير ولا يوجد اي دروس اخري لفتحها", 500);
            }

        } else {

            $subject_class = SubjectClass::where('id', '=', $id)->first();
            if (!$subject_class) {
                return self::returnResponseDataApi(null, "هذا الفصل غير موجود", 404, 404);
            }


            $opened_subject_class = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())->where('subject_class_id', '=', $subject_class->id)->first();
            $next_subject_class = SubjectClass::orderBy('id', 'ASC')->get()->except($id)->where('id', '>', $id)->first();
            if ($next_subject_class) {
                $next_subject_class_open = OpenLesson::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('subject_class_id', '=', $next_subject_class->id)->first();

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
        }//end else condition

    }
}
