<?php

declare(strict_types=1);

namespace Worksome\RouteChecker;

use Illuminate\Support\ServiceProvider;

class RouteCheckerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RouteCheckCommand::class
            ]);
        }
    }
}
