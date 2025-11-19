<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\Tests\resources\Middleware\ClassLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;

// Routes in this controller are in the default group and have some class attributes
#[Group(prefix: false)]
#[Host('https://www.example1.com')]
#[Host('https://www.example2.com')]
#[Middleware(ClassLevelMiddleware::class)]
#[Middleware('fn (' . ClassLevelMiddleware::class . ' $middleware) => $middleware->withParameter("class")')]
#[Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)]
class ClassAttributesController
{
    #[Get(route: ClassAttributesRoute::method1)]
    public function method1(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method2)]
    public function method2(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method3)]
    #[Id(name: 'testId')]
    public function method3(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method4)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method4(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method5)]
    #[Id(name: 'testId')]
    #[Uuid(name: 'userId')]
    public function method5(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method6)]
    #[Id(name: 'testId')]
    #[Middleware(MethodLevelMiddleware::class)]
    #[Middleware('fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")')]
    public function method6(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method7)]
    #[Id(name: 'testId')]
    #[Host('https://www.example.com')]
    public function method7(): void
    {
    }

    #[Get(route: ClassAttributesRoute::method8)]
    #[Id(name: 'testId')]
    #[Host('https://www.example.com')]
    #[Middleware(MethodLevelMiddleware::class)]
    #[Middleware('fn (' . MethodLevelMiddleware::class . ' $middleware) => $middleware->withParameter("test")')]
    public function method8(): void
    {
    }
}