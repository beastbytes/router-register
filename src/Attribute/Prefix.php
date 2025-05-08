<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Adds a prefix to the route and optionally the name of all routes in a class
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Prefix implements ClassAttributeInterface
{
    public function __construct(
        private readonly ?string $name = null,
        private readonly ?string $prefix = null,
        private readonly ?string $namePrefix = null,
    )
    {
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix ?? $this->name . '_';
    }

    public function getPrefix(): ?string
    {
        return $this->prefix ?? '/' . $this->name;
    }
}