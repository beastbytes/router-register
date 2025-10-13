<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\GroupCors;
use BeastBytes\Router\Register\Attribute\GroupHost;
use BeastBytes\Router\Register\Attribute\GroupMiddleware;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\GetPost;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Tests\resources\Middleware\ClassLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\CorsMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Trait\TestGroup;

#[Group(TestGroup::group1)]
#[GroupHost('www.example1.com')]
#[GroupCors(CorsMiddleware::class)]
#[GroupMiddleware(GroupLevelMiddleware::class)]
#[Middleware(ClassLevelMiddleware::class)]
class GroupAttributeController
{
    #[Get(route: GroupAttributeRoute::method1)]
    public function method1(): void
    {
    }

    #[GetPost(GroupAttributeRoute::method2)]
    #[Id(name: 'id')]
    public function method2(): void
    {
    }

    #[Get(route: GroupAttributeRoute::method3)]
    #[Id(name: 'id')]
    #[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
    public function method3(): void
    {
    }
}