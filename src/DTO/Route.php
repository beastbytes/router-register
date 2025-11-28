<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\DTO;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Pattern;
use BeastBytes\Router\Register\Attribute\Route as RouteAttribute;

/**
 * Route defines a mapping from URL to callback / name and vice versa.
 */
final class Route
{
    private Middleware $action;
    /** @var DefaultValue[] */
    private array $defaultValues = [];
    private ?Fallback $fallback = null;
    private Group $group;
    /** @var Host[] */
    private array $hosts = [];
    /** @var Middleware[] */
    private array $middlewares = [];
    private ?Override $override = null;
    /** @var Pattern[] */
    private array $parameters = [];

    /**
     * @internal
     * @param RouteAttribute $route
     * @return self
     */
    public static function create(RouteAttribute $route): self
    {
        return new self($route);
    }

    private function __construct(private readonly RouteAttribute $route) {
    }

    /**
     * @internal
     * @param Middleware $action
     * @return self
     */
    public function action(Middleware $action): self
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @internal
     * @param DefaultValue[] $defaultValues
     * @return self
     */
    public function defaultValues(array $defaultValues): self
    {
        $this->defaultValues = $defaultValues;
        return $this;
    }

    /**
     * @internal
     * @param ?Fallback $fallback
     * @return self
     */
    public function fallback(?Fallback $fallback): self
    {
        $this->fallback = $fallback;
        return $this;
    }

    public function getAction(): Middleware
    {
        return $this->action;
    }

    public function getDefaultValues(): array
    {
        return $this->defaultValues;
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

    public function getMethods(): array
    {
        return $this->route->getMethods();
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
        return ($this->isHoisted() ? $this->group->getName() . '.' : '') . $this->route->getName();
    }

    public function getPattern(): string
    {
        $pattern = $this->route->getPattern();

        if ($this->isHoisted()) {
            $pattern = mb_substr($pattern, 1);
        }

        if (count($this->parameters) > 0) {
            $replacements = [];

            foreach ($this->parameters as $parameter) {
                $name = $parameter->getName();
                $replacements[sprintf('{%s}', $name)]
                    = sprintf('{%s:%s}', $name, $parameter->getPattern());
            }

            $pattern = strtr($pattern, $replacements);
        }

        return $pattern;
    }

    /**
     * @internal
     */
    public function getPrefix(): string
    {
        return $this->route->getPrefix();
    }

    public function getRoute(): RouteAttribute
    {
        return $this->route;
    }

    /**
     * @internal
     */
    public function group(Group $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function hasDefaultValues(): bool
    {
        return count($this->defaultValues) > 0;
    }

    public function hasHosts(): bool
    {
        return count($this->hosts) > 0;
    }

    /**
     * @internal
     * @param Host[] $hosts
     * @return self
     */
    public function hosts(array $hosts): self
    {
        $this->hosts = $hosts;
        return $this;
    }

    public function isFallback(): bool
    {
        return $this->fallback instanceof Fallback;
    }

    public function isHoisted(): bool
    {
        return $this->route->isHoisted();
    }

    public function isOverride(): bool
    {
        return $this->override instanceof Override;
    }

    /**
     * @internal
     * @param Middleware[] $middlewares
     * @return self
     */
    public function middlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @internal
     * @param ?Override $override
     * @return self
     */
    public function override(?Override $override): self
    {
        $this->override = $override;
        return $this;
    }

    /**
     * @internal
     * @param Pattern[] $parameters
     * @return self
     */
    public function parameters(array $parameters): self
    {
        $this->parameters = $parameters;
        return $this;
    }
}