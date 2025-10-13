<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Trait;

use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum TestRouteWithPrefix: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'prefix';

    case route_1 = '/route-1';
}