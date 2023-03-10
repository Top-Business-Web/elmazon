<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllExamResource;
use App\Http\Resources\CommunicationResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PapelSheetExamTimeResource;
use App\Http\Resources\PapelSheetExamTimeUserResource;
use App\Http\Resources\PapelSheetResource;
use App\Http\Resources\PhoneTokenResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SubjectClassResource;
use App\Http\Resources\SuggestResource;
use App\Http\Resources\UserResource;
use App\Models\AllExam;
use App\Models\Notification;
use App\Models\PapelSheetExam;
use App\Models\PapelSheetExamTime;
use App\Models\PapelSheetExamUser;
use App\Models\PhoneToken;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\SubjectClass;
use App\Models\Suggestion;
use App\Models\User;
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
                return self::returnResponseDataApi(null, "???????????? ?????? ???????? ?????????? ?????????????? ???? ??????????????????????", 408);
            }
            $user = Auth::guard('user-api')->user();
            $user['token'] = $token;
            return self::returnResponseDataApi(new UserResource($user), "???? ?????????? ???????????? ??????????", 200);

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

                return self::returnResponseDataApi(new SuggestResource($suggestion), "???? ?????????? ???????????????? ??????????", 200);

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

            return self::returnResponseDataApi(NotificationResource::collection($allNotification), "???? ?????????? ?????????????? ???????????????? ??????????", 200);


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function communication()
    {
        try {
            $setting = Setting::first();

            return self::returnResponseDataApi(new CommunicationResource($setting), "???? ???????????? ?????? ???????????? ?????????????? ???? ??????????????????????", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function getProfile(Request $request)
    {

        try {

            $user = Auth::guard('user-api')->user();
            $user['token'] = $request->bearerToken();

            return self::returnResponseDataApi(new UserResource($user), "???? ???????????? ?????? ???????????? ???????????? ??????????", 200);

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
            return self::returnResponseDataApi(null, "???? ???????? ???? ???????????? ???????? ???????? ????", 404);
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
                        return self::returnResponseDataApi(null, "???? ?????????? ?????????????? ???? ???????????????? ???????????? ???????? ???????? ????????????", 407);
                    } else {

                        if ($userRegisterExamBefore > 0) {

                            return self::returnResponseDataApi(null, "???? ?????????????? ???? ???????????????? ???????????? ???? ??????", 408);
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
                                        'exam' => new PapelSheetExamTimeUserResource($papelSheetExam),
                                    ],
                                    'message' => '???? ?????????? ?????????????? ???? ????????????????',
                                    'code' => 200,
                                    'date_exam' => $papelSheetExam->date_exam,
                                    'address' => $section->address,
                                    'section_name' => lang() == 'ar' ? $section->section_name_ar : $section->section_name_en,
                                ]);
                            } else {

                                return self::returnResponseDataApi(null, "!?????? ?????????? ?????? ???????? ???????????? ????????????????", 412);
                            }
                        }
                    }
                    break;
                }
            } else {
                return self::returnResponseDataApi(null, "???? ???????????? ?????????????? ???????? ???????????????? ?????????? ?????????????? ???? ??????????????????????", 411);
            }
        }

    }

    public function papel_sheet_exam_show()
    {

        $papelSheetExam = PapelSheetExam::whereHas('season', function ($season) {
            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
            $term->where('status', '=', 'active');
        })->whereDate('to','>=',Carbon::now()->format('Y-m-d'))->first();

        if (!$papelSheetExam) {
            return self::returnResponseDataApi(null, "???? ???????? ???????????? ????????", 404);
        }

        return self::returnResponseDataApi(new PapelSheetResource($papelSheetExam), "???????? ???? ???? ???????????????? ????????????", 200);
    }


    public function updateProfile(Request $request){

        $rules = [
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'image.mimes' => 407,
            'images.image' => 408
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The image type must be an jpg or png or jpeg.',
                    408 => 'Failed,The file uploaded must be an image'
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }
        $user = Auth::guard('user-api')->user();

        if($image = $request->file('image')){
            $destinationPath = 'users/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";

            if(file_exists(public_path('users/'. $user->image)) && $user->image != null){
                unlink(public_path('users/'. $user->image));
            }
        }

        $user->update([
            'image' => $file ?? $user->image
        ]);

        $user['token'] = $request->bearerToken();
        return self::returnResponseDataApi(new UserResource($user),"???? ?????????? ???????? ???????????? ??????????",200);

    }

    public function home_page(){

        try {

            $classes = SubjectClass::whereHas('term', function ($term){
                $term->where('status','=','active');
            })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();

            $sliders = Slider::get();
            $notification = Notification::whereHas('term', function ($term) {
                $term->where('status', '=', 'active');
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->latest()->first();

            return response()->json([
                'data' => [
                     'sliders' => SliderResource::collection($sliders),
                    'notification' => new NotificationResource($notification),
                    'classes' => SubjectClassResource::collection($classes),

                ],
                'code' => 200,
                'message' => "???? ?????????? ???????? ???????????? ???????????? ????????????????",
            ]);
        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }


    }

    public function add_device_token(Request $request){

        $rules = [
            'token' => 'required',
            'phone_type' => 'required|in:android,ios'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'phone_type.in' => 407,
        ]);

        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The phone type must be an android or ios.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        $phoneToken = PhoneToken::create([
            'user_id' => auth()->guard('user-api')->id(),
            'token' => $request->token,
            'phone_type' => $request->phone_type
        ]);

        $phoneToken->user->token = $request->bearerToken();
        if(isset($phoneToken)){
            return self::returnResponseDataApi(new PhoneTokenResource($phoneToken),"Token insert successfully", 200);
        }
    }

    public function logout(Request $request){

        try {

            $rules = [
                'token' => 'required|exists:phone_tokens,token',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'token.exists' => 407,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,The token does not exists.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }
            PhoneToken::where('token','=',$request->token)->where('user_id','=',auth('user-api')->id())->delete();
            auth()->guard('user-api')->logout();
            return self::returnResponseDataApi(null, "???? ?????????? ???????????? ??????????", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }
}
