<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Tests\resources\Enum\Group;
use BeastBytes\Router\Register\Tests\resources\Enum\GroupWithPrefix;
use BeastBytes\Router\Register\Tests\resources\Enum\RouteGroupWithPrefix;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TraitTest extends TestCase
{
    #[Test]
    public function group(): void
    {
        self::assertSame('group1', Group::group1->name);
        self::assertSame('/g1', Group::group1->getPrefix());
    }

    #[Test]
    public function group_with_prefix(): void
    {
        self::assertSame('group1', GroupWithPrefix::group1->name);
        self::assertSame('/example/{locale:[a-z]{2}}/g1', GroupWithPrefix::group1->getPrefix());
    }

    #[Test]
    public function route(): void
    {
        self::assertSame('/prefix', RouteGroupWithPrefix::route_1->getPrefix());
    }
}