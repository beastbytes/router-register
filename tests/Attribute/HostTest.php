<?php

namespace BeastBytes\Router\Register\Tests\Attribute;

use BeastBytes\Router\Register\Attribute\Host;
use \Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class HostTest extends TestCase
{
    #[Test]
    #[DataProvider('hostProvider')]
    public function host(string $host): void
    {
        $attribute = new Host($host);
        self::assertSame($host, $attribute->getHost());
    }

    public static function hostProvider(): Generator
    {
        yield ['https://' . Random::string(random_int(5, 10)) . '.com'];
    }
}