<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Defines a default value for a route parameter at a class or method level.
 * The method attribute takes precedence over a class attribute.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final readonly class DefaultValue implements ClassAttributeInterface
{
    public function __construct(
        private string $parameter,
        private string $value,
    )
    {
    }

    public function getParameter(): string
    {
        return $this->parameter;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}