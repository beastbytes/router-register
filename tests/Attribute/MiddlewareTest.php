<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\Middleware;
use \Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class MiddlewareTest extends TestCase
{
    #[Test]
    #[DataProvider('middlewareProvider')]
    public function middleware(string $middleware): void
    {
        $attribute = new Middleware($middleware);
        self::assertSame($middleware, $attribute->getMiddleware());
    }

    public static function middlewareProvider(): Generator
    {
        yield [Random::string(random_int(5, 10))];
    }
}
