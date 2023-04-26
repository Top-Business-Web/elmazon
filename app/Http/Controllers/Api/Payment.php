<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\UserSubscribe;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use function env;

class Payment extends Controller
{

    private Paymentservice $paymentService;

    /**
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function pay(Request $request)
    {
        return $this->paymentService->pay($request);
    }

    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        \Stripe\Charge::create([

            'amount' => $request->amount,
            'currency'=>"usd",
            'source'=> $request->stripeToken,
            'description' =>'Test payment from muhammed essa'
        ]);

        Session::flash('success','Payment has been successfully');
        return back();
    }
    public function pay_(Request $request)
    {
        $inputs = $request->all();
//dd($inputs);
        $endpoint = "https://accept.paymobsolutions.com/api/auth/tokens";
        $orderEndpoint = "https://accept.paymobsolutions.com/api/ecommerce/orders";
        $payment_keysEndpoint = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
        $value = env('PAYMOB_API_KEY');

        session()->put('items_posts', $inputs);
        session()->put('user_type', );

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
                  "user_id"=>777,
                  "lock_order_when_paid"=> false
            ])->json();

        $url = "https://accept.paymobsolutions.com/api/acceptance/iframes/743638?payment_token=".$payment_to_pay['token'];

        return self::returnResponseDataApi(['payment_url' => $url],"تم استلام لينك الدفع بنجاح ",200);

    }

    public function pay_callback()
    {
//        dd(request()->all());
        $endpoint = "https://accept.paymobsolutions.com/api/auth/tokens";
        $value = env('PAYMOB_API_KEY');
        $transaction = Http::withHeaders(['content-type' => 'application/json'])
            ->get($endpoint, [
                "api_key" => $value
            ])->json();
        $response = request()->query();
//        dd($response);
        if($response['success'] == true){
//            dd(Session::get('items_posts'));
//            foreach (Session::get('items_posts')['subscribes_ids'] as  $item){
//                $subscribe_item = Subscribe::find($item);
//                UserSubscribe::create([
//                    'price' => $subscribe_item->price_in_center,
//                    'month' => $subscribe_item->price_in_center,
//                    'student_id' => $subscribe_item->price_in_center,
//                ]);
//            }
        }
        return redirect()->to('api/checkout?status='.$response['success'].'&id='.$response['id']);
    }

    public function checkout(Request $request)
    {
        $user = auth()->guard('user-api')->user();
        foreach ($request->subscribes_ids as  $item){
            $subscribe_item = Subscribe::find($item);
            UserSubscribe::create([
                'price' => ($user->center == "in")? $subscribe_item->price_in_center : $subscribe_item->price_out_center,
                'month' => $subscribe_item->month,
                'year' => $subscribe_item->year,
                'student_id' =>  $user->id,
            ]);
            array_push($months,$subscribe_item->month);
        }  //
        return self::returnResponseDataApi(null,"تد الدفع بنجاح",200);
    }


}
