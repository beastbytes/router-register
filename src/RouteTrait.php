<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait RouteTrait
{
    public function getRouteName(): string
    {
        $name = [];

        if (defined(self::GROUP)) {
            $name[] = self::GROUP;
        }
        if (defined(self::PREFIX)) {
            $name[] = self::PREFIX;
        }
        $name[] = $this->name;

        return implode(defined(self::SEPARATOR) ? self::SEPARATOR : '.', $name);
    }

    public function getUri(): string
    {
        return $this->value;
    }
}