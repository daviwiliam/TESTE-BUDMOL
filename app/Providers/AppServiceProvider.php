<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(UserService::class);
    }    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
