<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Group implements RouteAttributeInterface
{
    public function __construct(
        private ?string $prefix = null,
        private array $hosts = [],
        private array|string|null $cors = null,
        private array $middleware = [],
        private array $disabledMiddleware = [],
        private ?string $namePrefix = null,
    )
    {
    }

    public function getCors(): array|string|null
    {
        return $this->cors;
    }

    public function getDisabledMiddleware(): array
    {
        return $this->disabledMiddleware;
    }

    public function getHosts(): array
    {
        return $this->hosts;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getNamePrefix(): ?string
    {
        return $this->namePrefix;
    }

    public function getName(): ?string
    {
        if (is_string($this->prefix)) {
            return trim($this->prefix, '/');
        }

        return null;
    }

    public function getPrefix(): string
    {
        return $this->prefix ?? '';
    }
}