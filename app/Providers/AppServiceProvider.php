<?php

namespace App\Providers;

use App\Services\Trip\TripService;
use App\Services\Trip\TripServiceInterface;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;
use App\Services\User\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(TripServiceInterface::class, TripService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
