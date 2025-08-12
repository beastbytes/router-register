<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define middleware for a group.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final class GroupMiddleware implements ClassAttributeInterface
{
    use MiddlewareTrait;
}