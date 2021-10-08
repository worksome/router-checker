<?php

namespace Worksome\RouteChecker;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class RouteCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if all the routes have valid controllers';

    /**
     * Execute the console command.
     */
    public function handle(Router $router): int
    {
        $invalidRoutes = collect($router->getRoutes())->filter(function (Route $route) {
            $controller = Str::parseCallback($route->getAction('uses'));

            return !method_exists(...$controller);
        })->map(fn(Route $route) => [
            $route->getName() ?? $route->uri(),
            $route->getActionName(),
        ]);

        $this->error("Found {$invalidRoutes->count()} invalid routes");

        $this->table(
            ['name', 'action'],
            $invalidRoutes->all(),
        );

        return $invalidRoutes->isNotEmpty() ? 1 : 0;
    }
}