<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Controller;

use BeastBytes\Router\Register\Route\RouteInterface;

enum ClassAttributesRoute: string implements RouteInterface
{
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
}
