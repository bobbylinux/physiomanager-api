<?php

namespace App\Providers\v1;

use App\Services\v1\TherapyService;
use Illuminate\Support\ServiceProvider;

class TherapyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TherapyService::class, function ($app) {
            return new TherapyService();
        });
    }
}
