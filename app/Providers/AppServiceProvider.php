<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProgramBantuan;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        // Morph map for polymorphic relationships
        Relation::morphMap([
            'App\Models\ProgramBantuan' => ProgramBantuan::class,
        ]);

        // Explicit route model binding for ProgramBantuan
        Route::model('program', ProgramBantuan::class);
    }
}
