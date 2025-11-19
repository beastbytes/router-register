<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Route\RouteInterface;

enum TestRoute: string implements RouteInterface
{
    case route_1 = '/route-1';
}