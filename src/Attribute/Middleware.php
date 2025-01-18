<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute;

use Attribute;

/**
 * Define a middleware for all routes in class
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Middleware implements ClassAttributeInterface
{
    public function __construct(
        private array|string $middleware
    )
    {
    }

    public function getMiddleware(): array|string
    {
        return $this->middleware;
    }
}