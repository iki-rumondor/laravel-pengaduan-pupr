<?php

namespace App\Providers;

use App\Services\PengaduanService;
use App\Services\Impl\PengaduanServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides()
    {
        return [
            PengaduanService::class
        ];
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PengaduanService::class, PengaduanServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
