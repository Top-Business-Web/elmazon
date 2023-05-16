<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

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


    public function loginOdoo(){
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post('http://194.163.177.140/web/session/authenticate/', [
                'jsonrpc' => '2.0',
                'method' => 'call',
                "params"=> [
                        "login" => "admin",
                        "password"=>  "admin",
                        "db"=>  "Development"
                ]
            ]);
        if ($response->ok()) {
                $session_id=  $response->getHeaders();

            $cookie;
            foreach ($session_id as $header) {
                if (strpos($header, 'Set-Cookie:') === 0) { // check for "Set-Cookie:" header
                    $cookie_header = $header;
                    break; // exit loop once we find the first "Set-Cookie:" header
                }
            }
            dd($cookie);
            $get_url_token = Http::withHeaders(['content-type' => 'application/json','Cookie' => "session_id=$session_id"])
                ->post('http://194.163.177.140/api/res.partner/', [
                    "params"=>[
                        "data"=> [
                            "name" => "العسل ",
                            "mobile"=> "+96653904245",
                            "street"=>"شارع العليا العام",
                            "country_id"=>"2"
                        ]
                    ]
                ])->json();
            return $get_url_token;
        } else {
            return null;
        }

        return $get_url_token;


    }

}
