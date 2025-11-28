<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

#[Group('test-route')]
enum RouteGroup: string implements RouteInterface
{
    use RouteTrait;

    case route1 = '/route-1';
    case route2 = '//route-2';
}