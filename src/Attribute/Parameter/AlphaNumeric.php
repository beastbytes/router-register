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
        FirstChar $firstChar = FirstChar::alphaNumeric,
        AlphaCase $case = AlphaCase::insensitive
    )
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-zA-Z',
            AlphaCase::lower => 'a-z',
            AlphaCase::upper => 'A-Z',
        };

        $pattern = match ($firstChar) {
            FirstChar::alpha => "[$alpha][\d$alpha]",
            FirstChar::alphaNumeric => "[\d$alpha]",
            FirstChar::numeric => "\d[\d$alpha]",
        };

        parent::__construct(
            name: $name,
            pattern: $pattern . $this->getLength($length, ($firstChar !== FirstChar::alphaNumeric))
        );
    }
}