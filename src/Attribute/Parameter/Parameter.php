<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Parameter {
    public function __construct(
        private readonly string $name,
        private readonly string $pattern
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }
}