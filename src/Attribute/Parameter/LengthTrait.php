<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

use RuntimeException;

trait LengthTrait
{
    /**
     * @param array|int|null $length
     * @psalm-param array{min?: int, max?: int}|int|null $length
     * @param bool $adjust
     * @return string
     */
    private function getLength(array|int|null $length, bool $adjust = false): string
    {
        if (is_array($length)) {
            $max = $min = null;

            if (isset($length['max'])) {
                if (!is_int($length['max'])) {
                    throw new RuntimeException("\$length['max'] must be an integer");
                } elseif($length['max'] < 0) {
                    throw new RuntimeException("\$length['mav'] must be >= 0");
                } else {
                    $max = $length['max'] - (int) $adjust;
                }
            }

            if (isset($length['min'])) {
                if (!is_int($length['min'])) {
                    throw new RuntimeException("\$length['min'] must be an integer");
                } elseif($length['min'] < 0) {
                    throw new RuntimeException("\$length['min'] must be >= 0");
                } else {
                    $min = $length['min'] - (int) $adjust;
                }
            }

            if (isset($length['max']) && isset($length['min']) && $length['max'] <= $length['min']) {
                throw new RuntimeException("\$length['max'] must be > \$length['min']");
            }

            return '{' . ($min ?? '') . ',' . ($max ?? '') . '}';
        }

        if (is_int($length)) {
            if ($length <= 0) {
                throw new RuntimeException('Integer values for $length must be > 0');
            }

            return '{' . ($length - (int) $adjust) . '}';
        }

        return $adjust ? '*' : '+';
    }
}