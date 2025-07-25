<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\Attribute\Prefix;

class TestController
{
    #[Prefix('test')]
    #[Get(route: TestRoute::method1)]
    public function method1(): void
    {
    }

    #[Get(route: TestRoute::method2)]
    #[Id(name: 'testId')]
    public function method2(): void
    {
    }

    #[Get(route: TestRoute::method3)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method3(): void
    {
    }

    #[Get(route: TestRoute::method4)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method4(): void
    {
    }
}