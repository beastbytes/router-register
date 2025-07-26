<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestPrefixRoute: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'test';

    case route_1 = '/route-1';
}