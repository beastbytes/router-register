<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class DefaultValueTest extends TestCase
{
    #[Test]
    #[DataProvider('defaultValueProvider')]
    public function defaultValue(string $parameter, int|string $value): void
    {
        $defaultValue = new DefaultValue($parameter, $value);
        self::assertSame($parameter, $defaultValue->getParameter());
        self::assertSame((string) $value, $defaultValue->getValue());
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
}