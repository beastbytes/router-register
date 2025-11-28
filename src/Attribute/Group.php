<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use BeastBytes\Router\Register\Route\GroupInterface;

/**
 * Define the group name and optionally the parent group for routes in a Route Enumeration
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Group implements AttributeInterface
{
    public function __construct(private string $name, private readonly ?GroupInterface $parent = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): ?GroupInterface
    {
        return $this->parent;
    }

    public function hasParent(): bool
    {
        return $this->parent instanceof GroupInterface;
    }
}