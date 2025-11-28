<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define a middleware for a group or route.
 * To define a parent group middleware that should not be invoked, set the `disable` parameter to `true`.
 */
#[Attribute(
    Attribute::TARGET_CLASS
    | Attribute::TARGET_CLASS_CONSTANT
    | Attribute::TARGET_METHOD
    | Attribute::IS_REPEATABLE
)]
final class Middleware implements MiddlewareInterface
{
    use MiddlewareTrait;

    public const DISABLE = true;

    public function __construct(
        private readonly array|string $middleware,
        private readonly bool $disable = !self::DISABLE,
    )
    {
    }
}