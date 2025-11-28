<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define a host for a group or route
 */
#[Attribute(
    Attribute::TARGET_CLASS
    | Attribute::TARGET_CLASS_CONSTANT
    | Attribute::TARGET_METHOD
    | Attribute::IS_REPEATABLE
)]
final class Host implements AttributeInterface
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