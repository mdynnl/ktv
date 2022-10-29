<?php

namespace App\Providers;

use App\Models\CurrentOperationDate;
use App\Models\ServiceStaffRate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('OperationDate', function () {
            return CurrentOperationDate::first()->operation_date;
        });

        $this->app->singleton('ServiceStaffRate', function () {
            return ServiceStaffRate::first()->service_staff_rate;
        });

        $this->app->singleton('ServiceStaffRates', function () {
            return ServiceStaffRate::first();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
