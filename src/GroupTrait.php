<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait GroupTrait
{
    /** @internal */
    public function getPrefix(): string
    {
        return $this->name;
    }

    /** @internal */
    public function getSeparator(): string
    {
        return defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.';
    }
}