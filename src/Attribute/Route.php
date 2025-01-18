<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute;

use BeastBytes\Router\Routes\Attribute\Method\Method;
use BeastBytes\Router\Routes\RouteInterface;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements RouteAttributeInterface
{
    /** @var list<callable|string> */
    private array $disableMiddleware = [];
    /** @var list<string> */
    private array $hosts = [];
    /** @var list<callable|string> */
    private array $middleware = [];

    /**
     * @param list<Method> $methods
     * @param RouteInterface $route
     * @param list<string> $hosts
     * @param list<callable|string> $middleware
     * @param list<callable|string> $disableMiddleware
     */
    public function __construct(
        private readonly array $methods,
        private readonly RouteInterface $route,
        array|string $hosts = [],
        array|callable|string $middleware = [],
        array|callable|string $disableMiddleware = [],
    )
    {
        $this->hosts = is_array($hosts) ? $hosts : [$hosts];
        $this->middleware = is_array($middleware) ? $middleware : [$middleware];
        $this->disableMiddleware = is_array($disableMiddleware) ? $disableMiddleware : [$disableMiddleware];
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

    /**
     * @return list<string>
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }

    /**
     * @return list<callable|string>
     */
    public function getDisableMiddleware(): array
    {
        return $this->disableMiddleware;
    }

    /**
     * @return list<callable|string>
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getName(): string
    {
        return $this->route->getName();
    }

    public function getUri(): string
    {
        return $this->route->getUri();
    }
}