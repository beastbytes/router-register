<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Group implements RouteAttributeInterface
{
    public function __construct(
        private readonly ?string $prefix = null,
        private readonly array|string $hosts = [],
        private readonly array|string|null $cors = null,
        private readonly array|string $middleware = [],
        private readonly array|string $disabledMiddleware = [],
        private readonly ?string $namePrefix = null,
    )
    {
    }

    public function getCors(): array|string|null
    {
        return $this->cors;
    }

    public function getDisabledMiddleware(): array
    {
        return is_array($this->disabledMiddleware)
            ? $this->disabledMiddleware
            : [$this->disabledMiddleware]
        ;
    }

    public function getHosts(): array
    {
        return is_array($this->hosts)
            ? $this->hosts
            : [$this->hosts]
        ;
    }

    public function getMiddleware(): array
    {
        return is_array($this->middleware)
            ? $this->middleware
            : [$this->middleware]
        ;
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