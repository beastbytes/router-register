<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum TestRoute: string implements RouteInterface
{
    use RouteTrait;

    case route_1 = '/route-1';
}