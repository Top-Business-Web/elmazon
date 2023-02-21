<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunicationResource;
use App\Http\Resources\UserResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
                    return self::returnResponseDataApi( null,isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null,$validator->errors()->first(),422);
            }

            $token = Auth::guard('user-api')->attempt(['code' => $request->code , 'password' => '123456','user_status' => 'active']);

            if (!$token) {
                return self::returnResponseDataApi( null,"الطالب غير مفعل برجاء التواصل مع السيكرتاريه", 408);
            }
            $user = Auth::guard('user-api')->user();
            $user['token'] = $token;
            return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200);

        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }
    }

    public function communication(){

        try {

            $setting = Setting::first();

            return self::returnResponseDataApi(new CommunicationResource($setting),"تم الحصول علي بيانات التواصل مع السكيرتاريه",200);

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }


    }

    public function getProfile(Request $request){

        try {

            $user = Auth::guard('user-api')->user();
            $user['token'] = $request->bearerToken();

            return self::returnResponseDataApi(new UserResource($user), "تم الحصول علي بيانات الطالب بنجاح", 200);

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }
    }


    public function logout(){

        try {

            auth()->guard('user-api')->logout();

            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);

        }catch (\Exception $exception) {

            return self::returnResponseDataApi(null,$exception->getMessage(),500);
        }
    }


}
