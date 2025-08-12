<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define the name prefix for a group.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class GroupNamePrefix implements ClassAttributeInterface
{
    public function __construct(private readonly string $namePrefix)
    {
    }

    public function getNamePrefix(): string
    {
        return $this->namePrefix;
    }
}