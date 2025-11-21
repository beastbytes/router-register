<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

interface MiddlewareInterface
{
    public function getMiddleware(): string;
    public function isDisable(): bool;
}