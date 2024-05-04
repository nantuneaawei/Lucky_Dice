<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\Facades\Random;

class RandomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('Random', function ($app) {
            return new Random();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
