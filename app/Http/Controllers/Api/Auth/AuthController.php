<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunicationResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PapelSheetExamTimeResource;
use App\Http\Resources\PapelSheetResource;
use App\Http\Resources\SuggestResource;
use App\Http\Resources\UserResource;
use App\Models\Notification;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamTime;
use App\Models\PapelSheetExamUser;
use App\Models\Section;
use App\Models\Setting;
use App\Models\SubjectClass;
use App\Models\Suggestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                'code' => 'required|exists:users,code',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'code.exists' => 407,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,Code not found.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            $token = Auth::guard('user-api')->attempt(['code' => $request->code, 'password' => '123456', 'user_status' => 'active']);

            if (!$token) {
                return self::returnResponseDataApi(null, "الطالب غير مفعل برجاء التواصل مع السيكرتاريه", 408);
            }
            $user = Auth::guard('user-api')->user();
            $user['token'] = $token;
            return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function addSuggest(Request $request)
    {

        try {
            $rules = [
                'suggestion' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'suggestion.string' => 407,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,Suggestion must be an a string.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            $suggestion = Suggestion::create([

                'user_id' => Auth::guard('user-api')->id(),
                'suggestion' => $request->suggestion,
            ]);

            if (isset($suggestion)) {

                return self::returnResponseDataApi(new SuggestResource($suggestion), "تم تسجيل الاقتراح بنجاح", 200);

            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


    public function allNotifications()
    {

        try {

            $allNotification = Notification::whereHas('term', function ($term) {

                $term->where('status', '=', 'active');
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->get();

            return self::returnResponseDataApi(NotificationResource::collection($allNotification), "تم ارسال اشعارات المستخدم بنجاح", 200);


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function communication()
    {

        try {

            $setting = Setting::first();

            return self::returnResponseDataApi(new CommunicationResource($setting), "تم الحصول علي بيانات التواصل مع السكيرتاريه", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function getProfile(Request $request)
    {

        try {

            $user = Auth::guard('user-api')->user();
            $user['token'] = $request->bearerToken();

            return self::returnResponseDataApi(new UserResource($user), "تم الحصول علي بيانات الطالب بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


    public function papel_sheet_exam(Request $request, $id)
    {

        $rules = [
            'papel_sheet_exam_time_id' => 'required|exists:papel_sheet_exam_times,id',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'papel_sheet_exam_time_id.exists' => 405,
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    405 => 'Failed,papel_sheet_exam_time_id does not exist',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        $papelSheetExam = PapelSheetExam::whereHas('season', function ($season) {
            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
            $term->where('status', '=', 'active');
        })->where('id', '=', $id)->first();

        if (!$papelSheetExam) {
            return self::returnResponseDataApi(null, "لا يوجد اي امتحان ورقي متاح لك", 404);
        }

        $ids = Section::query()->orderBy('id', 'ASC')->pluck('id')->toArray();;
        foreach ($ids as $id) {
            $sectionCheck = Section::query()->where('id', '=', $id)->first();
            $CheckCountSectionExam = PapelSheetExamUser::where('section_id', '=', $sectionCheck->id)
                ->where('papel_sheet_exam_id', '=', $papelSheetExam->id)->count();

            $userRegisterExamBefore = PapelSheetExamUser::where('papel_sheet_exam_id', '=', $papelSheetExam->id)
                ->where('user_id', '=', Auth::guard('user-api')->id())->count();

            $sumCapacityOfSection = Section::sum('capacity');
            $countExamId = PapelSheetExamUser::where('papel_sheet_exam_id', '=', $papelSheetExam->id)->count();

            if ((int)$countExamId < (int)$sumCapacityOfSection) {
                if ($CheckCountSectionExam < $sectionCheck->capacity) {
                    $section = Section::query()->where('id', '=', $id)->first();
                    if ($CheckCountSectionExam == $sectionCheck->capacity) {
                        $section = Section::query()->skip($section->id)->first();//to get empty section after complete check
                    }
                    if (Auth::guard('user-api')->user()->center == 'out') {
                        return self::returnResponseDataApi(null, "لا يمكنك التسجيل في الامتحان الورقي لانك خارج السنتر", 407);
                    } else {

                        if ($userRegisterExamBefore > 0) {

                            return self::returnResponseDataApi(null, "تم التسجيل في الامتحان الورقي من قبل", 408);
                        } else {

                            if (Carbon::now()->format('Y-m-d') <= $papelSheetExam->to) {
                                $papelSheetUser = PapelSheetExamUser::create([
                                    'user_id' => Auth::guard('user-api')->id(),
                                    'section_id' => $section->id,
                                    'papel_sheet_exam_id' => $papelSheetExam->id,
                                    'papel_sheet_exam_time_id' => $request->papel_sheet_exam_time_id,
                                ]);
                                return response()->json([
                                    'data' => [
                                        'exam' => new PapelSheetResource($papelSheetExam),
                                        'message' => 'تم تسجيل بياناتك فى الامتحان',
                                        'code' => 200
                                    ],
                                    'date_exam' => $papelSheetExam->date_exam,
                                    'address' => $section->address,
                                    'section_name' => lang() == 'ar' ? $section->section_name_ar : $section->section_name_en,
                                ]);
                            } else {

                                return self::returnResponseDataApi(null, "!لقد تعديت اخر موعد لتسجيل الامتحان", 412);
                            }
                        }
                    }
                    break;
                }
            } else {
                return self::returnResponseDataApi(null, "تم امتلاء القاعات لهذا الامتحان برجاء التواصل مع السيكرتاريه", 411);
            }
        }

    }

    public function papel_sheet_exam_show(){

        $papelSheetExam = PapelSheetExam::whereHas('season', function ($season) {
            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
            $term->where('status', '=', 'active');
        })->first();

        if (!$papelSheetExam) {
            return self::returnResponseDataApi(null, "لا يوجد امتحان ورقي", 404);
        }
        if (Carbon::now()->format('Y-m-d') <= $papelSheetExam->to) {
            return self::returnResponseDataApi(new PapelSheetResource($papelSheetExam), "اهلا بك في الامتحان الورقي", 200);

        } else {
            return self::returnResponseDataApi(null, "تم انتهاء هذا الامتحان", 405);
        }

    }

    public function logout()
    {
        try {
            auth()->guard('user-api')->logout();
            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


}
