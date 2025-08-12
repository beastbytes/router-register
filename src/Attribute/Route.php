<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\RouteInterface;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements RouteAttributeInterface
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
        return $this->route->getName();
    }

    public function getPrefix(): ?string
    {
        return defined($this->route::class . '::PREFIX')
            ? $this->route::PREFIX
            : null
        ;
    }

    public function getUri(): string
    {
        return $this->route->getUri();
    }
}