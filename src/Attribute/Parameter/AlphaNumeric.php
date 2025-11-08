<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class AlphaNumeric extends Pattern
{
    use LengthTrait;

    public function __construct(
        string $name,
        array|int|null $length = null,
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
            pattern: '[\d' . $alpha . ']' . $this->getLength($length)
        );
    }
}