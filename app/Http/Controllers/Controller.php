<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function returnResponseDataApi($data=null,string $message,int $code,int $status = 200): JsonResponse{

        return response()->json([

            'data' => $data,
            'message' => $message,
            'code' => $code,

        ],$status);

    }


    public static function returnResponseDataApiWithMultipleIndexes(array $data,string $message,int $code,int $status = 200): JsonResponse{

        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ],$status);

    }

}
