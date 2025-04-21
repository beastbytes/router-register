<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestRoute: string implements RouteInterface
{
    use RouteTrait;

    case test_method1 = '/test';
    case test_method2 = '/test/method2/{testId}';
    case test_method3 = '/test/method3/{testId}/{userId}';
    case test_method4 = '/test/method4/{testId}[/{userId}]';
}
