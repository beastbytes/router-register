<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Tests\resources\Enum\TestGroup;
use BeastBytes\Router\Register\Tests\resources\Enum\TestGroupWithPrefix;
use BeastBytes\Router\Register\Tests\resources\Enum\TestRoute;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TraitTest extends TestCase
{
    #[Test]
    public function group(): void
    {
        self::assertSame('group1', TestGroup::group1->name);
        self::assertSame('group1.', TestGroup::group1->getNamePrefix());
        self::assertSame('/g1', TestGroup::group1->getRoutePrefix());
    }

    #[Test]
    public function group_with_prefix(): void
    {
        self::assertSame('group1', TestGroupWithPrefix::group1->name);
        self::assertSame('group1.', TestGroupWithPrefix::group1->getNamePrefix());
        self::assertSame('/example/{locale:[a-z]{2}}/g1', TestGroupWithPrefix::group1->getRoutePrefix());
    }

    #[Test]
    public function route(): void
    {
        self::assertSame('route_1', TestRoute::route_1->name);
        self::assertSame('/route-1', TestRoute::route_1->value);
    }
}