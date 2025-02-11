<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        // if APP_ENV=production
        // this will prohibit these commands:
        // db:wipe
        // migration:fresh
        // migration:refresh
        // migration:reset
        DB::prohibitDestructiveCommands($this->app->isProduction());
    }
}
