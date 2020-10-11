<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(App::environment() === 'production') {
            URL::forceScheme('https');
        }
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

        Validator::extend(
            'apiAircraft',
            'App\Rules\APIAircraft@passes'
        );
    }
}
