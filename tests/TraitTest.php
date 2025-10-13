<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Tests\resources\Trait\TestGroup;
use BeastBytes\Router\Register\Tests\resources\Trait\TestGroupWithPrefix;
use BeastBytes\Router\Register\Tests\resources\Trait\TestRoute;
use BeastBytes\Router\Register\Tests\resources\Trait\TestRouteWithGroup;
use BeastBytes\Router\Register\Tests\resources\Trait\TestRouteWithGroupAndPrefix;
use BeastBytes\Router\Register\Tests\resources\Trait\TestRouteWithGroupPrefix;
use BeastBytes\Router\Register\Tests\resources\Trait\TestRouteWithPrefix;
use HttpSoft\Message\Uri;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Router\FastRoute\UrlGenerator;
use Yiisoft\Router\Route;
use Yiisoft\Router\RouteCollection;
use Yiisoft\Router\RouteCollector;

class TraitTest extends TestCase
{
    #[Test]
    public function group(): void
    {
        self::assertSame('group1', TestGroup::group1->getName());
        self::assertSame('group1.', TestGroup::group1->getNamePrefix());
        self::assertSame('/g1', TestGroup::group1->getRoutePrefix());
    }

    #[Test]
    public function group_with_prefix(): void
    {
        self::assertSame('group1', TestGroupWithPrefix::group1->getName());
        self::assertSame('group1.', TestGroupWithPrefix::group1->getNamePrefix());
        self::assertSame('/example/{locale:[a-z]{2}}/g1', TestGroupWithPrefix::group1->getRoutePrefix());
    }

    #[Test]
    public function route(): void
    {
        self::assertSame('route_1', TestRoute::route_1->getName());
        self::assertSame('route_1', TestRoute::route_1->getRouteName());
        self::assertSame('/route-1', TestRoute::route_1->getUri());
    }

    #[Test]
    public function route_with_group(): void
    {
        self::assertSame('route_1', TestRouteWithGroup::route_1->getName());
        self::assertSame('group1.route_1', TestRouteWithGroup::route_1->getRouteName());
        self::assertSame('/g1/route-1', TestRouteWithGroup::route_1->getUri());
    }

    #[Test]
    public function route_with_prefix(): void
    {
        self::assertSame('prefix.route_1', TestRouteWithPrefix::route_1->getName());
        self::assertSame('prefix.route_1', TestRouteWithPrefix::route_1->getRouteName());
        self::assertSame('/route-1', TestRouteWithPrefix::route_1->getUri());
    }

    #[Test]
    public function route_with_group_and_prefix(): void
    {
        self::assertSame('prefix.route_1', TestRouteWithGroupAndPrefix::route_1->getName());
        self::assertSame('group1.prefix.route_1', TestRouteWithGroupAndPrefix::route_1->getRouteName());
        self::assertSame('/g1/route-1', TestRouteWithGroupAndPrefix::route_1->getUri());
    }

    #[Test]
    public function route_with_group_prefix(): void
    {
        self::assertSame('prefix.route_1', TestRouteWithGroupPrefix::route_1->getName());
        self::assertSame('group1.prefix.route_1', TestRouteWithGroupPrefix::route_1->getRouteName());
        self::assertSame('/example/{locale:[a-z]{2}}/g1/route-1', TestRouteWithGroupPrefix::route_1->getUri());
    }
}