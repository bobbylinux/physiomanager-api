<?php

namespace App\Providers\v1;

use App\Services\v1\PhysiotherapistService;
use Illuminate\Support\ServiceProvider;

class PhysiotherapistServiceProvider extends ServiceProvider
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
        $this->app->bind(PhysiotherapistService::class, function ($app) {
            return new PhysiotherapistService();
        });
    }
}
