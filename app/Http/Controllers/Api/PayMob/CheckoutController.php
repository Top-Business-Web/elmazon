<?php

namespace App\Http\Controllers\Api\PayMob;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index(): JsonResponse
    {

        $rules = [
            'total_after_discount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
        $validator = Validator::make(request()->all(), $rules, [
            'total_after_discount.regex' => 407,
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->flatten(1)[0];
            if (is_numeric($errors)) {

                $errors_arr = [
                    407 => 'Failed,Total after discount must be an price.',
                ];

                $code = collect($validator->errors())->flatten(1)[0];
                return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
            }
            return self::returnResponseDataApi(null, $validator->errors()->first(), 422);
        }

        $order = Payment::create([
            'total_price' => request()->total_after_discount,
            'user_id' => Auth::guard('user-api')->id(),
        ]);

        return PayMobController::pay($order->total_price,$order->id);

    }
}
