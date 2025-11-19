<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Route\GroupTrait;

enum TestGroupWithPrefix: string implements GroupInterface
{
    use GroupTrait;

    public const PREFIX = [
        'example',
        'locale' => '[a-z]{2}'
    ];

    case group1 = '/g1';
    case group2 = '';
}
