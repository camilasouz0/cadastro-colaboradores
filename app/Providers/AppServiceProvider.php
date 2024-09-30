<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UsersPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Persistence\Interfaces\AuthRepositoryInterface::class,
            \App\Persistence\Repository\AuthRepository::class,
            \App\Persistence\Interfaces\EmployeesRepositoryInterface::class,
            \App\Persistence\Repository\EmployeesRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UsersPolicy::class);
    }
}
