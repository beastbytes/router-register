<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Route\RouteInterface;

enum GroupAttributesRoute: string implements RouteInterface
{
    case method1 = '';
    case method2 = '/method2/{id}';
    case method3 = '/{id}';
}
