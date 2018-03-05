<?php

namespace App\Providers\v1;

use App\Services\v1\WorkResultService;
use Illuminate\Support\ServiceProvider;

class WorkResultServiceProvider extends ServiceProvider
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
        $this->app->bind(WorkResultService::class, function ($app) {
            return new WorkResultService();
        });
    }
}
