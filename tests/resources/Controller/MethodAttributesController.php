<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\GetPost;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;

// Routes in this controller are in the default group
class MethodAttributesController
{
    #[Get(route: MethodAttributesRoute::method1)]
    public function method1(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method2)]
    public function method2(): void
    {
    }

    #[GetPost(route: MethodAttributesRoute::method3)]
    #[Id(name: 'testId')]
    public function method3(): void
    {
    }

    #[Post(route: MethodAttributesRoute::method4)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method4(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method5)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    #[DefaultValue('userId', value: '00000000-0000-0000-0000-000000000000')]
    public function method5(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method6)]
    #[Id(name: 'testId')]
    #[Middleware(MethodLevelMiddleware::class)]
    public function method6(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method7)]
    #[Id(name: 'testId')]
    #[Middleware(MethodLevelMiddleware::class)]
    #[Middleware('fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")')]
    #[Middleware(['class' => MethodLevelMiddleware::class, '__construct()' => ['someVar' => 42,],])]
    public function method7(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method8)]
    #[Id(name: 'testId')]
    #[Middleware(MethodLevelMiddleware::class)]
    #[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
    public function method8(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method9)]
    #[Id(name: 'testId')]
    #[Host('https://www.example.com')]
    public function method9(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method10)]
    #[Id(name: 'testId')]
    #[Host('https://www.example1.com')]
    #[Host('https://www.example2.com')]
    public function method10(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method11)]
    #[Id(name: 'testId')]
    #[Host('https://www.example1.com')]
    #[Host('https://www.example2.com')]
    #[Middleware(MethodLevelMiddleware::class)]
    #[Middleware('fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")')]
    #[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
    public function method11(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method12)]
    #[Id(name: 'testId')]
    #[Fallback]
    public function method12(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method13)]
    #[Id(name: 'testId')]
    #[Override]
    public function method13(): void
    {
    }

    #[Get(route: MethodAttributesRoute::method14)]
    #[Id(name: 'testId')]
    public function method14(): void
    {
    }
}