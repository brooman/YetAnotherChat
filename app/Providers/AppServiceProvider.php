<?php

namespace App\Providers;

use App\Channel;
use App\Observers\ChannelObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Channel::observe(ChannelObserver::class);
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
