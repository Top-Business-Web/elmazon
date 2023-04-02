<?php
//check current language
use Illuminate\Support\Facades\Config;

if(!function_exists('lang')){

    function lang(){
        return Config::get('app.locale');

    }
}


if(!function_exists('getFromToFromMonthsList')){

    function getFromToFromMonthsList($months){
        foreach ($months as $month) {
            $first_day = new DateTime(date('Y') . '-' . $month . '-01');
            $last_day = new DateTime(date('Y') . '-' . $month . '-01');
            $last_day->modify('last day of this month');

            return [$first_day->format('Y-m-d') , $last_day->format('Y-m-d')];
        }

    }

}


