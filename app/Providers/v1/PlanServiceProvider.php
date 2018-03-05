<?php

namespace App\Providers\v1;

use App\Services\v1\PlanService;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
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
        $this->app->bind(PlanService::class, function ($app) {
            return new PlanService();
        });
    }
}
