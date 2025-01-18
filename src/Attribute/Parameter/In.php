<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class In extends Parameter
{
    public function __construct(string $name, ...$option)
    {
        parent::__construct(
            name: $name,
            pattern: '[' . implode('|', $option) . ']'
        );
    }
}