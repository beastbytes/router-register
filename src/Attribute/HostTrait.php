<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

/**
 * Define a host
 */
trait HostTrait
{
    public function __construct(
        private readonly string $host
    )
    {
    }

    public function getHost(): string
    {
        return $this->host;
    }
}