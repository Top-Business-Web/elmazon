<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllMonthsResource;
use App\Models\Guide;
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

               $data[$arrayValues[$i]]['name'] = $nameOfMonths[$i];
               $data[$arrayValues[$i]]['content'] = $result;

//               if (!$result->isEmpty()) {
//                   $data[$value] = $result;
//
//               } else {
//                   unset($data[$value]);
//               }

           }

        return self::returnResponseDataApi($data,"تم الحصول علي جميع محتوي الشرح انت الان جاهز لاختيار شهور معينه للاشتراك علي منصتنا",200);
    }


    public function addPaymentByStudent(): JsonResponse
    {

        return self::returnResponseDataApi(null,"Hi Islam",200);

    }

}
