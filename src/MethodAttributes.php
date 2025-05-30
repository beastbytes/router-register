<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Parameter;
use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\Attribute\RouteAttributeInterface;
use ReflectionAttribute;
use ReflectionMethod;

final class MethodAttributes
{
    public function __construct(private ReflectionMethod $reflector)
    {
    }

    /** @return list<DefaultValue> */
    public function getDefaults(): array
    {
        return $this->getAttributes(DefaultValue::class);
    }

    public function getFallback(): ?Fallback
    {
        return $this->getAttribute(Fallback::class);
    }

    public function getOverride(): ?Override
    {
        return $this->getAttribute(Override::class);
    }

    /** @return list<Parameter> */
    public function getParameters(): array
    {
        return $this->getAttributes(Parameter::class);
    }

    public function getRoute(): ?Route
    {
        return $this->getAttribute(Route::class);
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