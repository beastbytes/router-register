<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;
use BeastBytes\Router\Register\Tests\resources\Enum\Group as GroupEnum;
use BeastBytes\Router\Register\Tests\resources\Middleware\ClassLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;

#[Group('class-attributes', GroupEnum::group2)]
#[Prefix('class-attributes')]
#[Host('https://www.example1.com')]
#[Host('https://www.example2.com')]
#[Middleware(ClassLevelMiddleware::class)]
#[Middleware('fn (' . ClassLevelMiddleware::class . ' $middleware) => $middleware->withParameter("class")')]
#[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
enum ClassAttributesRoute: string implements RouteInterface
{
    use RouteTrait;

    case method1 = '';
    case method2 = '/method2';
    case method3 = '/method3/{testId}';
    case method4 = '/method4/{testId}/{userId}';
    case method5 = '/method5/{testId}[/{userId}]';
    case method6 = '/method6/{testId}';
    case method7 = '/method7/{testId}';
    case method8 = '/method8/{testId}';
    case method9 = '/method9/{testId}';
    case method10 = '/method10/{testId}';
}
