<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define CORS middleware for a group.
 */
#[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_CLASS_CONSTANT)]
final class Cors implements MiddlewareInterface
{
    use MiddlewareTrait;

    public function __construct(private readonly array|string $middleware)
    {
    }
}