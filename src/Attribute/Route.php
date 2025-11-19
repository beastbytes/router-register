<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use BeastBytes\Router\Register\Attribute\RouteInterface as RouteAttributeInterface;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Route\RouteInterface;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements RouteAttributeInterface
{
    private const HOISTED_ROUTE = '//';

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
        return defined($this->route::class . '::PREFIX')
            ? '/' . $this->route::PREFIX
            : ''
        ;
    }

    public function getPattern(): string
    {
        return $this->route->value;
    }

    public function isHoisted(): bool
    {
        return str_starts_with($this->route->value, self::HOISTED_ROUTE);
    }
}