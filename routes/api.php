<?php

use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Authentication\AuthLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthLoginController::class, 'login'])->name('login');
    Route::post('register', [AuthLoginController::class, 'register'])->name('register');

    Route::prefix('employee')->group(function () {
        Route::get('/{id}', [EmployeesController::class, 'findByEmployee'])->name('findByEmployee');
    });
});
