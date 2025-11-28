<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

use \BackedEnum;

interface GroupInterface extends BackedEnum
{
    public function getPrefix(): ?string;
}