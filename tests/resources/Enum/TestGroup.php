<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Enum;

use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Route\GroupTrait;

enum TestGroup: string implements GroupInterface
{
    use GroupTrait;

    case group1 = '/g1';
    case group2 = '/g2';
}
