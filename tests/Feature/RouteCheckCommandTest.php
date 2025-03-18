<?php

declare(strict_types=1);

use Worksome\RouteChecker\RouteCheckCommand;

it('registers command', function (string $command) {
    $this->artisan($command)
        ->assertOk();
})
    ->with([
        'named' => 'route:check',
        'class' => RouteCheckCommand::class,
    ]);
