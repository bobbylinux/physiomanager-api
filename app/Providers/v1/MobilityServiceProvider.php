<?php

namespace App\Providers\v1;

use App\Services\v1\MobilityService;
use Illuminate\Support\ServiceProvider;

class MobilityServiceProvider extends ServiceProvider
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
        $this->app->bind(MobilityService::class, function ($app) {
            return new MobilityService();
        });
    }
}
