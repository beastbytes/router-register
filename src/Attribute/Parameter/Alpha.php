<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Alpha extends Parameter
{
    use AlphaTrait;

    public function __construct(
        string $name,
        int $length = 0,
        bool $underscore = true,
        AlphaCase $case = AlphaCase::Insensitive
    )
    {
        parent::__construct(
            name: $name,
            pattern: '[' . $this->getAlpha($case, $underscore) . ']'
                . (
                    $length === 0
                    ? '+'
                    : '{' . abs($length) . '}'
                )
        );
    }
}