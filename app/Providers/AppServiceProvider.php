<?php

namespace App\Providers;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength('191');
        View::share('logs',AdminLog::where('seen',0)->latest('created_at')->take(4)->get());
        View::share('logsCount',AdminLog::where('seen',0)->get()->count());
    }
}
