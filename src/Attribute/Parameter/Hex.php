<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Hex extends Parameter
{
    public function __construct(
        string $name,
        int $length = 0,
        bool $nonZero = false,
        AlphaCase $case = AlphaCase::Insensitive
    )
    {
        $alpha = match($case) {
            AlphaCase::Insensitive => 'a-fA-F',
            AlphaCase::Lower => 'a-f',
            AlphaCase::Upper => 'A-F',
        };

        if ($nonZero) {
            $pattern = '[1-9' . $alpha . '][\d' . $alpha . ']'
                . ($length === 0 ? '*' : '{' . (string) (abs($length) - 1) . '}');
        } else {
            $pattern = '[\d' . $alpha . ']' . ($length === 0 ? '+' : '{' . abs($length) . '}');
        }

        parent::__construct(
            name: $name,
            pattern: $pattern
        );
    }
}