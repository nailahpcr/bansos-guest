<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProgramBantuan;
use Illuminate\Support\Facades\Route;

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
        // Explicit route model binding for ProgramBantuan
        Route::model('program', ProgramBantuan::class);
    }
}
