<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Binding the UserServiceInterface to UserService
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    public function boot()
    {
        //
    }
}
