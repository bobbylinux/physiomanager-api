<?php

namespace App\Providers\v1;

use App\Services\v1\PainService;
use Illuminate\Support\ServiceProvider;

class PainServiceProvider extends ServiceProvider
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
        $this->app->bind(PainService::class, function ($app) {
            return new PainService();
        });
    }
}
