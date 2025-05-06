<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait GroupTrait
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getPrefix(): string
    {
        return '/' . $this->name;
    }

    public function getNamePrefix(): string
    {
        return $this->name . '_';
    }
}