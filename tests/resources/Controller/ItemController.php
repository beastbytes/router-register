<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\Tests\resources\Middleware\Middleware1;
use BeastBytes\Router\Register\Tests\resources\Route\TestGroup;

#[Group(group: TestGroup::group1, middleware: Middleware1::class)]
#[Prefix(namePrefix: 'item_')]
class ItemController
{
    #[Get(route: ItemRoute::index)]
    public function index(): void
    {
    }

    #[Route(methods: [Method::GET, Method::POST],route: ItemRoute::update)]
    #[Uuid(name: 'itemId')]
    public function update(): void
    {
    }

    #[Get(route: ItemRoute::view)]
    #[Uuid(name: 'itemId')]
    public function view(): void
    {
    }
}