<?php

namespace App\Providers;

use App\Core\Modules\ModuleManager;
use App\Core\Modules\ModuleRegistry;
use App\Core\Tenancy\TenantContext;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register TenantContext as a singleton
        $this->app->singleton(TenantContext::class);

        // Register Module Registry as a singleton
        $this->app->singleton(ModuleRegistry::class);

        // Register Module Manager
        $this->app->singleton(ModuleManager::class, function ($app) {
            return new ModuleManager($app->make(ModuleRegistry::class));
        });
    }

    public function boot(): void
    {
        // Gate for super admin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Administrator')) {
                return true;
            }
        });
    }
}
