<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Routes\Attribute\DefaultValue;
use BeastBytes\Router\Routes\Attribute\Host;
use BeastBytes\Router\Routes\Attribute\Middleware;
use BeastBytes\Router\Routes\Attribute\Prefix;
use BeastBytes\Router\Routes\Attribute\RouteAttributeInterface;
use ReflectionAttribute;
use ReflectionClass;

readonly class ClassAttributes
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