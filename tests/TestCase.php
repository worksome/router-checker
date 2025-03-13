<?php

declare(strict_types=1);

namespace Worksome\RouteChecker\Tests;

use Worksome\RouteChecker\RouteCheckerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RouteCheckerServiceProvider::class,
        ];
    }
}
