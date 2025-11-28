<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\Cors;
use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Tests\resources\Enum\Group as GroupEnum;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AttributesTest extends TestCase
{
    #[Test]
    #[DataProvider('middlewareProvider')]
    public function cors(array|string $middleware, bool $disable, string $expected): void
    {
        $attribute = new Cors($middleware);
        self::assertSame($expected, $attribute->getMiddleware());
    }

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
    public function group(string $name, ?GroupInterface $parent): void
    {
        $attribute = new Group($name, $parent);
        self::assertSame($name, $attribute->getName());
        self::assertSame($parent, $attribute->getParent());
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

    #[Test]
    #[DataProvider('prefixProvider')]
    public function prefix(array|string $prefix, string $expected): void
    {
        $attribute = new Prefix($prefix);
        self::assertSame($expected, $attribute->getPrefix());
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
        yield ['group', null];
        yield ['group', GroupEnum::group1];
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

    public static function prefixProvider(): Generator
    {
        yield ['prefix', '/prefix'];
        yield [
            [
                'prefix',
                'param' => '[a-z]{2}'
            ],
            '/prefix/{param:[a-z]{2}}'
        ];
    }

    private static function randomString(int $length): string
    {
        return substr(
            strtr(
                base64_encode(random_bytes((int) ceil($length * 0.75))),
                '+/',
                '-_',
            ),
            0,
            $length,
        );
    }
}