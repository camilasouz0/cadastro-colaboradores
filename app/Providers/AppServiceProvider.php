<?php

namespace App\Providers;

use App\Models\User;
use App\Persistence\Interfaces\EmployeesRepositoryInterface;
use App\Persistence\Interfaces\AuthRepositoryInterface;
use App\Persistence\Repository\EmployeesRepository;
use App\Persistence\Repository\AuthRepository;
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
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(EmployeesRepositoryInterface::class, EmployeesRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UsersPolicy::class);
    }
}
