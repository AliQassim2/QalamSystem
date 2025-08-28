<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\Eloquent\SendCodeDirectRepository;
use App\Repositories\Eloquent\SendCodeQueueRepository;
use App\Repositories\interface\SendCodeInterface;

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
        view()->share('AppName', 'Qalam');
        Paginator::useBootstrap();
        $this->app->bind(SendCodeInterface::class, SendCodeQueueRepository::class);
    }
}
