<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait RouteTrait
{
    public function getName(): string
    {
        $name = '';

        if (defined(self::class . '::PREFIX')) {
            $name .= self::PREFIX . (defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.');
        }

        return $name .= $this->name;
    }

    public function getRouteName(): string
    {
        $name = '';

        if (defined( self::class . '::GROUP')) {
            $name .= self::GROUP . (defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.');
        }

        return $name . $this->getName();
    }

    /** @internal */
    public function getUri(): string
    {
        return $this->value;
    }
}