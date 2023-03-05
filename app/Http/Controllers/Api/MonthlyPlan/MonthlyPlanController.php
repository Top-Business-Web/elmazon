<?php

namespace App\Http\Controllers\Api\MonthlyPlan;

use App\Http\Controllers\Controller;
use App\Http\Resources\MonthlyPlanResource;
use App\Models\MonthlyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonthlyPlanController extends Controller{


    public function all_plans(){

        try {

            $plans = MonthlyPlan::get();
            return self::returnResponseDataApi(MonthlyPlanResource::collection($plans), "تم الحصول علي بيانات الخطه الشهريه بنجاح", 500);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

    public function plan_today(Request $request){

        try {

            $rules = [
                'date' => 'required|exists:monthly_plans,start',
            ];
            $validator = Validator::make($request->all(), $rules, [
                'date.exists' => 407,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        407 => 'Failed,The day not found.',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, isset($errors_arr[$errors]) ? $errors_arr[$errors] : 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
            }
            $plans = MonthlyPlan::where('start','=',$request->date)->get();
            return self::returnResponseDataApi(MonthlyPlanResource::collection($plans), "تم الحصول علي خطه هذا التاريخ بنجاح", 500);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    }

}
