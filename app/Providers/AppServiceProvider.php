<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Nederlandse URL's in de admin: /admin/trainingen/nieuw en /admin/trainingen/{id}/bewerken.
        Route::resourceVerbs(['create' => 'nieuw', 'edit' => 'bewerken']);
    }
}
