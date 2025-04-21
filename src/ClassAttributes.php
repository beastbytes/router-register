<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Prefix;
use BeastBytes\Router\Register\Attribute\RouteAttributeInterface;
use ReflectionAttribute;
use ReflectionClass;

final class ClassAttributes
{
    public function __construct(private ReflectionClass $reflector)
    {
    }

    /** @return list<DefaultValue> */
    public function getDefaults(): array
    {
        return $this->getAttributes(DefaultValue::class);
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(Host::class);
    }

    public function getPrefix(): ?Prefix
    {
        return $this->getAttribute(Prefix::class);
    }

    /**
     * @return list<Middleware>
     */
    public function getMiddleware(): array
    {
        return $this->getAttributes(Middleware::class);
    }

    private function getAttribute(string $attributeClass): ?RouteAttributeInterface
    {
        $attributes = $this->getAttributes($attributeClass);

        return count($attributes) === 0 ? null : $attributes[0];
    }

    /** @return list<RouteAttributeInterface> */
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