<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use BeastBytes\Router\Register\Route\GroupInterface;
use RuntimeException;

#[Attribute(Attribute::TARGET_CLASS)]
final class Group implements RouteInterface
{
    private bool|null|string $prefix;

    public function __construct(
        private readonly ?GroupInterface $group = null,
        private readonly ?string $name = null,
        bool|null|string $prefix = null,
    )
    {
        if (is_bool($prefix) && $prefix === true) {
            throw new RuntimeException('`$prefix` must be `false`, `null`, or a string');
        }

        $this->prefix = $prefix;
    }

    public function getGroupName(): ?string
    {
        return $this->group instanceof GroupInterface ? $this->group->name : null;
    }

    public function getGroupPrefix(): ?string
    {
        return $this->group instanceof GroupInterface ? $this->group->getRoutePrefix() : null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrefix(): bool|null|string
    {
        return $this->prefix;
    }
}