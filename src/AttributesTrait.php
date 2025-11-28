<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\AttributeInterface;
use ReflectionAttribute;

trait AttributesTrait
{
    private function getAttribute(string $attributeClass): ?AttributeInterface
    {
        $attributes = $this->getAttributes($attributeClass);

        return count($attributes) === 0 ? null : $attributes[0];
    }

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