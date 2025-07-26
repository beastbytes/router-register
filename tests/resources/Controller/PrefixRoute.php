<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum PrefixRoute: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'prefix';

    case index = '';
    case update = '/update/{id}';
    case view = '/{id}';
}
