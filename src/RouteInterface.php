<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

interface RouteInterface
{
    public function getRouteName(): string;
    public function getUri(): string;
}