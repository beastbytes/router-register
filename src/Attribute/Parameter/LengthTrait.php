<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use RuntimeException;

trait LengthTrait
{
    private function getLength(array|int|null $length, bool $nonZero = false): string
    {
        if ($length === null) {
            return $nonZero ? '*' : '+';
        }

        if (is_int($length)) {
            if ($length > 0) {
                if ($nonZero) {
                    return '{' . ($length - 1) . '}';
                }

                return '{' . $length . '}';
            }

            throw new RuntimeException('Integer values for $length must be > 0');
        }

        [$min, $max] = $length;

        if ((is_int($min) && $min < 0) || (is_int($min) && $max < 0)) {
            throw new RuntimeException('Integer values for `min` and `max` must be >= 0');
        }
        if (is_int($min) && is_int($max) && $max <= $min) {
            throw new RuntimeException('`max` must be > `min`');
        }

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