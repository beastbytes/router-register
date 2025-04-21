<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Uuid extends Parameter
{
    public function __construct(
        string $name,
        AlphaCase $case = AlphaCase::insensitive,
        bool $optional = false,
    )
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-fA-F',
            AlphaCase::lower => 'a-f',
            AlphaCase::upper => 'A-F',
        };

        parent::__construct(
            name: $name,
            pattern: "[\d$alpha]{8}-[\d$alpha]{4}-[\d$alpha]{4}-[\d$alpha]{4}-[\d$alpha]{12}",
            optional: $optional
        );
    }
}