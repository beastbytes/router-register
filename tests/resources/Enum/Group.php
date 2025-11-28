<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Attribute\Cors;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Route\GroupTrait;
use BeastBytes\Router\Register\Tests\resources\Middleware\CorsMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;

#[Host('https://www.example.com')]
enum Group: string implements GroupInterface
{
    use GroupTrait;

    #[Cors(CorsMiddleware::class)]
    #[Middleware(GroupLevelMiddleware::class)]
    case group1 = '/g1';
    case group2 = '/g2';
}
