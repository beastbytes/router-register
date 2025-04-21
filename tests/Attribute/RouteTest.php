<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\Method\All;
use BeastBytes\Router\Register\Attribute\Method\Delete;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Head;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Method\Options;
use BeastBytes\Router\Register\Attribute\Method\Patch;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Method\Put;
use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware1;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware2;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware3;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware4;
use BeastBytes\Router\Register\Tests\resources\Route\TestRoute;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    #[Test]
    #[DataProvider('routeProvider')]
    public function all(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new All(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions(
            $route,
            [
                Method::DELETE->name,
                Method::GET->name,
                Method::HEAD->name,
                Method::OPTIONS->name,
                Method::PATCH->name,
                Method::POST->name,
                Method::PUT->name,
            ],
            $hosts,
            $middleware,
            $disabledMiddleware
        );
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function delete(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Delete(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::DELETE->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function get(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Get(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::GET->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function head(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Head(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::HEAD->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function options(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Options(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::OPTIONS->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function patch(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Patch(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::PATCH->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function post(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Post(
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::POST->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function put(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Put(
            route: TestRoute::route_1, 
            hosts: $hosts, 
            middleware: $middleware, 
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::PUT->name], $hosts, $middleware, $disabledMiddleware);
    }

    #[Test]
    #[DataProvider('routeProvider')]
    public function route(mixed $hosts, mixed $middleware, mixed $disabledMiddleware): void
    {
        $route = new Route(
            methods: [Method::GET, Method::POST],
            route: TestRoute::route_1,
            hosts: $hosts,
            middleware: $middleware,
            disableMiddleware: $disabledMiddleware
        );
        $this->assertions($route, [Method::GET->name, Method::POST->name], $hosts, $middleware, $disabledMiddleware);
    }

    private function assertions($route, $methods, $hosts, $middleware, $disabledMiddleware): void
    {
        self::assertSame($methods, $route->getMethods());
        self::assertSame(TestRoute::route_1->getName(), $route->getName());
        self::assertSame(
            is_array($hosts)
                ? $hosts
                : [$hosts],
            $route->getHosts()
        );
        self::assertSame(
            is_array($middleware)
                ? $middleware
                : [$middleware],
            $route->getMiddleware()
        );
        self::assertSame(
            is_array($disabledMiddleware)
                ? $disabledMiddleware
                : [$disabledMiddleware],
            $route->getDisableMiddleware()
        );
    }

    public static function routeProvider(): Generator
    {
        $hosts = [[], 'https://example.com', ['https://example.com', 'https://example1.com']];
        $middlewares = [[], Middleware1::class, [Middleware1::class, Middleware2::class, ]];
        $disabledMiddlewares = [[], Middleware3::class, [Middleware3::class, Middleware4::class, ]];
        
        foreach ($hosts as $host) {
            foreach ($middlewares as $middleware) {
                foreach ($disabledMiddlewares as $disabledMiddleware) {
                    yield [$host, $middleware, $disabledMiddleware];
                }
            }
        }
    }
}