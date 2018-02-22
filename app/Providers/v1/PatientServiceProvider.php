<?php

namespace App\Providers\v1;

use App\Models\Patient;
use App\Services\v1\PatientService;
use Illuminate\Support\ServiceProvider;

class PatientServiceProvider extends ServiceProvider
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
        $this->app->bind(PatientService::class, function ($app) {
            return new PatientService();
        });
    }
}
