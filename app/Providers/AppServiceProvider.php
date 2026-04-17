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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share Landing Page CMS data with all views
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('landing_pages')) {
                $cms = \App\Models\LandingPage::pluck('value', 'key')->toArray();
                \Illuminate\Support\Facades\View::share('cms', $cms);
            }
        } catch (\Exception $e) {
            // DB might not be ready during build or migrations
        }
    }
}
