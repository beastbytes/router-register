<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestRoute: string implements RouteInterface
{
    use RouteTrait;

    case test_index = '/index';
    case test_user = '/test/{testId}/{userId}';
    case test_view = '/test/{testId}';
}
