<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Alpha extends Parameter
{
    public function __construct(
        string $name,
        int $length = 0,
        AlphaCase $case = AlphaCase::insensitive
    )
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-zA-Z',
            AlphaCase::lower => 'a-z',
            AlphaCase::upper => 'A-Z',
        };

        parent::__construct(
            name: $name,
            pattern: '[' . $alpha . ']'
                . (
                    $length === 0
                    ? '+'
                    : '{' . abs($length) . '}'
                )
        );
    }
}