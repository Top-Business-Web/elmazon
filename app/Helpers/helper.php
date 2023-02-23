<?php
//check current language
use Illuminate\Support\Facades\Config;

if(!function_exists('lang')){

    function lang(){
        return Config::get('app.locale');

    }
}

