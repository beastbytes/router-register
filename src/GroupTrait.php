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
        return (defined(self::class . '::PREFIX') ? '/' . self::class::PREFIX: '') . '/' . $this->value;
    }
}