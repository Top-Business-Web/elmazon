<?php

namespace App\Providers;

use App\Http\Interfaces\AuthRepositoryInterface;
use App\Http\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){

        $this->app->bind(AuthRepositoryInterface::class,AuthRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
