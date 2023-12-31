<?php

namespace App\Providers;

use App\Repositories\Affiliate\AffiliateEloquenteORM;
use App\Repositories\Affiliate\AffiliateRepositoryInterface;
use App\Repositories\Customer\CustomerEloquentORM;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Employee\EmployeeEloquentORM;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CustomerRepositoryInterface::class, CustomerEloquentORM::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeEloquentORM::class);
        $this->app->bind(AffiliateRepositoryInterface::class, AffiliateEloquenteORM::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
