<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;
use BeastBytes\Router\Register\Tests\resources\Enum\Group as GroupEnum;

#[Group('test-route', GroupEnum::group1)]
#[Prefix('test-route')]
enum RouteGroupWithParentGroup: string implements RouteInterface
{
    use RouteTrait;

    case route1 = 'route-1';
    case route2 = '//route-2';
}