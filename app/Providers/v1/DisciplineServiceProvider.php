<?php

namespace App\Providers\v1;

use App\Services\v1\DisciplineService;
use Illuminate\Support\ServiceProvider;

class DisciplineServiceProvider extends ServiceProvider
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
        $this->app->bind(DisciplineService::class, function ($app) {
            return new DisciplineService();
        });
    }
}
