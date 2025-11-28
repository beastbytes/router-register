<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Tests\resources\Enum\RouteGroup;
use BeastBytes\Router\Register\Tests\resources\Enum\RouteGroupWithParentGroup;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RouteNameTest extends TestCase
{
    #[Test]
    #[DataProvider('routeProvider')]
    public function routeName(RouteInterface $route, string $name): void
    {
        self::assertSame($name, $route->getRouteName());
    }

    public static function routeProvider(): Generator
    {
        yield 'route' => [RouteGroup::route1, 'test-route.route1'];
        yield 'hoistedRoute' => [RouteGroup::route2, 'test-route.route2'];
        yield 'routeInGroup' => [RouteGroupWithParentGroup::route1, 'group1.test-route.route1'];
        yield 'hoistedRouteInGroup' => [RouteGroupWithParentGroup::route2, 'group1.test-route.route2'];
    }
}
