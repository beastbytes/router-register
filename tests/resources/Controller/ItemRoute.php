<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum ItemRoute: string implements RouteInterface
{
    use RouteTrait;

    case index = '/index';
    case update = '/item/update/{itemId}';
    case view = '/item/{itemId}';
}
