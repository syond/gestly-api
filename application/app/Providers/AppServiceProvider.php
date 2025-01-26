<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\SocialAuthServiceInterface;
use App\Services\SocialAuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SocialAuthServiceInterface::class, SocialAuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
