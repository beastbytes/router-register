<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes;

interface RouteInterface
{
    public function getName(): string;
    public function getUri(): string;
}