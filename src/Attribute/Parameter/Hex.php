<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Hex extends Pattern
{
    use LengthTrait;

    public function __construct(
        string $name,
        array|int|null $length = null,
        bool $nonZero = false,
        AlphaCase $case = AlphaCase::insensitive
    )
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-fA-F',
            AlphaCase::lower => 'a-f',
            AlphaCase::upper => 'A-F',
        };

        $pattern = '[\d' . $alpha . ']';

        if ($nonZero) {
            $pattern = '[1-9' . $alpha . ']' . $pattern;
        }

        parent::__construct(
            name: $name,
            pattern: $pattern . $this->getLength($length, $nonZero)
        );
    }
}