<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define middleware for all routes in a class or method route.
 * To define a parent group middleware that should not be invoked, set the `disable` parameter to `true`.
 */

trait MiddlewareTrait
{
    public function getMiddleware(): string
    {
        if (is_array($this->middleware)) {
            return "{$this->array2String($this->middleware)}";
        } elseif (
            str_starts_with($this->middleware, 'fn')
            || str_starts_with($this->middleware, 'function')
        ) {
            return "$this->middleware";
        } else {
           return "'$this->middleware'";
        }
    }

    public function isDisable(): bool
    {
        return $this->disable;
    }

    private function array2String(array $ary): string
    {
        $elements = [];

        foreach ($ary as $k => $v) {
            $element = is_string($k) ? "'$k' => " : '';

            if (is_array($v)) {
                $element .= $this->array2String($v);
            } elseif (is_string($v)) {
                $element .= "'$v'";
            } else {
                $element .= "$v";
            }

            $elements[] = $element;
        }

        return  sprintf('[%s]', implode(', ', $elements));
    }
}