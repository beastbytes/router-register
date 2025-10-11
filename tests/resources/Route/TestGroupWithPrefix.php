<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum TestGroupWithPrefix: string implements GroupInterface
{
    use GroupTrait;

    public const PREFIX = [
        'example',
        'locale' => '[a-z]{2}'
    ];

    case group1 = 'g1';
    case group2 = '';
}
