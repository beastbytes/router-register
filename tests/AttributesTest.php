<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\GroupCors;
use BeastBytes\Router\Register\Attribute\GroupHost;
use BeastBytes\Router\Register\Attribute\GroupMiddleware;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Enum\TestGroup;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

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
    #[DataProvider('groupProvider')]
    public function group(?GroupInterface $group, string $name, ?string $prefix): void
    {
        $attribute = new Group(group: $group, name: $name, prefix: $prefix);

        if ($group instanceof GroupInterface) {
            self::assertSame($group->name, $attribute->getGroupName());
        } else {
            self::assertNull($attribute->getGroupName());
        }
        self::assertSame($name, $attribute->getName());
        if (is_string($prefix)) {
            self::assertSame($prefix, $attribute->getPrefix());
        } elseif (is_bool($prefix)) {
                self::assertFalse($attribute->getPrefix());
            } else {
            self::assertNull($attribute->getPrefix());
        }

    }

    #[Test]
    #[DataProvider('middlewareProvider')]
    public function groupCors(array|string $middleware, bool $disable, string $expected): void
    {
        $attribute = new GroupCors($middleware);
        self::assertSame($expected, $attribute->getMiddleware());
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
    public function groupMiddleware(array|string $middleware, bool $disable, string $expected): void
    {
        $attribute = new GroupMiddleware($middleware, $disable);;
        self::assertSame($expected, $attribute->getMiddleware());
        self::assertSame($disable, $attribute->isDisable());
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
    public function middleware(array|string $middleware, bool $disable, string $expected): void
    {
        $attribute = new Middleware($middleware, $disable);;
        self::assertSame($expected, $attribute->getMiddleware());
        self::assertSame($disable, $attribute->isDisable());
    }

    public static function defaultValueProvider(): Generator
    {
        for ($i = 0; $i < 10; $i++) {
            $parameter = self::randomString(random_int(5, 10));

            $x = random_int(1, 100);
            $value = $x % 2
                ? self::randomString(random_int(5, 10))
                : random_int(1, 100)
            ;

            yield [$parameter, $value];
        }
    }

    public static function groupProvider(): Generator
    {
        yield [TestGroup::group1, 'group-name', 'group-prefix'];
        yield [null, 'group-name', 'group-prefix'];
        yield [null, 'group-name', null];
        yield [TestGroup::group1, 'group-name', null];
    }

    public static function middlewareProvider(): Generator
    {
        foreach ([
            "'" . MethodLevelMiddleware::class . "'" => MethodLevelMiddleware::class,
            'fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")'
                => 'fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")',
            "['class' => '" . MethodLevelMiddleware::class . "', 'withParameter()' => ['test']]"
                => ['class' => MethodLevelMiddleware::class, 'withParameter()' => ["test"]],
        ] as $expected => $middleware) {
            foreach ([true, false] as $disable) {
                yield [$middleware, $disable, $expected];
            }
        }
    }

    private static function randomString(int $length): string
    {
        return substr(
            strtr(
                base64_encode(random_bytes((int) ceil($length * 0.75))),
                '+/',
                '-_'
            ),
            0,
            $length
        );
    }
}