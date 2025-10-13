<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Trait;

use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum TestRouteWithGroupPrefix: string implements RouteInterface
{
    use RouteTrait;

    public const GROUP = TestGroupWithPrefix::group1;
    public const PREFIX = 'prefix';

    case route_1 = '/route-1';
}