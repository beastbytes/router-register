<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait GroupTrait
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getNamePrefix(): string
    {
        return $this->name . (defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.');
    }

    public function getRoutePrefix(): string
    {
        return  $this->commonPrefix() . '/' . $this->value;
    }

    private function commonPrefix(): string
    {
        if (defined(self::class . '::PREFIX')) {
            $prefixes = [];

            foreach (self::class::PREFIX as $parameter => $pattern) {
                $prefixes[] = is_int($parameter) ? $pattern : sprintf('{%s:%s}', $parameter, $pattern);
            }

            return '/' . implode('/', $prefixes);
        }

        return '';
    }
}