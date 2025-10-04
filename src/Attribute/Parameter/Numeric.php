<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Numeric extends Parameter
{
    use LengthTrait;

    public function __construct(
        string $name,
        array|int|null $length = null,
        bool $nonZero = false
    )
    {
        $pattern = '\d';

        if ($nonZero) {
            $pattern = '[1-9]' . $pattern;
        }

        parent::__construct(
            name: $name,
            pattern: $pattern . $this->getLength($length, $nonZero)
        );
    }
}