<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;

class TestController
{
    #[Get(route: TestRoute::test_method1)]
    public function method1(): void
    {
    }

    #[Get(route: TestRoute::test_method2)]
    #[Id(name: 'testId')]
    public function method2(): void
    {
    }

    #[Get(route: TestRoute::test_method3)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method3(): void
    {
    }

    #[Get(route: TestRoute::test_method4)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId', optional: true)]
    public function method4(): void
    {
    }
}