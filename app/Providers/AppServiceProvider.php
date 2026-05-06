<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

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
        // Define broadcast channel authorization
        Broadcast::channel('community.group.{groupId}', function ($user, $groupId) {
            // Allow any authenticated user to join the channel
            return (bool) $user;
        });
    }
}
