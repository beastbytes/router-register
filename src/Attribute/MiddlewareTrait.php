<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define middleware for all routes in a class or method route.
 * To define a parent group middleware that should not be invoked, set the `disable` parameter to `true`.
 */

trait MiddlewareTrait
{
    public const DISABLE = true;

    public function __construct(
        private readonly array|string $middleware,
        private readonly bool $disable = !self::DISABLE,
    )
    {
    }

    public function getMiddleware(): array|string
    {
        return $this->middleware;
    }

    public function disable(): bool
    {
        return $this->disable;
    }
}