<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Pattern;
use BeastBytes\Router\Register\Attribute\Route;
use ReflectionAttribute;
use ReflectionMethod;

final class MethodAttributes
{
    public function __construct(private ReflectionMethod $reflector)
    {
    }

    /** @return list<DefaultValue> */
    public function getDefaultValues(): array
    {
        return $this->getAttributes(DefaultValue::class);
    }

    public function getFallback(): ?Fallback
    {
        return $this->getAttribute(Fallback::class);
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(Host::class);
    }

    /** @return list<Middleware> */
    public function getMiddlewares(): array
    {
        return $this->getAttributes(Middleware::class);
    }

    public function getOverride(): ?Override
    {
        return $this->getAttribute(Override::class);
    }

    /** @return list<Pattern> */
    public function getParameters(): array
    {
        return $this->getAttributes(Pattern::class);
    }

    public function getRoute(): ?Route
    {
        return $this->getAttribute(Route::class);
    }

    private function getAttribute(string $attributeClass): null|DefaultValue|Fallback|Host|Middleware|Pattern|Override|Route
    {
        $attributes = $this->getAttributes($attributeClass);

        return count($attributes) === 0 ? null : $attributes[0];
    }

    /** @return list<DefaultValue|Fallback|Host|Middleware|Pattern|Override|Route> */
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