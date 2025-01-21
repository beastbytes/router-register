<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Tests\resources\Middleware\CorsMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware1;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware2;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware3;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware4;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class GroupTest extends TestCase
{
    #[Test]
    #[DataProvider('groupProvider')]
    public function group(
        ?string $prefix,
        array|string $hosts,
        array|string $cors,
        array|string $middleware,
        array|string $disabledMiddleware,
        ?string $namePrefix,
    ): void
    {
        $attribute = new Group(
            prefix: $prefix,
            hosts: $hosts,
            cors: $cors,
            middleware: $middleware,
            disabledMiddleware: $disabledMiddleware,
            namePrefix: $namePrefix
        );
        self::assertSame($prefix, $attribute->getPrefix());
        self::assertSame(
            is_array($hosts) ? $hosts : [$hosts],
            $attribute->getHosts()
        );
        self::assertSame($cors, $attribute->getCors());
        self::assertSame(
            is_array($middleware) ? $middleware : [$middleware],
            $attribute->getMiddleware()
        );
        self::assertSame(
            is_array($disabledMiddleware) ? $disabledMiddleware : [$disabledMiddleware],
            $attribute->getDisabledMiddleware()
        );
        self::assertSame($namePrefix, $attribute->getNamePrefix());

        if (is_string($prefix)) {
            self::assertSame(trim($prefix, '/'), $attribute->getName());
        } else {
            self::assertNull($attribute->getName());
        }
    }

    public static function groupProvider(): Generator
    {
        $hosts = [[], 'https://example.com', ['https://example.com', 'https://example1.com']];
        $corsMiddlewares = [[], CorsMiddleware::class];
        $middlewares = [[], Middleware1::class, [Middleware1::class, Middleware2::class, ]];
        $disabledMiddlewares = [[], Middleware3::class, [Middleware3::class, Middleware4::class, ]];

        for ($i = 0; $i < 10; $i++) {
            $prefix = Random::string(random_int(5, 10));
            $namePrefix = Random::string(random_int(5, 10));

            foreach ($hosts as $host) {
                foreach ($corsMiddlewares as $cors) {
                    foreach ($middlewares as $middleware) {
                        foreach ($disabledMiddlewares as $disabledMiddleware) {
                            yield [$prefix, $host, $cors, $middleware, $disabledMiddleware, $namePrefix];
                        }
                    }
                }
            }
        }
    }
}
