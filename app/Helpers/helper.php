<?php
//check current language
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Config;

if(!function_exists('lang')){

    function lang(){
        return Config::get('app.locale');

    }
}


if(!function_exists('getFromToFromMonthsList')){

    function getFromToFromMonthsList($months){
        $first_day = new DateTime(date('Y') . '-' . $months[0] . '-01');
        foreach ($months as $month) {

            $last_day = new DateTime(date('Y') . '-' . $month . '-01');
            $last_day->modify('last day of this month');
        }
        return [$first_day->format('Y-m-d') , $last_day->format('Y-m-d')];
    }

}
if(!function_exists('getFromToMonthsList')){

    function getFromToMonthsList($date_from,$date_to){
        $months =[];
        $result = CarbonPeriod::create($date_from, '1 month', $date_to);

        foreach ($result as $dt) {
            array_push($months,$dt->format("j"));
        }
       return $months;
    }

}


