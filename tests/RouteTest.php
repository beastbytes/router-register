<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\Method\All;
use BeastBytes\Router\Register\Attribute\Method\Delete;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\GetPost;
use BeastBytes\Router\Register\Attribute\Method\Head;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Method\Options;
use BeastBytes\Router\Register\Attribute\Method\Patch;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Method\Put;
use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\Tests\resources\Route\TestRoute;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    #[Test]
    public function all(): void
    {
        $route = new All(TestRoute::route_1);
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
            ]
        );
    }

    #[Test]
    public function delete(): void
    {
        $route = new Delete(TestRoute::route_1);
        $this->assertions($route, [Method::DELETE->name]);
    }

    #[Test]
    public function get(): void
    {
        $route = new Get(TestRoute::route_1);
        $this->assertions($route, [Method::GET->name]);
    }

    #[Test]
    public function getPost(): void
    {
        $route = new GetPost(TestRoute::route_1);
        $this->assertions($route, [Method::GET->name, Method::POST->name]);
    }

    #[Test]
    public function head(): void
    {
        $route = new Head(TestRoute::route_1);
        $this->assertions($route, [Method::HEAD->name]);
    }

    #[Test]
    public function options(): void
    {
        $route = new Options(TestRoute::route_1);
        $this->assertions($route, [Method::OPTIONS->name]);
    }

    #[Test]
    public function patch(): void
    {
        $route = new Patch(TestRoute::route_1);
        $this->assertions($route, [Method::PATCH->name]);
    }

    #[Test]
    public function post(): void
    {
        $route = new Post(TestRoute::route_1);
        $this->assertions($route, [Method::POST->name]);
    }

    #[Test]
    public function put(): void
    {
        $route = new Put(TestRoute::route_1);
        $this->assertions($route, [Method::PUT->name]);
    }

    #[Test]
    public function route(): void
    {
        $route = new Route([Method::GET, Method::POST], TestRoute::route_1);
        $this->assertions($route, [Method::GET->name, Method::POST->name]);
    }

    private function assertions($route, $methods): void
    {
        self::assertSame($methods, $route->getMethods());
        self::assertSame(TestRoute::route_1->name, $route->getName());
    }
}