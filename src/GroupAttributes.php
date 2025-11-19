<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\AttributeInterface;
use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\GroupCors;
use BeastBytes\Router\Register\Attribute\GroupHost;
use BeastBytes\Router\Register\Attribute\GroupMiddleware;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use ReflectionAttribute;
use ReflectionClass;

final class GroupAttributes
{
    public function __construct(private ReflectionClass $reflector)
    {
    }

    public function getGroup(): ?Group
    {
        return $this->getAttribute(Group::class);
    }

    public function getCors(): ?GroupCors
    {
        return $this->getAttribute(GroupCors::class);
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(GroupHost::class);
    }

    /** @return list<Middleware> */
    public function getMiddlewares(): array
    {
        return $this->getAttributes(GroupMiddleware::class);
    }

    private function getAttribute(string $attributeClass): null|Group|GroupCors|AttributeInterface
    {
        $attributes = $this->getAttributes($attributeClass);

        return count($attributes) === 0 ? null : $attributes[0];
    }

    /** @return list<AttributeInterface> */
    private function getAttributes(string $attributeClass): array
    {
        $attributes = $this
            ->reflector
            ->getAttributes($attributeClass, ReflectionAttribute::IS_INSTANCEOF)
        ;

        array_walk(
            $attributes,
            function(ReflectionAttribute &$attribute): void
            {
                $attribute = $attribute->newInstance();
            }
        );

        return $attributes;
    }
}