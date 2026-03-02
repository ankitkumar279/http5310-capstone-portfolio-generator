<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fix mixed-content on Render (https site but assets generated as http)
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}