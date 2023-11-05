<?php

namespace App\Http\Controllers\Api\PayMob;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllMonthsResource;
use App\Models\DiscountCoupon;
use App\Models\DiscountCouponStudent;
use App\Models\Subscribe;
use App\Models\UserSubscribe;
use App\Models\VideoParts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller{


    public function allMonths(): JsonResponse{

        $listOfMonth = [
            1 => 'January',
            2 => 'February',
            3 =>'March',
            4 =>'April',
            5 =>'May',
            6 => 'June',
            7 =>'July',
            8 =>'August',
            9 => 'September',
            10 =>'October',
            11 => 'November',
            12 => 'December',
        ];

        $arrayKeys = array_keys($listOfMonth);
        $arrayValues = array_values($listOfMonth);

        $nameOfMonths = ['شهر يناير', 'شهر فبراير','شهر مارس','شهر ابريل','شهر مايو', 'شهر يونيو','شهر يوليو','شهر اغسطس', 'شهر سبتمبر', 'شهر اكتوبر', 'شهر نوفمبر', 'شهر ديسمبر',];

           $data = [];

           for($i = 0 ; $i < count($arrayKeys); $i++) {

           $result  = AllMonthsResource::collection(VideoParts::query()
               ->whereHas('lesson', fn(Builder $builder) =>
               $builder
                   ->whereHas('subject_class', fn(Builder $builder)=>
                   $builder
                       ->whereHas('term',fn (Builder $builder) =>
                       $builder
                           ->where('status', '=', 'active')
                           ->where('season_id', '=', auth('user-api')->user()->season_id))
                   ))->where('month','=',$arrayKeys[$i])->get());

               $price = Subscribe::query()
                   ->whereHas('term',fn (Builder $builder) =>
                   $builder->where('status', '=', 'active')
                       ->where('season_id', '=', auth('user-api')->user()->season_id)
                   )->where('month','=',$arrayKeys[$i])
                   ->first();

               $data[$arrayValues[$i]] = [
                   'id' => $arrayKeys[$i],
                   'name' => $nameOfMonths[$i],
                   'price' => $price ? ($price->free == "yes" ? 0 : (auth('user-api')->user()->center == 'in' ? $price->price_in_center : $price->price_out_center)) : 0,
                   'free_status' => $price ? ($price->free == "yes" ? "free" : "not_free") : "unavailable",
                   'content' => $result,
               ];

           }

        return self::returnResponseDataApi($data,"تم الحصول علي جميع محتوي الشرح انت الان جاهز لاختيار شهور معينه للاشتراك علي منصتنا",200);
    }


    public function checkMoneyPaidWithDiscount(Request $request): JsonResponse
    {

        //جلب جميع اشتراكات الشهور للطالب بالسنه الحاليه
        $userSubscribes = UserSubscribe::query()
            ->where('student_id', auth('user-api')->id())
            ->where('year', Carbon::now()->format('Y'))
            ->pluck('month')
            ->toArray();

        if (request()->coupon) {

            $checkCoupon = DiscountCoupon::query()
            ->where('coupon', $request->coupon)
                ->first();


            if (!$checkCoupon) {
                return self::returnResponseDataApi(null, "كود الخصم غير موجود في سجل البيانات", 404, 404);
            }

            $countStudentUsedCoupon = DiscountCouponStudent::query()
                ->where('user_id', auth('user-api')->id())
                ->where('discount_coupon_id','=', $checkCoupon->id)
                ->count();


            //جمع مبالغ الشهور اللي الطالب بعتها
            $totalPrice = [];
            foreach ($request->data as $item) {

                if (in_array($item['month'], $userSubscribes)) {
                    // $item['month'] is already subscribed
                    continue; // Skip this item
                }

                UserSubscribe::create([
                    'price' => $item['price'],
                    'month' => $item['month'],
                    'student_id' => auth('user-api')->id(),
                    'year' => Carbon::now()->format('Y'),
                ]);
                $totalPrice[] = $item['price'];
            }


            //تفقد حاله كود الخصم هل انتهي ام اكتمل عدد مستخدمين هذا الكود
            $couponStatus = ($checkCoupon->is_enabled == 0 || Carbon::now()->format('Y-m-d') > $checkCoupon->valid_to) ? "unavailable" :
                (DiscountCouponStudent::query()
            ->where('discount_coupon_id', $checkCoupon->id)->count() == $checkCoupon->total_usage
                    ? "total_used_completed"
                    : "available");


            //تفقد حاله المبلغ المدفوع اذا كان نوع الخصم بال % او مبلغ
            $totalAfterDiscount = ($couponStatus === "available")
                ? ($checkCoupon->discount_type == 'per'
                    ? (array_sum($totalPrice) - ((array_sum($totalPrice) * $checkCoupon->discount_amount) / 100))
                    : (array_sum($totalPrice) - $checkCoupon->discount_amount))
                : 0;


            $code = 200;

            if ($countStudentUsedCoupon > 0 && empty($totalPrice)) {
                $message = "تم تسجيل الاشتراكات في هذه الشهور من قبل وتم استخدام هذا الكوبون من قبل";
                $code = 415;
            } elseif ($countStudentUsedCoupon > 0) {
                $message = "تم استخدام هذا الكوبون من قبل";
                $code = 416;
            } elseif (empty($totalPrice)) {
                $message = "تم الاشتراك من قبل في هذه الشهور";
                $code = 417;
            } else {
                $message = "تم تسجيل بيانات الاشتراك بنجاح برجاء التوجهه لعمليه الدفع الالكتروني";
            }

            if ($countStudentUsedCoupon < 1) {
                DiscountCouponStudent::create([
                    'discount_coupon_id' => $checkCoupon->id,
                    'user_id' => auth('user-api')->id(),
                ]);
            }


            return self::sendResponseTotalAfterDiscount($totalPrice, $couponStatus,$totalAfterDiscount,$message,$code);

        } else {

            //تفقد المبلغ المدفوع في حاله عدم ادخال اي كود مجاني
            $totalPrice = [];
            foreach ($request->data as $item) {

                if (in_array($item['month'], $userSubscribes)) {
                    // $item['month'] is already subscribed
                    continue; // Skip this item
                }
                UserSubscribe::create([
                    'price' => $item['price'],
                    'month' => $item['month'],
                    'student_id' => auth('user-api')->id(),
                    'year' => Carbon::now()->format('Y'),
                ]);
                $totalPrice[] = $item['price'];
            }

            $code = 200;

            if (empty($totalPrice)) {
                $message = "تم الاشتراك من قبل في هذه الشهور";
                $code = 417;
            } else {
                $message = "تم تسجيل بيانات الاشتراك بنجاح برجاء التوجهه لعمليه الدفع الالكتروني";
            }


            return self::sendResponseTotalAfterDiscount($totalPrice, "unavailable",0,$message,$code);
        }

    }



    //Response json total after discount
    public static function sendResponseTotalAfterDiscount($total,$status,$totalAfterDiscount,$message,$code): JsonResponse
    {

        return response()->json([
            'data' => [
                'total' => array_sum($total),
                'coupon_status' =>$status,
                'total_after_discount' => $totalAfterDiscount,
            ],
            'message' => $message,
            "code" => $code,
        ]);
    }


}