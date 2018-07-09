<?php

namespace App\Providers\v1;

use App\Services\v1\ProgramService;
use Illuminate\Support\ServiceProvider;

class ProgramServiceProvider extends ServiceProvider
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
        $this->app->bind(ProgramService::class, function ($app) {
            return new ProgramService();
        });
    }
}
