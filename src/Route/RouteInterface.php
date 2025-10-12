<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

interface RouteInterface
{
    public function getRouteName(): string;
}