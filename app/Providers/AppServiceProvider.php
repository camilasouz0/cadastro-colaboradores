<?php

namespace App\Providers;

use App\Persistence\Interfaces\AuthUseCaseInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Persistence\Interfaces\AuthUseCaseInterface::class,
            \App\Persistence\Repository\AuthRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
