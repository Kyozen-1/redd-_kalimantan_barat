<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\FileStorageInterface;
use App\Services\Storage\FileStorageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            FileStorageInterface::class,
            FileStorageService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
