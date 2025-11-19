<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\AttributeInterface;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use ReflectionAttribute;
use ReflectionClass;

final class ClassAttributes
{
    public function __construct(private ReflectionClass $reflector)
    {
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(Host::class);
    }

    /**
     * @return list<Middleware>
     */
    public function getMiddlewares(): array
    {
        return $this->getAttributes(Middleware::class);
    }

    private function getAttribute(string $attributeClass): null|AttributeInterface
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