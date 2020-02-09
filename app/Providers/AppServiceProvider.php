<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register airport validation rule.
         */
        Validator::extend(
            'airport',
            'App\Rules\Airport@passes'
        );
        
        Validator::extend(
            'aircraft',
            'App\Rules\Aircraft@passes'
        );
    }
}
