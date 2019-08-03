<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\IpInfo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(IpInfo::class, function($app){
            return IpInfo::make();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
