<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\Prefix;
use \Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class PrefixTest extends TestCase
{
    #[Test]
    #[DataProvider('prefixProvider')]
    public function prefix(string $routePrefix, ?string $namePrefix): void
    {
        $attribute = new Prefix($routePrefix, $namePrefix);
        self::assertSame($routePrefix, $attribute->getRoutePrefix());
        self::assertSame($namePrefix, $attribute->getNamePrefix());
    }

    public static function prefixProvider(): Generator
    {
        yield [
            'routePrefix' => Random::string(random_int(5, 10)),
            'namePrefix' => null,
        ];
        yield [
            'routePrefix' => Random::string(random_int(5, 10)),
            'namePrefix' => Random::string(random_int(5, 10)),
        ];
    }
}
