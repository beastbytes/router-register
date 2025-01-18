<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute;

use Attribute;

/**
 * Adds a prefix to the route and optionally the name of all routes in a class
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class Prefix implements ClassAttributeInterface
{
    public function __construct(
        private string $routePrefix,
        private ?string $namePrefix,
    )
    {
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function getRoutePrefix(): string
    {
        return $this->routePrefix;
    }
}