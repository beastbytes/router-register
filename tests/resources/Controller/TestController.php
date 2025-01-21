<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;

class TestController
{
    #[Get(route: TestRoute::test_index)]
    public function index(): void
    {
    }

    #[Get(route: TestRoute::test_user)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function user(): void
    {
    }

    #[Get(route: TestRoute::test_view)]
    #[Id(name: 'testId')]
    public function view(): void
    {
    }
}