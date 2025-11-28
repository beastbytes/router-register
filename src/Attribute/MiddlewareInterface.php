<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

interface MiddlewareInterface extends AttributeInterface
{
    public function getMiddleware(): string;
    public function isDisable(): bool;
}