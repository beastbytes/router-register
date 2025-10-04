<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

trait LengthTrait
{
    private function getLength(array|int|null $length, bool $nonZero = false): string
    {
        if ($length === null) {
            return $nonZero ? '*' : '+';
        }

        if (is_int($length)) {
            if ($nonZero) {
                return '{' . ($length - 1) . '}';
            }

            return '{' . $length . '}';
        }

        [$min, $max] = $length;

        if ($nonZero) {
            if (is_int($min) && $min > 0) {
                --$min;
            }
            if (is_int($max) && $max > 0) {
                --$max;
            }
        }

        return '{' . ($min ?? '') . ',' . ($max ?? '') . '}';
    }
}