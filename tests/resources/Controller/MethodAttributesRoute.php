<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum MethodAttributesRoute: string implements RouteInterface
{
    use RouteTrait;

    public const PREFIX = 'method-attributes';

    case method1 = '';
    case method2 = '/method2';
    case method3 = '/method3/{testId}';
    case method4 = '/method4/{testId}/{userId}';
    case method5 = '/method5/{testId}[/{userId}]';
    case method6 = '/method6/{testId}';
    case method7 = '/method7/{testId}';
    case method8 = '/method8/{testId}';
    case method9 = '/method9/{testId}';
    case method10 = '/method10/{testId}';
    case method11 = '/method11/{testId}';
    case method12 = '/method12/{testId}';
    case method13 = '/method13/{testId}';
    case method14 = '//method14';
}
