<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\Cors;
use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Prefix;
use ReflectionClass;
use ReflectionEnumBackedCase;

final class GroupAttributes
{
    use AttributesTrait;

    public function __construct(private ReflectionEnumBackedCase|ReflectionClass $reflector)
    {
    }

    public function getGroup(): ?Group
    {
        return $this->getAttribute(Group::class);
    }

    public function getCors(): ?Cors
    {
        return $this->getAttribute(Cors::class);
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(Host::class);
    }

    public function getMiddlewares(): array
    {
        return $this->getAttributes(Middleware::class);
    }

    public function getPrefix(): ?Prefix
    {
        return $this->getAttribute(Prefix::class);
    }
}