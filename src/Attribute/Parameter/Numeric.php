<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Numeric extends Parameter
{
    public function __construct(
        string $name,
        int $length = 0,
        bool $nonZero = false,
    )
    {
        if ($nonZero) {
            $pattern = '[1-9]\d' . ($length === 0 ? '*' : '{' . (string) (abs($length) - 1) . '}');
        } else {
            $pattern = '\d' . ($length === 0 ? '+' : '{' . abs($length) . '}');
        }


        parent::__construct(
            name: $name,
            pattern: $pattern
        );
    }
}