<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller{


    public function allMonths(): JsonResponse{

        return self::returnResponseDataApi(null,"Hi Islam",200);
    }


    public function addPaymentByStudent(): JsonResponse
    {

        return self::returnResponseDataApi(null,"Hi Islam",200);

    }

}
