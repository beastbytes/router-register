<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Id extends Parameter
{
    public function __construct(string $name)
    {
        parent::__construct(
            name: $name,
            pattern: '[1-9]\d*'
        );
    }
}