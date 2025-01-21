<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\Attribute\Route;

#[Group(prefix: '/admin')]
class ItemController
{
    #[Get(route: ItemRoute::item_index)]
    public function index(): void
    {
    }

    #[Route(methods: [Method::GET, Method::POST],route: ItemRoute::item_update)]
    #[Uuid(name: 'itemId')]
    public function update(): void
    {
    }

    #[Get(route: ItemRoute::item_view)]
    #[Uuid(name: 'itemId')]
    public function view(): void
    {
    }
}