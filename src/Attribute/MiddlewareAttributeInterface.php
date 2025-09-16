<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

interface MiddlewareAttributeInterface
{
    public function getMiddleware(): array|string;
}