<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum ItemRoute: string implements RouteInterface
{
    use RouteTrait;

    case item_index = '/index';
    case item_update = '/item/update/{itemId}';
    case item_view = '/item/{itemId}';
}
