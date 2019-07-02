<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Contracts\ReportRepositoryInterface', 'App\Repositories\ReportRepository');
        $this->app->bind('App\Contracts\OutletRepositoryInterface', 'App\Repositories\OutletRepository');
        $this->app->bind('App\Contracts\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Contracts\CompanyRepositoryInterface', 'App\Repositories\CompanyRepository');
    }
}