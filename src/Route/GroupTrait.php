<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

trait GroupTrait
{
    /** @internal */
    public function getNamePrefix(): string
    {
        return $this->name . '.';
    }

    /** @internal */
    public function getRoutePrefix(): string
    {
        $prefixes = [];

        if (defined(self::class . '::PREFIX')) {
            foreach (self::class::PREFIX as $parameter => $pattern) {
                $prefixes[] = is_int($parameter) ? $pattern : sprintf('{%s:%s}', $parameter, $pattern);
            }
        }

        return (sizeof($prefixes) > 0 ? '/' . implode('/', $prefixes) : '')
            . (mb_strlen($this->value) > 0 ? $this->value : '')
        ;
    }
}