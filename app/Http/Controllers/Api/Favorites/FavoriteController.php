<?php

namespace App\Http\Controllers\Api\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamNewResource;
use App\Http\Resources\LiveExamFavoriteResource;
use App\Http\Resources\LiveExamResource;
use App\Http\Resources\OnlineExamNewResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoBasicResource;
use App\Http\Resources\VideoPartNewResource;
use App\Http\Resources\VideoPartResource;
use App\Http\Resources\VideoResourceResource;
use App\Models\AllExam;
use App\Models\ExamsFavorite;
use App\Models\LifeExam;
use App\Models\OnlineExam;
use App\Models\VideoBasic;
use App\Models\VideoFavorite;
use App\Models\VideoParts;
use App\Models\VideoResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{

    public function examAddFavorite(Request $request): JsonResponse
    {

        try {
            $rules = [
                'online_exam_id' => 'nullable|exists:online_exams,id',
                'all_exam_id' => 'nullable|exists:all_exams,id',
                'life_exam_id' => 'nullable|exists:life_exams,id',
                'action' => 'required|in:favorite,un_favorite',
            ];
            $validator = Validator::make($request->all(), $rules, [

                'online_exam_id.exists' => 407,
                'all_exam_id.exists' => 408,
                'life_exam_id.exists' => 409,
                'action.in' => 410,

            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,Online exam does not exists.',
                        408 => 'Failed,All exam does not exists.',
                        409 => 'Failed,Live exam does not exists.',
                        410 => 'Failed,Action must be an favorite or un_favorite',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            if ($request->online_exam_id == null && $request->all_exam_id == null && $request->life_exam_id == null) {

                return self::returnResponseDataApi(null, "يجب اختيار امتحان اونلاين او لايف او شامل للمفضله", 420);

            } else {

                if ($request->online_exam_id != null) {

                    $userFavorite = ExamsFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'online_exam_id' => $request->online_exam_id
                    ])
                        ->exists();

                    if ($userFavorite) {

                        $favorite = ExamsFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('online_exam_id', '=', $request->online_exam_id)
                            ->first();

                        $favorite->update([
                            'online_exam_id' => $request->online_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه الامتحان الاونلاين للمفضله" : "تم حذف الامتحان الاونلاين من المفضله", 200);

                    } else {

                        ExamsFavorite::create([

                            'user_id' => Auth::guard('user-api')->id(),
                            'online_exam_id' => $request->online_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه الامتحان الاونلاين للمفضله", 200);

                    }

                } elseif ($request->life_exam_id != null) {

                    $userFavorite = ExamsFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'life_exam_id' => $request->life_exam_id
                    ])
                        ->exists();

                    if ($userFavorite) {

                        $favorite = ExamsFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('life_exam_id', '=', $request->life_exam_id)
                            ->first();

                        $favorite->update([
                            'life_exam_id' => $request->life_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه الامتحان الايف للمفضله" : "تم حذف الامتحان الايف من المفضله", 200);

                    } else {

                        ExamsFavorite::create([

                            'user_id' => Auth::guard('user-api')->id(),
                            'life_exam_id' => $request->life_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه الامتحان الايف للمفضله", 200);

                    }

                } else {

                    $userFavorite = ExamsFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'all_exam_id' => $request->all_exam_id
                    ])
                        ->exists();

                    if ($userFavorite) {

                        $favorite = ExamsFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('all_exam_id', '=', $request->all_exam_id)
                            ->first();

                        $favorite->update([
                            'all_exam_id' => $request->all_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه الامتحان الشامل للمفضله" : "تم حذف الامتحان الشامل من المفضله", 200);

                    } else {

                        ExamsFavorite::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'all_exam_id' => $request->all_exam_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه الامتحان  الشامل للمفضله", 200);

                    }
                }
            }


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function videoAddFavorite(Request $request): JsonResponse
    {


        try {
            $rules = [
                'video_basic_id' => 'nullable|exists:video_basics,id',
                'video_resource_id' => 'nullable|exists:video_resources,id',
                'video_part_id' => 'nullable|exists:video_parts,id',
                'favorite_type' => 'required|in:video_basic,video_resource,video_part',
                'action' => 'required|in:favorite,un_favorite',
            ];
            $validator = Validator::make($request->all(), $rules, [

                'video_basic_id.exists' => 407,
                'video_resource_id.exists' => 408,
                'video_part_id.exists' => 409,
                'favorite_type.in' => 410,
                'action.in' => 411,

            ]);

            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,video_basic does not exists.',
                        408 => 'Failed,video_resource does not exists.',
                        409 => 'Failed,video_part does not exists',
                        410 => 'Failed,favorite_type must be an video_basic or video_resource or video_part',
                        411 => 'Failed,Action must be an favorite or un_favorite',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            if ($request->video_basic_id == null && $request->video_resource_id == null && $request->video_part_id == null) {

                return self::returnResponseDataApi(null, "يجب اختيار نوع فيديو للمفضله", 420);

            } else {

                if ($request->video_basic_id != null) {

                    $userVideoFavorite = VideoFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'video_basic_id' => $request->video_basic_id
                    ])
                        ->exists();

                    if ($userVideoFavorite) {

                        $favorite_add = VideoFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('video_basic_id', '=', $request->video_basic_id)
                            ->first();

                        $favorite_add->update([
                            'video_basic_id' => $request->video_basic_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه اضافه فيديو الاساسيات للمفضله" : "تم حذف اضافه فيديو الاساسيات من المفضله", 200);

                    } else {

                        VideoFavorite::create([

                            'user_id' => Auth::guard('user-api')->id(),
                            'favorite_type' => $request->favorite_type,
                            'video_basic_id' => $request->video_basic_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه فيديو الاساسيات للمفضله", 200);

                    }

                }//end one if step

                elseif ($request->video_resource_id != null) {

                    $userVideoFavorite = VideoFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'video_resource_id' => $request->video_resource_id
                    ])
                        ->exists();

                    if ($userVideoFavorite) {

                        $favorite_add = VideoFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('video_resource_id', '=', $request->video_resource_id)
                            ->first();

                        $favorite_add->update([
                            'video_resource_id' => $request->video_resource_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه  فيديو المراجعه النهائيه للمفضله" : "تم حذف فيديو المراجعه النهائيه من المفضله", 200);

                    } else {

                        VideoFavorite::create([

                            'user_id' => Auth::guard('user-api')->id(),
                            'favorite_type' => $request->favorite_type,
                            'video_resource_id' => $request->video_resource_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه فيديو المراجعه النهائيه للمفضله", 200);

                    }

                }//end one else if step

                else {

                    $userVideoFavorite = VideoFavorite::query()->where([
                        'user_id' => Auth::guard('user-api')->id(),
                        'video_part_id' => $request->video_part_id
                    ])
                        ->exists();

                    if ($userVideoFavorite) {

                        $favorite_add = VideoFavorite::query()
                            ->where('user_id', '=', Auth::guard('user-api')->id())
                            ->where('video_part_id', '=', $request->video_part_id)
                            ->first();

                        $favorite_add->update([
                            'video_part_id' => $request->video_part_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, $request->action == 'favorite' ? "تم اضافه  فيديو الشرح للمفضله" : "تم حذف فيديو الشرح من المفضله", 200);

                    } else {

                        VideoFavorite::create([
                            'user_id' => Auth::guard('user-api')->id(),
                            'favorite_type' => $request->favorite_type,
                            'video_part_id' => $request->video_part_id,
                            'action' => $request->action
                        ]);

                        return self::returnResponseDataApi(null, "تم اضافه فيديو الشرح للمفضله", 200);

                    }

                }//end else step
            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }


    public function favoriteAll(): JsonResponse
    {

        $data['online_exams'] = OnlineExamNewResource::collection(OnlineExam::onlineExamFavorite());
        $data['all_exams'] = AllExamNewResource::collection(AllExam::allExamFavorite());
        $data['live_exams'] = LiveExamFavoriteResource::collection(LifeExam::liveExamFavorite());
        $data['video_basics'] = VideoBasicResource::collection(VideoBasic::basicFavorite());
        $data['video_resources'] = VideoResourceResource::collection(VideoResource::resourceFavorite());
        $data['video_parts'] = VideoPartNewResource::collection(VideoParts::favorite());

        return self::returnResponseDataApiWithMultipleIndexes($data, 'تم الحصول علي جميع المفضله للطالب', 200);
    }
}
