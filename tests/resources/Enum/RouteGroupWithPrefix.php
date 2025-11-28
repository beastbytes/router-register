<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

#[Group('test')]
#[Prefix('prefix')]
enum RouteGroupWithPrefix: string implements RouteInterface
{
    use RouteTrait;

    case route_1 = '/route-1';
}