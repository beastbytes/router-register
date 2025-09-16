<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define middleware for all routes in a class or method route.
 * To define a parent group middleware that should not be invoked, set the `disable` parameter to `true`.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Middleware implements ClassAttributeInterface, MiddlewareAttributeInterface
{
   use MiddlewareTrait;
}