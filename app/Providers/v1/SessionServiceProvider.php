<?php
namespace App\Providers\v1;

use App\Services\v1\SessionService;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
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
        $this->app->bind(SessionService::class, function ($app) {
            return new SessionService();
        });
    }
}
