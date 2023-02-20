<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function returnResponseDataApi($data=null,string $message,int $code,int $status = 200){

        return response()->json([

            'data' => $data,
            'message' => $message,
            'code' => $code,

        ],$status);

    }

}
