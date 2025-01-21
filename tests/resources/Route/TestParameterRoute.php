<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum TestParameterRoute: string implements RouteInterface
{
    use RouteTrait;

    case alpha_parameter = '/alpha/{alpha}';
    case alpha_numeric_parameter = '/alpha_numeric/{alphaNumeric}';
    case hex_parameter = '/hex/{hex}';
    case id_parameter = '/id/{id}';
    case in_parameter = '/in/{in}';
    case numeric_parameter = '/numeric/{numeric}';
    case pattern_parameter = '/pattern/{pattern}';
    case uuid_parameter = '/uuid/{uuid}';
}