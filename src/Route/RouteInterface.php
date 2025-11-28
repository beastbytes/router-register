<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

use BackedEnum;

interface RouteInterface extends BackedEnum
{
    public function getRouteName(): string;

    public function isHoisted(): bool;
}