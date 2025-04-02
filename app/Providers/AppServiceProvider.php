<?php

namespace App\Providers;

use App\Repositories\Eloquent\Concession\ConcessionInterface;
use App\Repositories\Eloquent\Concession\ConcessionRepository;
use App\Repositories\Eloquent\Order\OrderInterface;
use App\Repositories\Eloquent\Order\OrderRepository;
use App\Repositories\Eloquent\User\UserInterface;
use App\Repositories\Eloquent\User\UserRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ConcessionInterface::class, ConcessionRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Vite::prefetch(concurrency: 3);
    }
}
