<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use BeastBytes\Router\Register\GroupInterface;

#[Attribute(Attribute::TARGET_CLASS)]
final class Group implements RouteAttributeInterface
{
    public function __construct(private readonly GroupInterface $group)
    {
    }

    public function getName(): string
    {
        return $this->group->getName();
    }

    public function getRoutePrefix(): ?string
    {
        return $this->group->getRoutePrefix();
    }

    public function getNamePrefix(): ?string
    {
        return $this->group->getNamePrefix();
    }
}