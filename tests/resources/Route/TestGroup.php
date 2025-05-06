<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Route;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum TestGroup implements GroupInterface
{
    use GroupTrait;

    case group1;
    case group2;
}
