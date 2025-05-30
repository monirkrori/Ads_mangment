<?php

namespace App\Providers;

use App\Enums\Permission;
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
        Gate::define(Permission::APPROVE_AD->value, fn($user) => $user->isAdmin());
        Gate::define(Permission::CREATE_CATEGORY->value, fn($user) => $user->isAdmin());
        Gate::define(Permission::DELETE_REVIEW->value, fn($user, $review) => $user->id === $review->user_id || $user->isAdmin());
    }
}
