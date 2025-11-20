<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\DTO;

use BeastBytes\Router\Register\Attribute\GroupCors;
use BeastBytes\Router\Register\Attribute\GroupHost;
use BeastBytes\Router\Register\Attribute\GroupMiddleware;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;

final class Group
{
    private ?GroupCors $cors = null;
    /** @var list<GroupHost|Host> */
    private array $hosts = [];
    /** @var list<GroupMiddleware|Middleware> */
    private array $middlewares = [];
    /** @var Group[]|Route[] */
    private array $routes = [];

    /**
     * @internal
     * @param string $name
     * @param string|null $prefix
     * @return self
     */
    public static function create(string $name, ?string $prefix = null): self
    {
        return new self($name, $prefix);
    }

    private function __construct(private readonly string $name, private readonly ?string $prefix)
    {
    }

    /**
     * @internal
     * @param ?GroupCors $cors
     * @return self
     */
    public function cors(?GroupCors $cors): self
    {
        $this->cors = $cors;
        return $this;
    }

    public function getCors(): ?GroupCors
    {
        return $this->cors;
    }

    public function getDisableMiddlewares(): array
    {
        return $this->getMiddlewares(Middleware::DISABLE);
    }

    public function getHosts(): array
    {
        $hosts = [];

        foreach ($this->hosts as $host) {
            $hosts[] = $host->getHost();
        }

        return $hosts;
    }

    public function getMiddlewares(bool $disable = false): array
    {
        $middlewares = [];

        foreach ($this->middlewares as $middleware) {
            if ($middleware->isDisable() === $disable) {
                $middlewares[] = $middleware;
            }
        }

        return $middlewares;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function hasCors(): bool
    {
        return $this->cors instanceof GroupCors;
    }

    public function hasHosts(): bool
    {
        return count($this->hosts) > 0;
    }

    /**
     * @internal
     * @param list<GroupHost|Host> $hosts
     * @return self
     */
    public function hosts(array $hosts): self
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * @internal
     * @param list<GroupMiddleware|Middleware> $middlewares
     * @return self
     */
    public function middlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @internal
     * @param Route|Group $route
     * @return self
     */
    public function route(Route|Group $route): self
    {
        $this->routes[] = $route;
        return $this;
    }
}