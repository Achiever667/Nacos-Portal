<?php

namespace App\Providers;

use App\Domains\Programs\Models\Program;
use App\Domains\Programs\Policies\ProgramPolicy;
use App\Domains\Students\Models\Student;
use App\Domains\Students\Policies\StudentPolicy;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::before(function (User $user, string $ability) {
            return $user->isSuperAdmin() ? true : null;
        });

        Gate::policy(Student::class, StudentPolicy::class);
        Gate::policy(Program::class, ProgramPolicy::class);
    }
}
