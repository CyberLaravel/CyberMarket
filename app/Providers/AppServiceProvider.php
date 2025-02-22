<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Check if the application is running in production environment
        if (App::environment('production')) {
            // Force HTTPS by setting the server variable
            // This ensures that all requests are treated as HTTPS requests
            // Useful when running behind a load balancer or proxy
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs in production environment
        // This ensures that all generated URLs use HTTPS protocol
        // Important for security in production environments
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }


        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        User::observe(UserObserver::class);
    }
}
