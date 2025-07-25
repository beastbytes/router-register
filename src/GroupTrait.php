<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait GroupTrait
{
    public function getPrefix(): string
    {
        return '/' . $this->name;
    }
}