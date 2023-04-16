<?php

namespace App\Http\Repositories;
use App\Http\Controllers\Api\Traits\FirebaseNotification;
use App\Http\Interfaces\AuthRepositoryInterface;
use App\Http\Resources\CommunicationResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PapelSheetExamTimeUserResource;
use App\Http\Resources\PapelSheetResource;
use App\Http\Resources\PhoneTokenResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SubjectClassNewResource;
use App\Http\Resources\SuggestResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideoBasicResource;
use App\Http\Resources\VideoResourceResource;
use App\Models\ExamDegreeDepends;
use App\Models\Lesson;
use App\Models\LifeExam;
use App\Models\Notification;
use App\Models\OpenLesson;
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
use App\Models\UserScreenShot;
use App\Models\VideoBasic;
use App\Models\VideoParts;
use App\Models\VideoResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthRepository extends ResponseApi implements AuthRepositoryInterface {


    use FirebaseNotification;

    public function login(Request $request): \Illuminate\Http\JsonResponse
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

//            $user_data = User::where('code', '=', $request->code)->first();
//            if ($user_data->login_status == 1) {
//                return self::returnResponseDataApi(null, "هذا الطالب مسجل دخول من جهاز اخر!", 410);
//
//            }
            if (!$token) {
                return self::returnResponseDataApi(null, "الطالب غير مفعل برجاء التواصل مع السيكرتاريه", 408);
            }
            $user = Auth::guard('user-api')->user();
            $user->update(['login_status' => 1]);
            $user['token'] = $token;

            return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200);


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function addSuggest(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $rules = [
                'suggestion' => 'nullable|string',
                'type' => 'required|in:file,text,audio',
                'audio' => 'nullable',
                'image' => 'nullable|mimes:jpg,png,jpeg'
            ];
            $validator = Validator::make($request->all(), $rules, [
                'suggestion.string' => 407,
                'image.mimes' => 408,
                'type.in' => 409
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,Suggestion must be an a string.',
                        408 => 'Failed,The image type must be an jpg or jpeg or png.',
                        409 => 'Failed,The type of suggestion must be an file or text or audio',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }

            if ($image = $request->file('image')) {
                $destinationPath = 'suggestions_uploads/images/';
                $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $file);
                $request['image'] = "$file";

            } elseif ($audio = $request->file('audio')) {
                $audioPath = 'suggestions_uploads/audios/';
                $audioUpload = date('YmdHis') . "." . $audio->getClientOriginalExtension();
                $audio->move($audioPath, $audioUpload);
                $request['audio'] = "$audioUpload";

            } else {
                $suggestion = $request->suggestion;
            }

            if ($request->suggestion == null && $request->audio == null && $request->image == null) {

                return self::returnResponseDataApi(null, "يجب كتابه اقتراح او ارفاق صوره او رفع ملف صوتي", 422);
            }
            $suggestion_add = Suggestion::create([
                'user_id' => Auth::guard('user-api')->id(),
                'audio' => $audioUpload ?? null,
                'image' => $file ?? null,
                'type' => $request->type,
                'suggestion' => $suggestion ?? null,
            ]);

            if (isset($suggestion_add)) {
                $suggestion_add->user->token = $request->bearerToken();
                return self::returnResponseDataApi(new SuggestResource($suggestion_add), "تم تسجيل الاقتراح بنجاح", 200);

            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", 500);
            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


    public function allNotifications(): \Illuminate\Http\JsonResponse
    {

        try {

            $allNotification = Notification::whereHas('term', function ($term) {
                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->where(function ($q){
                $q->whereNull('user_id')->orWhere('user_id', '=', auth()->guard('user-api')->id());
            })->latest()->get();

            return self::returnResponseDataApi(NotificationResource::collection($allNotification), "تم ارسال اشعارات المستخدم بنجاح", 200);


        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function communication(): \Illuminate\Http\JsonResponse
    {
        try {
            $setting = Setting::first();

            return self::returnResponseDataApi(new CommunicationResource($setting), "تم الحصول علي بيانات التواصل مع السكيرتاريه", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

    public function getProfile(Request $request): \Illuminate\Http\JsonResponse
    {

        try {

            $user = Auth::guard('user-api')->user();
            $user['token'] = $request->bearerToken();
            return self::returnResponseDataApi(new UserResource($user), "تم الحصول علي بيانات الطالب بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }


    public function paper_sheet_exam(Request $request, $id)
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
            $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
        })->where('id', '=', $id)->first();


        if (!$papelSheetExam) {
            return self::returnResponseDataApi(null, "لا يوجد اي امتحان ورقي متاح لك", 404);
        }

        $ids = Section::orderBy('id','ASC')->pluck('id')->toArray();

        foreach ($ids as $id) {

            $sectionCheck = Section::where('id', '=',$id)->first();
            $CheckCountSectionExam = PapelSheetExamUser::where('section_id', '=', $sectionCheck->id)
                ->where('papel_sheet_exam_id', '=', $papelSheetExam->id)->count();

            $userRegisterExamBefore = PapelSheetExamUser::where('papel_sheet_exam_id', '=', $papelSheetExam->id)
                ->where('user_id', '=', Auth::guard('user-api')->id())->count();

            $sumCapacityOfSection = Section::sum('capacity');
            $countExamId = PapelSheetExamUser::where('papel_sheet_exam_id', '=', $papelSheetExam->id)->count();

            if ((int)$countExamId < (int)$sumCapacityOfSection) {

                if ($CheckCountSectionExam < $sectionCheck->capacity) {

                    // $section = Section::query()->skip($sectionCheck->id)->first();

                    if ($CheckCountSectionExam == $sectionCheck->capacity) {
                        $section = Section::orderBy('id','ASC')->get()->except($sectionCheck->id)->where('id','>',$sectionCheck->id);
                    }else{
                        $section = Section::where('id', '=', $id)->first();

                    }

                    if (Auth::guard('user-api')->user()->center == 'out') {
                        return self::returnResponseDataApi(null, "لا يمكنك التسجيل في الامتحان الورقي لانك خارج السنتر", 407);
                    } else {

                        if ($userRegisterExamBefore > 0) {

                            $section_register = PapelSheetExamUser::where('user_id','=',Auth::guard('user-api')->id())->where('papel_sheet_exam_id','=',$papelSheetExam->id)->first();
                            return response()->json([

                                'data' => ['exam' => new PapelSheetExamTimeUserResource($papelSheetExam)],
                                'message' => "تم التسجيل في الامتحان الورقي من قبل",
                                'code' => 408, 'date_exam' => $papelSheetExam->date_exam,
                                'address' =>  $section_register->sections->address,
                                'section_name' => lang() == 'ar' ?  $section_register->sections->section_name_ar :  $section_register->sections->section_name_en,

                            ]);

                        } else {

                            if (Carbon::now()->format('Y-m-d') <= $papelSheetExam->to) {
                                PapelSheetExamUser::create([
                                    'user_id' => Auth::guard('user-api')->id(),
                                    'section_id' => $section->id,
                                    'papel_sheet_exam_id' => $papelSheetExam->id,
                                    'papel_sheet_exam_time_id' => $request->papel_sheet_exam_time_id,
                                ]);


                                //start push notification for user when register in exam
                                $time_exam = PapelSheetExamTime::where('id', '=', $request->papel_sheet_exam_time_id)->first();
                                $this->sendFirebaseNotification(['title' => 'اشعار جديد',
                                    'body' => $time_exam->from . 'وموعد الامتحان  ' . $section->section_name_ar . 'واسم القاعه  ' . $section->address . 'ومكان الامتحان  ' . $papelSheetExam->date_exam . 'تاريخ الامتحان',
                                    'term_id' => $papelSheetExam->term_id], $papelSheetExam->season_id, Auth::guard('user-api')->id());

                                return response()->json(['data' => ['exam' => new PapelSheetExamTimeUserResource($papelSheetExam)], 'message' => 'تم تسجيل بياناتك فى الامتحان', 'code' => 200, 'date_exam' => $papelSheetExam->date_exam, 'address' => $section->address, 'section_name' => lang() == 'ar' ? $section->section_name_ar : $section->section_name_en,]);
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

    public function paper_sheet_exam_show(): \Illuminate\Http\JsonResponse
    {

        $papelSheetExam = PapelSheetExam::whereHas('season', function ($season) {
            $season->where('season_id', '=', auth()->guard('user-api')->user()->season_id);
        })->whereHas('term', function ($term) {
            $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
        })->whereDate('to', '>=', Carbon::now()->format('Y-m-d'))->first();

        if (!$papelSheetExam) {
            return self::returnResponseDataApi(null, "لا يوجد امتحان ورقي", 404);
        }

        return self::returnResponseDataApi(new PapelSheetResource($papelSheetExam), "اهلا بك في الامتحان الورقي", 200);
    }


    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse
    {

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

        if ($image = $request->file('image')) {
            $destinationPath = 'users/';
            $file = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file);
            $request['image'] = "$file";

            if (file_exists(public_path('users/' . $user->image)) && $user->image != null) {
                unlink(public_path('users/' . $user->image));
            }
        }

        $user->update([
            'image' => $file ?? $user->image
        ]);
        $user['token'] = $request->bearerToken();
        return self::returnResponseDataApi(new UserResource($user), "تم تعديل صوره الطالب بنجاح", 200);

    }

    public function home_page(): \Illuminate\Http\JsonResponse
    {

        try {

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

            if (!$subject_class_opened->exists() && !$lesson_opened->exists()) {
                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'subject_class_id' => $subject_class->id,
                ]);

                OpenLesson::create([
                    'user_id' => Auth::guard('user-api')->id(),
                    'lesson_id' => $first_lesson->id,
                ]);

            }

            $life_exam = LifeExam::whereHas('term', function ($term) {
                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)
                ->where('date_exam', '=', Carbon::now()->format('Y-m-d'))
                ->first();


            if (!$life_exam) {
                $id = null;
            } else {

                $now = Carbon::now();
                $start = Carbon::createFromTimeString($life_exam->time_start);
                $end = Carbon::createFromTimeString($life_exam->time_end);

                $degree_depends = ExamDegreeDepends::where('user_id', '=', Auth::guard('user-api')->id())
                    ->where('life_exam_id', '=', $life_exam->id);

                if ($now->isBetween($start, $end)) {
                    $id = $life_exam->id;
                } elseif ($degree_depends->exists()) {
                    $id = null;
                } else {
                    $id = null;
                }
            }


            $classes = SubjectClass::whereHas('term', function ($term) {
                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->get();

            $sliders = Slider::get();
            $videos_resources = VideoResource::whereHas('term', function ($term) {
                $term->where('status', '=', 'active')->where('season_id', '=', auth('user-api')->user()->season_id);
            })->where('season_id', '=', auth()->guard('user-api')->user()->season_id)->latest()->get();

            return response()->json([
                'data' => [
                    'life_exam' => $id,
                    'sliders' => SliderResource::collection($sliders),
                    'videos_basics' => VideoBasicResource::collection(VideoBasic::get()),
                    'classes' => SubjectClassNewResource::collection($classes),
                    'videos_resources' => VideoResourceResource::collection($videos_resources),
                ],
                'code' => 200,
                'message' => "تم ارسال جميع بيانات الصفحه الرئيسيه",
            ]);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }


    }


    public function startYourJourney(Request $request):\Illuminate\Http\JsonResponse{


          $classes = SubjectClass::whereHas('term', function ($term){
              $term->where('status', '=', 'active')->where('season_id','=',auth('user-api')->user()->season_id);
          })->where('season_id','=',auth()->guard('user-api')->user()->season_id)->get();

          return self::returnResponseDataApi(SubjectClassNewResource::collection($classes),"تم الحصول علي بيانات ابدء رحلتك بنجاح",200);


    }

    public function findExamByClassById($id):\Illuminate\Http\JsonResponse{

        $class = SubjectClass::where('id', $id)->first();
        if(!$class){

            return self::returnResponseDataApi(null,"هذا الفصل غير موجود",404);
        }


       return self::returnResponseDataApi(new SubjectClassNewResource($class),"message",200);
    }

    public function add_device_token(Request $request)
    {

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
        if (isset($phoneToken)) {
            return self::returnResponseDataApi(new PhoneTokenResource($phoneToken), "Token insert successfully", 200);
        }
    }

    public function add_notification(Request $request): \Illuminate\Http\JsonResponse
    {

        $rules = [
            'body' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'body.string' => 407,
        ]);


        if ($validator->fails()) {

            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,The body must be an string.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        $this->sendFirebaseNotification(['title' => 'اشعار جديد', 'body' => $request->body, 'term_id' => 1], 1);

        return self::returnResponseDataApi(null, "تم ارسال اشعار جديد", 200);

    }

    public function user_add_screenshot(): \Illuminate\Http\JsonResponse
    {

        $user_screen = UserScreenShot::where('user_id', '=', Auth::guard('user-api')->id());

        if ($user_screen->count() == 0) {
            $user_screen_shot = UserScreenShot::create([

                'user_id' => Auth::guard('user-api')->id(),
                'count_screen_shots' => 1,
            ]);

            if (isset($user_screen_shot)) {
                return self::returnResponseDataApi(null, "تم اخذ اسكرين شوت بالتطبيق بواسطه اليوزر", 200);

            } else {

                return self::returnResponseDataApi(null, "يوجد خطاء بدخول البيانات برجاء الرجوع لمطور الباك اند", 500);

            }
        } elseif ($user_screen->first()->count_screen_shots < 2) {

            $user_screen_before = UserScreenShot::where('user_id', '=', Auth::guard('user-api')->id())->first();
            $user_screen_before->update(['count_screen_shots' => $user_screen_before->count_screen_shots += 1]);
            return self::returnResponseDataApi(null, "تم اخذ اسكرين شوت بالتطبيق بواسطه اليوزر", 200);

        } else {

            $user = User::where('id', '=', Auth::guard('user-api')->id())->first();
            $user->update(['user_status' => 'not_active', 'login_status' => 0,]);

            return self::returnResponseDataApi(null, "تم حظر ذلك المستخدم لانه تخطي 3 مرات من اخذ الاسكرين", 201);

        }


    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {

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
            PhoneToken::where('token', '=',$request->token)->where('user_id', '=',auth('user-api')->id())->delete();
            auth()->guard('user-api')->logout();
            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    }

}