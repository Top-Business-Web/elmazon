<?php
//check current language
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

if (!function_exists('lang')) {

    function lang()
    {
        return Config::get('app.locale');

    }
}


if (!function_exists('month_with_zero')) {

    function month_with_zero($number)
    {
        return ($number < 10) ? '0' . $number : $number;

    }
}

if (!function_exists('file_size')) {
    /**
     * @param $filePath
     * @return string
     */
    function file_size($filePath): string
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze($filePath);
        return number_format($file['filesize'] / 1024);
    }
}

if (!function_exists('video_duration')) {
    /**
     * @param $videoPath
     * @return string
     */
    function video_duration($videoPath): string
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze($videoPath);
        return $file['playtime_string'];
    }
}

if (!function_exists('saveFile')) {

    function saveFile($folder,$file): string
    {
        $path = public_path($folder);
        $file_name = rand('1', '9999') . time()  . '.' . $file->getClientOriginalExtension();
        $file->move($path, $file_name);
        return $file_name;
    }
}


if (!function_exists('getFromToFromMonthsList')) {

    function getFromToFromMonthsList($months)
    {
        $first_day = new DateTime(date('Y') . '-' . $months[0] . '-01');
        foreach ($months as $month) {

            $last_day = new DateTime(date('Y') . '-' . $month . '-01');
            $last_day->modify('last day of this month');
        }
        return [$first_day->format('Y-m-d'), $last_day->format('Y-m-d')];
    }

}
if (!function_exists('getFromToMonthsList')) {

    function getFromToMonthsList($date_from, $date_to)
    {
        $months = [];
        $result = CarbonPeriod::create($date_from, '1 month', $date_to);

        foreach ($result as $dt) {
            array_push($months, $dt->format("j"));
        }
        return $months;
    }

}


