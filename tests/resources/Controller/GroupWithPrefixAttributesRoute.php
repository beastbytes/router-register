<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;
use BeastBytes\Router\Register\Tests\resources\Enum\GroupWithPrefix;
use BeastBytes\Router\Register\Tests\resources\Middleware\ClassLevelMiddleware;

#[Group('group-attributes', GroupWithPrefix::group1)]
#[Middleware(ClassLevelMiddleware::class)]
enum GroupWithPrefixAttributesRoute: string implements RouteInterface
{
    use RouteTrait;

    case method1 = '';
    case method2 = '/method2/{id}';
    case method3 = '/{id}';
}
