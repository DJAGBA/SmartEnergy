<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\CustomNotification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force Laravel à utiliser ton modèle avec ID bigint
        $this->app->bind(DatabaseNotification::class, CustomNotification::class);
    }
}