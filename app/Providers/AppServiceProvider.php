<?php

namespace App\Providers;

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
        // Permission-based authorization is handled by Spatie's
        // `register_permission_check_method` (enabled in config/permission.php),
        // which registers the permission check method on Laravel's Gate.
        // No custom Gate definitions are required here.
    }
}
