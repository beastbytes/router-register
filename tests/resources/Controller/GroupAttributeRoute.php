<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum GroupAttributeRoute: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'group-attribute';

    case method1 = '';
    case method2 = '/method2/{id}';
    case method3 = '/{id}';
}
