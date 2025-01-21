<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestRoute: string implements RouteInterface
{
    use RouteTrait;

    case route_1 = '/route-1';
}