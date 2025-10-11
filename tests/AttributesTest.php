<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\GroupCors;
use BeastBytes\Router\Register\Attribute\GroupHost;
use BeastBytes\Router\Register\Attribute\GroupMiddleware;
use BeastBytes\Router\Register\Attribute\GroupNamePrefix;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Route\TestGroup;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class AttributesTest extends TestCase
{
    #[Test]
    #[DataProvider('defaultValueProvider')]
    public function defaultValue(string $parameter, int|string $value): void
    {
        $defaultValue = new DefaultValue($parameter, $value);
        self::assertSame($parameter, $defaultValue->getParameter());
        self::assertSame((string) $value, $defaultValue->getValue());
    }
    #[Test]
    public function group(): void
    {
        $group = TestGroup::group1;
        $attribute = new Group($group);

        self::assertSame($group->getName(), $attribute->getName());
        self::assertSame($group->getNamePrefix(), $attribute->getNamePrefix());
    }

    #[Test]
    #[DataProvider('middlewareProvider')]
    public function groupCora(array|string $middleware, bool $disable): void
    {
        $attribute = new GroupCors($middleware);
        self::assertSame($middleware, $attribute->getMiddleware());
    }

    #[Test]
    public function groupHost(): void
    {
        $host = 'localhost';
        $attribute = new GroupHost($host);
        self::assertSame($host, $attribute->getHost());
    }

    #[Test]
    #[DataProvider('middlewareProvider')]
    public function groupMiddleware(array|string $middleware, bool $disable): void
    {
        $attribute = new GroupMiddleware($middleware, $disable);;
        self::assertSame($middleware, $attribute->getMiddleware());
        self::assertSame($disable, $attribute->disable());
    }

    #[Test]
    public function host(): void
    {
        $host = 'localhost';
        $attribute = new Host($host);
        self::assertSame($host, $attribute->getHost());
    }

    #[Test]
    #[DataProvider('middlewareProvider')]
    public function middleware(array|string $middleware, bool $disable): void
    {
        $attribute = new Middleware($middleware, $disable);;
        self::assertSame($middleware, $attribute->getMiddleware());
        self::assertSame($disable, $attribute->disable());
    }

    public static function defaultValueProvider(): Generator
    {
        for ($i = 0; $i < 10; $i++) {
            $parameter = Random::string(random_int(5, 10));

            $x = random_int(1, 100);
            $value = $x % 2
                ? Random::string(random_int(5, 10))
                : random_int(1, 100)
            ;

            yield [$parameter, $value];
        }
    }

    public static function middlewareProvider(): Generator
    {
        foreach ([
            MethodLevelMiddleware::class,
            'fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")',
            ['class' => MethodLevelMiddleware::class, 'withParameter()' => ["test"]],
        ] as $middleware) {
            foreach ([true, false] as $disable) {
                yield [$middleware, $disable];
            }
        }
    }
}