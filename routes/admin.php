<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\TrainingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Beheeromgeving (/admin)
|--------------------------------------------------------------------------
|
| Er is geen openbare registratie: een beheerder voegt een nieuwe beheerder
| toe via /admin/beheerders, die krijgt dan een mail om een wachtwoord in te stellen.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/inloggen', [AuthController::class, 'show'])->name('login');
        Route::post('/inloggen', [AuthController::class, 'store'])->name('login.store');

        Route::get('/wachtwoord-vergeten', [PasswordController::class, 'request'])->name('password.request');
        Route::post('/wachtwoord-vergeten', [PasswordController::class, 'email'])->middleware('throttle:5,1')->name('password.email');
        Route::get('/wachtwoord-instellen/{token}', [PasswordController::class, 'edit'])->name('password.reset');
        Route::post('/wachtwoord-instellen', [PasswordController::class, 'update'])->middleware('throttle:10,1')->name('password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/uitloggen', [AuthController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('lesrooster', LessonController::class)
            ->parameters(['lesrooster' => 'lesson'])->except('show')->names('lessons');
        Route::resource('trainingen', TrainingController::class)
            ->parameters(['trainingen' => 'training'])->except('show')->names('trainings');
        Route::resource('tarieven', PriceController::class)
            ->parameters(['tarieven' => 'price'])->except('show')->names('prices');
        Route::resource('beheerders', AdminUserController::class)
            ->parameters(['beheerders' => 'user'])->only(['index', 'create', 'store', 'destroy'])->names('users');

        Route::get('/account', [AccountController::class, 'edit'])->name('account');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::put('/account/wachtwoord', [AccountController::class, 'password'])->name('account.password');
    });
});
