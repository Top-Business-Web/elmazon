<?php

namespace App\Http\Controllers\Api\PayMob;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use PayMob\Facades\PayMob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayMobController extends Controller{


    
    public static function pay(float $total_price,int $order_id): JsonResponse
    {

        $auth = PayMob::AuthenticationRequest();
        
        $order = PayMob::OrderRegistrationAPI([
            'auth_token' => $auth->token,
            'amount_cents' => $total_price * 100, //put your price
            'currency' => 'EGP',
            'delivery_needed' => false, // another option true
            'merchant_order_id' => $order_id, //put order id from your database must be unique id
            'items' => [] // all items information or leave it empty
        ]);


        $PaymentKey = PayMob::PaymentKeyRequest([
            'auth_token' => $auth->token,
            'amount_cents' => $total_price * 100, //put your price
            'currency' => 'EGP',
            'order_id' => $order->id,
            "billing_data" => [ // put your client information
                "apartment" => "803",
                "email" => "claudette09@exa.com",
                "floor" => "42",
                "first_name" => "Clifford",
                "street" => "Ethan Land",
                "building" => "8028",
                "phone_number" => "+86(8)9135210487",
                "shipping_method" => "PKG",
                "postal_code" => "01898",
                "city" => "Jaskolskiburgh",
                "country" => "CR",
                "last_name" => "Nicolas",
                "state" => "Utah"
            ]
        ]);


        return response()->json([
            'data' => "https://accept.paymob.com/api/acceptance/iframes/758783?payment_token=$PaymentKey->token",
            'message' => "تم الوصول الي لينك الدفع الالكتروني برجاء التوجهه الي عمليه الدفع لاتمام الدفع المبلغ",
            'code' => 200,

        ],200);


    }


    public function checkout_processed(Request $request){


            $request_hmac = $request->hmac;
            $calc_hmac = PayMob::calcHMAC($request);

            if ($request_hmac == $calc_hmac) {
                $order_id = $request->obj['order']['merchant_order_id'];
                $amount_cents = $request->obj['amount_cents'];
                $transaction_id = $request->obj['id'];

                $order = Payment::find($order_id);

                if ($request->obj['success'] && ($order->total_price * 100) == $amount_cents) {
                    $order->update([
                        'transaction_status' => 'finished',
                        'transaction_id' => $transaction_id
                    ]);
                } else {
                    $order->update([
                        'transaction_status' => "failed",
                        'transaction_id' => $transaction_id
                    ]);
                }
            }
    }


    public function responseStatus(Request $request): JsonResponse
    {

        if($request->status === true){

            return self::returnResponseDataApi(null, "نجحت عمليه الدفع الالكتروني برجاء التوجهه الي الصفحه الرئيسيه من التطبيق", 200);

        }else{

            return self::returnResponseDataApi(null, "فشلت عمليه الدفع الالكتروني برجاء التوجهه الي الصفحه الرئيسيه من التطبيق", 420);
        }
    }

}
