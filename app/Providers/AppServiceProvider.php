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
        // Force HTTPS for ngrok and production
        if (config('app.env') === 'production' || 
            request()->header('x-forwarded-proto') === 'https' ||
            str_contains(request()->getHost(), 'ngrok.io')) {
            \URL::forceScheme('https');
        }
        
        // Trust ngrok proxy headers
        if (request()->header('x-forwarded-proto') === 'https') {
            request()->server->set('HTTPS', 'on');
        }
        
        // Set secure cookie settings for ngrok
        if (str_contains(request()->getHost(), 'ngrok.io')) {
            config([
                'session.secure' => true,
                'session.same_site' => 'none'
            ]);
        }
    }
}
