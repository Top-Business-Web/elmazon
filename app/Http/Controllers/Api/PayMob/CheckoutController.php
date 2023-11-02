<?php

namespace App\Http\Controllers\Api\PayMob;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {

        $order = Payment::create([
            'total_price' => 200,
            'user_id' => Auth::guard('user-api')->id(),
        ]);

        return PayMobController::pay($order->total_price,$order->id);

    }
}
