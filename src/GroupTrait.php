<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait GroupTrait
{
    public function getNamePrefix(): string
    {
        return $this->name . (defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.');
    }

    public function getPrefix(): string
    {
        return $this->name;
    }
}