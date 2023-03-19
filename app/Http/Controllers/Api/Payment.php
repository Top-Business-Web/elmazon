<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function env;

class Payment extends Controller
{
    public function pay(Request $request)
    {
        $inputs = $request->all();
        dd($inputs);
        $endpoint = "https://accept.paymobsolutions.com/api/auth/tokens";
        $orderEndpoint = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keysEndpoint = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $value = env('PAYMOB_API_KEY');

        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($endpoint, [
                "api_key" => $value
            ])->json();
//
        $order = Http::withHeaders(['content-type' => 'application/json'])
            ->post($orderEndpoint, [
                "auth_token" => $response['token'],
                "delivery_needed" => 'false',
                "merchant_id" => 743638,
                "amount_cents" => 2 *100,
                "currency" => "EGP",
                'items'=>[]
            ])->json();

        $payment_to_pay = Http::withHeaders(['content-type' => 'application/json'])
            ->post($payment_keysEndpoint, [
                 "auth_token"=>  $response['token'],
                  "amount_cents"=>2 *100,
                  "expiration"=>3600,
                  "order_id"=> $order['id'],
                  "billing_data"=>[
                        "apartment"=>"803",
                        "email"=>"claudette09@exa.com",
                        "floor"=>"42",
                        "first_name"=>"Clifford",
                        "street"=>"Ethan Land",
                        "building"=>"8028",
                        "phone_number"=>"+86(8)9135210487",
                        "shipping_method"=>"PKG",
                        "postal_code"=>"01898",
                        "city"=>"Jaskolskiburgh",
                        "country"=>"CR",
                        "last_name"=>"Nicolas",
                        "state"=>"Utah"
                      ],
                  "currency"=> "EGP",
                  "integration_id"=>3673470,
                  "lock_order_when_paid"=> false
            ])->json();

        $url = "https://accept.paymobsolutions.com/api/acceptance/iframes/743638?payment_token=".$payment_to_pay['token'];

        return self::returnResponseDataApi(['payment_url' => $url],"تم استلام لينك الدفع بنجاح ",200);

    }

    public function pay_callback()
    {
        $response = request()->query();
        return redirect()->to('api/checkout?status='.$response['success']);
    }

    public function checkout()
    {
        $response = request()->query();
        return self::returnResponseDataApi(null,"تد الدفع بنجاح",200);
    }
}
