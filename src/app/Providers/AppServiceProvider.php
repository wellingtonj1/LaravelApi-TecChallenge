<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Sales\Domain\SaleRepositoryInterface;
use Modules\Sales\Infrastructure\EloquentSaleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SaleRepositoryInterface::class, EloquentSaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
