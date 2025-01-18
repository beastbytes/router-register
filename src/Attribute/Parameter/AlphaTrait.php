<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

trait AlphaTrait
{
    public function getAlpha(AlphaCase $case, bool $underscore): string
    {
        $alpha = match($case) {
            AlphaCase::Insensitive => 'a-zA-Z',
            AlphaCase::Lower => 'a-z',
            AlphaCase::Upper => 'A-Z',
        };

        return $alpha . ($underscore ? '_' : '');
    }
}