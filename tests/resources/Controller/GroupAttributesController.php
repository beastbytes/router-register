<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\GetPost;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;

class GroupAttributesController
{
    #[Get(route: GroupAttributesRoute::method1)]
    public function method1(): void
    {
    }

    #[GetPost(GroupAttributesRoute::method2)]
    #[Id(name: 'id')]
    public function method2(): void
    {
    }

    #[Get(route: GroupAttributesRoute::method3)]
    #[Id(name: 'id')]
    #[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
    public function method3(): void
    {
    }
}