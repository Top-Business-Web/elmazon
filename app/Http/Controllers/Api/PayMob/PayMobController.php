<?php

namespace App\Http\Controllers\Api\PayMob;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserSubscribe;
use Illuminate\Http\JsonResponse;
use PayMob\Facades\PayMob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayMobController extends Controller{


    public static function pay(float $total_price,int $order_id)
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

          return $PaymentKey->token;


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


                    ################################ start update months in user model ##########################################################################

                    $userSubscribes = UserSubscribe::query()
                        ->where('student_id','=',$order->user_id)
                        ->whereDate('created_at','=',date('Y-m-d'))
                        ->get();

                    $array = [];

                    foreach ($userSubscribes as $userSubscribe){

                        $array[] = $userSubscribe->month < 10 ? "0".$userSubscribe->month : $userSubscribe->month;
                    }

                    $studentAuth = User::find($order->user_id);
                    $studentAuth->subscription_months_groups = json_encode($array);
                    $studentAuth->save();


                    ################################ end months in user model ##########################################################################

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
