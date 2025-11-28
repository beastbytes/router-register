<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Route\RouteInterface;
use ReflectionAttribute;
use ReflectionClass;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements AttributeInterface
{
    /**
     * @param list<Method> $methods
     * @param RouteInterface $route
     */
    public function __construct(
        private readonly array $methods,
        private readonly RouteInterface $route,
    )
    {
    }

    /**
     * @return list<string>
     */
    public function getMethods(): array
    {
        $methods = [];

        foreach ($this->methods as $method) {
            $methods[] = $method->name;
        }

        return $methods;
    }

    public function getName(): string
    {
        return $this->route->name;
    }

    public function getPrefix(): string
    {
        $reflectionClass = new ReflectionClass($this->route);
        $prefix = $reflectionClass->getAttributes(Prefix::class, ReflectionAttribute::IS_INSTANCEOF);

        if (sizeof($prefix) > 0) {
            return $prefix[0]->getPrefix();
        }

        return '';
    }

    public function getPattern(): string
    {
        return $this->route->value;
    }

    public function getRoute(): RouteInterface
    {
        return $this->route;
    }

    public function isHoisted(): bool
    {
        return $this->route->isHoisted();
    }
}