<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestRoute: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'test';

    case method1 = '/test';
    case method2 = '/test/method2/{testId}';
    case method3 = '/test/method3/{testId}/{userId}';
    case method4 = '/test/method4/{testId}[/{userId}]';
}
