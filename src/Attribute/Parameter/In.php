<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class In extends Pattern
{
    public function __construct(
        string $name,
        array $options
    )
    {
        parent::__construct(
            name: $name,
            pattern: '[' . implode('|', $options) . ']'
        );
    }
}