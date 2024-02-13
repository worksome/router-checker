<?php

declare(strict_types=1);

namespace Worksome\RouteChecker;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RouteCheckCommand extends Command
{
    /** {@inheritdoc} */
    protected $signature = 'route:check';

    /** {@inheritdoc} */
    protected $description = 'Checks if all the routes have valid controllers';

    public function handle(Router $router): int
    {
        $invalidRoutes = Collection::make($router->getRoutes())->filter(function (Route $route) {
            $uses = $route->getAction('uses');

            if ($uses instanceof Closure) {
                return false;
            }

            $controller = Str::parseCallback($route->getAction('uses'));

            return ! method_exists(...$controller);
        })->map(fn (Route $route) => [
            $route->getName() ?? $route->uri(),
            $route->getActionName(),
        ]);

        if ($invalidRoutes->isEmpty()) {
            $this->info('No invalid routes found');

            return self::SUCCESS;
        }

        $this->error("Found {$invalidRoutes->count()} invalid routes");

        $this->table(
            ['name', 'action'],
            $invalidRoutes->all(),
        );

        return self::FAILURE;
    }
}
